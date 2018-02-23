<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 110000);

use Illuminate\Support\Facades\Input;
use Validator;
use File;
use App\Files;
use App\Equipment;
use DB;
use App\LinuxUsersLocal;
use App\LinuxUsersBase;
use App\LinuxUsersAdmin;
use App\LinuxUsersSudo;
use App\LinuxFecter;
use App\LinuxHomedir;
use App\LinuxDiskusage;
use App\LinuxLast;

class ServiceController extends Controller
{
    public function __construct()
    {
    }

    public function lookup()
    {
        $input = Input::all();

        if (empty($input['serial_number'])) {
            return 'Serial number not provided.';
        }

        if ($input['serial_number']) {
            $result = Equipment::where('serial_number', $input['serial_number'])->pluck('equipment_name');
            if ($result) {
                return $result;
            } else {
                return "Serial number {$input['serial_number']} is not associated with any machine.";
            }
        }
    }

    public function store()
    {
        $file = array('file' => Input::file('file'));
        $inputs = Input::all();
        if (empty($inputs['data']['host'])) {
            $hostname = 'NOHOST';
        } else {
            $hostname = $inputs['data']['host'];
        }

        $rules = array('file' => 'required');
        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            echo 'file not attached\n';
        } else {
            if (Input::file('file')->isValid()) {
                $destinationPath = 'uploads';
                $extension = Input::file('file')->getClientOriginalExtension();
                $fileName = strtoupper($hostname).'_'.rand(111111111, 9999999999).'_'.time().(empty($extension) ? '' : '.'.$extension);
                Input::file('file')->move($destinationPath, $fileName);

                /* Save to DB */
                $files = new Files();
                $files->filename = $fileName;
                $files->host = @$hostname;
                $files->type = @$inputs['data']['type'];
                $files->data = json_encode($inputs['data']);
                $files->save();

                echo "file uploaded\n";
            }
        }

        //curl -i -X POST -H "Content-Type: multipart/form-data" -F "file=@test.txt" -F "data[name]=LITTLEBOY" -F "data[ip]=192.168.1.1" https://tools.wolftech.ncsu.edu/mdb/service/store
    }

    public function processor()
    {
        $files = Files::where('processed_at', null)->limit(100)->get();

        if (!count($files)) {
            return 'Uhh, nothing to process.';
        }

        foreach ($files as $file) {
            $content = fopen("uploads/$file->filename", 'r');
            $insertData = [];
            $time = date('Y-m-d H:i:s');

            /* For Type = "users_local" */
            if ($file->type == 'users_local') {
                LinuxUsersLocal::where('hostname', $file->host)->delete();

                while ($line = fgets($content)) {
                    $key = $file->host . '-' . trim($line);
                    $insertData[$key] = ['hostname' => $file->host, 'unityID' => trim($line), 'updated_at' => $time];
                }

                LinuxUsersLocal::insert($insertData);
            }

            /* For Type = "users_base" */
            if ($file->type == 'users_base') {
                LinuxUsersBase::where('hostname', $file->host)->delete();

                while ($line = fgets($content)) {
                    $key = $file->host . '-' . trim($line);
                    $insertData[$key] = ['hostname' => $file->host, 'unityID' => trim($line), 'updated_at' => $time];
                }

                LinuxUsersBase::insert($insertData);
            }

            /* For Type = "users_admin" */
            if ($file->type == 'users_admin') {
                LinuxUsersAdmin::where('hostname', $file->host)->delete();

                while ($line = fgets($content)) {
                    $key = $file->host . '-' . trim($line);
                    $insertData[$key] = ['hostname' => $file->host, 'unityID' => trim($line), 'updated_at' => $time];
                }

                LinuxUsersAdmin::insert($insertData);
            }

            /* For Type = "users_sudo" */
            if ($file->type == 'users_sudo') {
                LinuxUsersSudo::where('hostname', $file->host)->delete();

                while ($line = fgets($content)) {
                    if (preg_match_all('/^(?!#)([a-z0-9-])+(.*)(ALL)$/', $line, $match)) {
                        $units = explode(' ', str_replace('	', ' ', $line));
                        if (trim($units[0]) != 'root') {
                            $key = $file->host . '-' . trim($units[0]);
                            $insertData[$key] = ['hostname' => $file->host, 'unityID' => trim($units[0]), 'perms' => trim(@$units[1].' '.@$units[2]),  'updated_at' => $time];
                        }
                    }
                }

                LinuxUsersSudo::insert($insertData);
            }

            /* For Type = "facter" */
            if ($file->type == 'facter') {
                LinuxFecter::where('hostname', $file->host)->delete();

                while ($line = fgets($content)) {
                    $units = explode(' => ', $line, 2);
                    $key = $file->host . '-' . trim($units[0]);
                    $insertData[$key] = ['hostname' => $file->host, 'fact' => trim($units[0]), 'value' => @$units[1],  'updated_at' => $time];
                }

                LinuxFecter::insert($insertData);
            }

            if ($file->type == 'facter_json') {
                LinuxFecter::where('hostname', $file->host)->delete();

                $data = json_decode(file_get_contents("uploads/{$file->filename}"));

                foreach ($data as $fact => $value) {
                    $key = $file->host . '-' . $fact;
                    $value = is_object($value) ? json_encode($value) : $value;
                    $insertData[$key] = ['hostname' => $file->host, 'fact' => $fact, 'value' => $value, 'updated_at' => $time];
                }

                LinuxFecter::insert($insertData);
            }

            /* For Type = "homedir_usage" */
            if ($file->type == 'homedir_usage') {
                LinuxHomedir::where('hostname', $file->host)->delete();

                while ($line = fgets($content)) {
                    $units = explode('	', $line);
                    $folder = strtolower(trim(str_replace('/home', '', $units[1])));
                    $folder = strlen($folder) > 1 ? preg_replace('~/~', '', $folder, 1) : $folder;
                    $key = $file->host . '-' . $folder;
                    $insertData[$key] = ['hostname' => $file->host, 'folder' => $folder, 'size' => trim($units[0]),  'updated_at' => $time];
                }

                LinuxHomedir::insert($insertData);
            }

            /* For Type = "disk_usage" */
            if ($file->type == 'disk_usage') {
                LinuxDiskusage::where('hostname', $file->host)->delete();

                while ($line = fgets($content)) {
                    $units = preg_split('/\s+/', $line);
                    if ($units[0] == 'Filesystem') {
                        continue;
                    } else {
                        $key = $file->host . '-' . trim($units[6]);
                        $insertData[$key] = ['hostname' => $file->host, 'mounted_on' => trim($units[6]), 'filesystem' => trim($units[0]), 'type' => trim($units[1]), 'used' => trim($units[3]), 'available' => trim($units[4]), 'percent' => trim($units[5]),  'updated_at' => $time];
                    }
                }

                LinuxDiskusage::insert($insertData);
            }

            /* For Type = "last" */
            if ($file->type == 'last') {

                while ($line = fgets($content)) {
                    $units = preg_split('/\s+/', trim($line));

                    if (in_array($units[0], array('wtmp', 'runlevel', 'unknown', '(unknown)', ''))) { // shutdown, reboot
                        continue;
                    } else {
                        $username = $units[0];
                        $terminal = $units[1];
                        $origin = end($units);
                        unset($units[0]);
                        unset($units[1]);
                        array_pop($units);
                        $datetime = trim(str_replace(array('still logged in', 'down', 'crash'), '', implode(' ', $units)));
                        $datetime = explode('-', $datetime);

                        $login = str_replace('1969-12-31 19:00:00', '0000-00-00 00:00:00', date('Y-m-d H:i:s', strtotime(trim(@$datetime[0]))));
                        $logout = str_replace('1969-12-31 19:00:00', '0000-00-00 00:00:00', date('Y-m-d H:i:s', strtotime(trim(explode('(', @$datetime[1])[0]))));

                        $whereArr = ['hostname' => $file->host, 'username' => trim($username), 'terminal' => trim($terminal), 'login_datetime' => $login];
                        $result = LinuxLast::where($whereArr)->first();

                        if (count($result)) {
                            if ($result->logout_datetime != $logout) {
                                LinuxLast::where($whereArr)->update(['logout_datetime' => $logout]);
                            }
                        } else {
                            $key = $file->host . '-' . trim($username) . '-' . trim($terminal) . '-' . $login;
                            $insertData[$key] = $whereArr + ['logout_datetime' => $logout, 'origin' => trim(str_replace('0.0.0.0', '', $origin)), 'updated_at' => $time, 'created_at' => $time];
                        }
                    }
                }

                LinuxLast::insert($insertData);
            }

            /* Set the processed_at time for the current file */
            $file->processed_at = $time;
            $file->save();

            /* Delete file once processed */
            // File::delete("uploads/$file->filename");
        }
    }
}
