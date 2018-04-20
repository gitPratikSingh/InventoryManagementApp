<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Devices;
use App\UsersPreferences;

use DB;
use Carbon\Carbon;

class AjaxController extends Controller
{
    public function get(Request $request)
    {
        $data = $request->all(); // This will get all the request data.
        
        return Devices::all();
    }


    public function delete(Request $request)
    {
        $data = $request->all();
        $deletedIds = $data['id'];
        
        error_log(print_r($deletedIds, true));

        if (!empty($deletedIds)) {
            $devices = Devices::whereIn('id', $deletedIds);
            
            foreach ($devices as $device) {
                $device->softDeletes();
            }
        }
    }

    public function undodelete(Request $request)
    {
        $data = $request->all();
        $deletedIds = $data['id'];

        if (!empty($deletedIds)) {
            $devices = Devices::whereIn('id', $deletedIds);
            
            foreach ($devices as $device) {
                $device->restore();
            }
        }
    }

    public function post(Request $request)
    {
       
        DB::enableQueryLog(); 
        $columnpreferences = $request->input('param');

        $user_id = 1;
        $userpref = UsersPreferences::where('user_id', $user_id)->first();        

        if ($columnpreferences != '{}') {
            $userpref->preferences = $columnpreferences;
            $userpref->save();
        }

        $records = json_encode(
            DB::table('devices')
                    ->join('makes', 'devices.make_id' , '=',  'makes.id')
                    ->join('models', 'devices.model_id', '=', 'models.id')
                    ->join('units', 'devices.unit_id', '=', 'units.id')
                    ->join('devices_purchases', 'devices.id', '=', 'devices_purchases.device_id')
                    ->select(DB::raw("devices.*, if(devices.deleted_at IS NULL, 2, 1) as status, makes.name as make_name, models.name as model_name, units.name as unit_name
                    , devices_purchases.ordered_at as purchase_date"))
                    ->get()
        );
        
        return view('ajax.default', ['ajaxData' => $records, 'columnpreferences' => $userpref->preferences]);
    }
}
