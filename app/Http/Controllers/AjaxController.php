<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Records;
use App\Devices;

use DB;

class AjaxController extends Controller
{
    public function get(Request $request)
    {
        $data = $request->all(); // This will get all the request data.
        $devices = DB::table('devices')
                    ->join('makes', 'devices.make_id' , '=',  'makes.id')
                    ->join('models', 'devices.model_id', '=', 'models.id')
                    ->leftjoin('units', 'devices.unit_id', '=', 'units.id')
                    ->select('devices.*', 'makes.name as make_name', 'models.name as model_name', 'units.name as unit_name')
                    ->get();

        $userPref = DB::table('users_preferences')->select('users_preferences.preferences')->get();

        return  $data;
    }


    public function delete(Request $request)
    {
        $data = $request->all();
        error_log(print_r($data['id'], true));
        $deletedIds = $data['id'];
        if(!empty($deletedIds))
        DB::table('devices')->whereIn('id', $deletedIds)->delete();

        return  $data;
    }

    public function post(Request $request)
    {
       
        $columnpreferences = $request['param'];

        if (! empty(json_decode($request['param'], true))) {
            DB::update('update users_preferences set preferences = ? where user_id = ?', [$request['param'], 1]);
        }else{
            error_log("Empty Request!");
            $columnpreferences = DB::table('users_preferences')->select('users_preferences.preferences')->get()[0];
            $columnpreferences = $columnpreferences->preferences;
        }

        $records = json_encode(
            DB::table('devices')
                    ->join('makes', 'devices.make_id' , '=',  'makes.id')
                    ->join('models', 'devices.model_id', '=', 'models.id')
                    ->leftjoin('units', 'devices.unit_id', '=', 'units.id')
                    ->select('devices.*', 'makes.name as make_name', 'models.name as model_name', 'units.name as unit_name')
                    ->get()
        );

        return view('ajax.default', ['ajaxData' => $records, 'columnpreferences' => $columnpreferences]);
    }
}
