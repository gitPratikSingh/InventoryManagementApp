<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Yajra\Datatables\Datatables;
use DB;

use App\Domains;
use App\Groups;
use App\User;
use App\Os;
use App\History;
use App\Equipment;
use App\Buildings;
use App\EquipmentMake;
use App\EquipmentType;

class SettingsController extends Controller
{
    protected $userData;
    protected $history;

    public function __construct(History $history)
    {
        $this->userData = Session::get('signedUser');
        $this->history  = $history;
    }

    public function index()
    {
        $data['userData'] = $this->userData;
        $data['pagename'] = 'codes';
        //$data['unitsList'] = Groups::where('is_unit', 1)->lists('name', 'id');

        return view('displays.settings.codes', $data);
    }

    public function domainsDatatable()
    {
        $datatables = Domains::select([
            'domain.id',
            'domain.name',
            'domain.active',
        ]);
        return Datatables::of($datatables)->make(true);
    }

    public function groupsDatatable()
    {
        $datatables = Groups::select([
            DB::raw('(SELECT COUNT(*) FROM equipment as db_equipment WHERE db_equipment.group_id=groups.id and db_equipment.active=1) as active_eq_count'),
            DB::raw('(SELECT COUNT(*) FROM equipment as db_equipment WHERE db_equipment.type_id=groups.id and db_equipment.active=0) as inactive_eq_count'),
            'groups.id',
            'groups.name',
            'db_groups.name as group_name',
        ])
        ->where('groups.parent',$this->userData->unit_id)
        ->leftJoin('groups as db_groups',    'db_groups.id',    '=', 'groups.parent');
        return Datatables::of($datatables)->make(true);
    }

    public function makesDatatable()
    {
        $datatables = EquipmentMake::select([
            'equipment_make.id',
            'equipment_make.name',
        ]);
        return Datatables::of($datatables)->make(true);
    }

    public function osDatatable()
    {
        $datatables = Os::select([
            'os.id',
            'os.name',
        ]);
        return Datatables::of($datatables)->make(true);
    }

    public function buildingsDatatable()
    {
        $datatables = Buildings::select([
            'buildings.id',
            'buildings.name',
        ]);
        return Datatables::of($datatables)->make(true);
    }

    public function typesDatatable()
    {
        $datatables = EquipmentType::select([
            DB::raw('(SELECT COUNT(*) FROM equipment as db_equipment WHERE db_equipment.type_id=equipment_type.id and db_equipment.active=1) as active_eq_count'),
            DB::raw('(SELECT COUNT(*) FROM equipment as db_equipment WHERE db_equipment.type_id=equipment_type.id and db_equipment.active=0) as inactive_eq_count'),
            'equipment_type.id',
            'equipment_type.name',
        ]);
        return Datatables::of($datatables)->make(true);
    }

    public function saveItem(Request $request)
    {
        // dd(Input::all());
        $inputs = Input::all();
        $itemID = $inputs['id'];
        $itemName = $inputs['name'];
        $itemType = $inputs['type'];
        $itemClass = 'Mdb\\'.str_replace(" ", "", ucwords(strtolower(str_replace("_", " ", $inputs['type']))));

        $rules = array(
            'name'         => "required|unique:{$itemType},name,{$itemName}",
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json(['responseText' => $messages], 500);
        } else {
            if ($itemID>0) {
                $item = $itemClass::find($itemID);

                /* Update users table */
                $item->fill($inputs);
                $oldData = $item->getOriginal();
                $newData = $item->getDirty();
                $item->save();
                $this->history->saveChanges($oldData, $newData, $this->userData, ucwords(str_replace('_', ' ', $itemType)), 'update');

                return response()->json(['responseText' => 'Saved Successfully'], 200);
            } else {
                $item = new $itemClass;

                $inputs['parent']   = $this->userData->unit_id;
                $item->user_id      = $this->userData->id;

                /* Update users table */
                $item->fill($inputs)->save();
                return response()->json(['responseText' => 'Saved Successfully'], 200);
            }
        }

    }

    public function destroy($id)
    {
        $equipmentCount = Equipment::where('group_id', $id)->where('active', 1)->count();
        if($equipmentCount==0){
            $model = Groups::find($id);
            $model->delete();
            return response()->json(['responseText' => 'Deleted successfully'], 200);
        }else{
            return response()->json(['responseText' => "This group associated with {$equipmentCount} active records!"], 200);
        }
    }

    public function getData(){
        $itemID = Input::get('itemID');
        $type = Input::get('type');

        switch($type) {
            case 'makes-modal':
                $itemObj = EquipmentMake::findOrfail($itemID);
                break;
            case 'os-modal':
                $itemObj = Os::findOrfail($itemID);
                break;
            default:
                die("some error occured");
        }


        print(json_encode($itemObj));

    }
}
