<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Equipment;
use App\Groups;
use App\EquipmentType;
use DB;

class DashboardController extends Controller
{
    protected $userData;

    public function __construct()
    {
        $this->userData = Session::get('signedUser');
    }

    public function index()
    {
        $data['userData'] = $this->userData;
        $data['equipmentCount']['active'] = Equipment::where('unit_id', $this->userData->unit_id)->where('active', 1)->count();
        $data['equipmentCount']['inactive'] = Equipment::where('group_id', $this->userData->unit_id)->where('active', 0)->count();
        $data['equipmentCount']['total'] = $data['equipmentCount']['active'] + $data['equipmentCount']['inactive'];


        $data['equipmentCount']['computers'] = Equipment::where('unit_id', $this->userData->unit_id)->where('active', 1)->whereIn('type_id', explode(',', '1,3,4,13,27,51'))->count();
        $data['equipmentCount']['printers'] = Equipment::where('unit_id', $this->userData->unit_id)->where('active', 1)->whereIn('type_id', explode(',', '2,43,44'))->count();
        $data['equipmentCount']['handhelds'] = Equipment::where('unit_id', $this->userData->unit_id)->where('active', 1)->whereIn('type_id', explode(',', '41,170,12'))->count();

        $minCount = ($this->userData->unit_id == 87) ? 20 : 1;

        $data['equipmentTypes'] = EquipmentType::select([
            DB::raw("(SELECT COUNT(*) FROM equipment as db_equipment WHERE db_equipment.type_id=equipment_type.id and db_equipment.active=1 Having COUNT(*) > {$minCount}) as active_eq_count"),
            'equipment_type.name',
        ])->having('active_eq_count', '>', $minCount)->get();

        $data['equipmentGroups'] = Groups::select([
            DB::raw("(SELECT COUNT(*) FROM equipment as db_equipment WHERE db_equipment.group_id=groups.id and db_equipment.active=1 Having COUNT(*) > {$minCount}) as active_eq_count"),
            'groups.name',
        ])->having('active_eq_count', '>', $minCount)->where('parent', $this->userData->unit_id)->get();

        // dd($data['equipmentGroups']->toArray());


        return view('displays.dashboard', $data);
    }

    public function underDev()
    {
        $data['userData'] = $this->userData;
        return view('displays.dev', $data);
    }
}
