<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Redirect;
use Yajra\Datatables\Datatables;
use DB;
use Cache;
use Validator;
use Excel;

use App\Http\Controllers\Controller;

use App\Equipment;
use App\EquipmentComputer;
use App\EquipmentType;
use App\Buildings;
use App\Groups;
use App\Os;
use App\Notes;
use App\Domains;
use App\History;
use App\User;
use App\EquipmentMake;
use App\EquipmentPurchase;
// use Mdb\EquipmentComputerPartsType;

class EquipmentController extends Controller
{
    protected $userData;
    protected $equipmentTypes;
    protected $bulkUpdateFields;

    public function __construct(History $history)
    {
        $this->userData = Session::get('signedUser');
        $this->history  = $history;
        $this->equipmentTypes = (object)array(
            'audio-visual'      => '153,145',
            'computers'         => '1,3,4,13,27,51',
            'printers'          => '2,43,44',
            'handheld'          => '41,170,12',
            'instrumentation'   => '72,136,25,26,68,69,171,172,18,158,23,17',
            'other'             => '45,168,167,10,52,72,136,25,26,68,69,171,172,18,158,23,17,153,145'
        );
        $this->bulkUpdateFields = (object)array(
            'type_id'             => 'Type',
            'make_id'             => 'Make',
            'model'               => 'Model',
            'building_id'         => 'Building',
            'room'                => 'Room',
            'primary_user'        => 'Primary User',
            'group_id'            => 'Group',
            'personal'            => 'Personal',
            'offsite'             => 'Offsite',
            'reseller'            => 'Reseller',
            'acct_no'             => 'Acct Number',
            'po_no'               => 'PO Number',
            'quote_no'            => 'Quote Number',
            'price'               => 'Price',
            'os_id'               => 'OS Name',
            'processor'           => 'Processor',
            'harddrive'           => 'Harddrive',
            'memory'              => 'Memory',
            'domain_id'           => 'Domain',
            //''      => '',
        );
    }

    public function index(Request $request)
    {

        $this->equipmentTypes->computers;
        $data['userData'] = $this->userData;
        $data['pagename'] = 'equipment';
        $data['equipmentType'] = Request::segment(2);

        return view('displays.equipment', $data);
    }

    public function datatable(Request $request)
    {
        $typeSlug = Input::get('equipmentType');

        $datatables = Equipment::distinct()->select([
            'equipment.id',
            'equipment.active',
            'equipment.surplused',
            'equipment.equipment_name',
            'db_type.name as type_name',
            'equipment.serial_number',
            'equipment.cams',
            DB::raw('CONCAT(db_make.name, " ", equipment.model) AS make_and_model'),
            'db_make.name', 
            'db_building.name as building_name',
            DB::raw('CONCAT(db_building.name, " ", equipment.room) AS location'),
            'equipment.config',
            'equipment.owner',
            'equipment.primary_user',
            'equipment.warranty',
            'db_groups.name as group_name',
            'equipment.retired_at',
            'equipment.surplused_at',
            'equipment.created_at',
            'equipment.updated_at',

            'db_os.name as os_name',
            'db_computer.memory as memory',
            'db_computer.processor as processor',
            'db_computer.harddrive as harddrive',
            'db_computer.ip as ip',
            'db_domain.name as domain',
            'db_computer.ethernet as ethernet',
            'db_computer.hostname as hostname',

            'db_purchase.acct_no as acct_no',
            'db_purchase.po_no as po_no',
            'db_purchase.quote_no as quote_no',
            'db_purchase.reseller as reseller',
            'db_purchase.price as price',
            'db_purchase.date_purchased as date_purchased',
            DB::raw('(SELECT GROUP_CONCAT(CONCAT(\'{"note":"\', note, \'", "date":"\',created_at,\'"}\')) list FROM notes as db_notes WHERE db_notes.equipment_id=equipment.id ) as notes')
            ])
            ->leftJoin(config('constants.DB_EQUIPMENT_TYPE').' as db_type',            'db_type.id',                '=', 'equipment.type_id')
            ->leftJoin(config('constants.DB_EQUIPMENT_MAKE').' as db_make',            'db_make.id',                '=', 'equipment.make_id')
            ->leftJoin(config('constants.DB_GROUPS').' as db_groups',                  'db_groups.id',              '=', 'equipment.group_id')
            ->leftJoin(config('constants.DB_BUILDINGS').' as db_building',             'db_building.id',            '=', 'equipment.building_id')
            ->leftJoin(config('constants.DB_EQUIPMENT_COMPUTER').' as db_computer',    'db_computer.equipment_id',  '=', 'equipment.id')

            ->leftJoin(config('constants.DB_EQUIPMENT_PURCHASE').' as db_purchase',    'db_purchase.equipment_id',  '=', 'equipment.id')
            ->leftJoin(config('constants.DB_DOMAIN').' as db_domain',                  'db_domain.id',              '=', 'db_computer.domain_id')
            ->leftJoin(config('constants.DB_OS').' as db_os',                          'db_os.id',                  '=', 'db_computer.os_id')

            ->where('equipment.unit_id', $this->userData->unit_id);


            //dd($datatables->toSql());
        if(!empty($typeSlug) and !empty($this->equipmentTypes->{$typeSlug})){
            $datatables->whereIn('equipment.type_id', explode(',', $this->equipmentTypes->{$typeSlug}));
        }

        return Datatables::of($datatables)
               ->filterColumn('make_and_model', function($query, $keyword) {
                  $query->whereRaw("CONCAT(db_make.name, ' ', equipment.model) like ?", ["%{$keyword}%"]);
               })
               ->filterColumn('location', function($query, $keyword) {
                  $query->whereRaw("CONCAT(db_building.name, ' ', equipment.room) like ?", ["%{$keyword}%"]);
               })
               ->make(true);
    }

    public function datatableState()
    {
        $input = Input::all();


        if($input['action']=='save')
        {
            User::where('id',$this->userData->id)->update(['columns'=> json_encode($input['state'])]);
        }

        if($input['action']=='get')
        {
           echo str_replace('"false"','false',str_replace('"true"','true', User::where('id',$this->userData->id)->pluck('columns')));
        }


    }


    public function login()
    {
        $data['title'] = "MDB";
        return view('displays.login', $data);
    }


    public function exportToExcel(){
    $removeColumns = array('`equipment`.`config`,');
    $getQuery = str_replace($removeColumns, '', explode('limit', $this->getSql(Session::get('exportQuery')))[0]);

      Excel::create('Filename', function($excel) use($getQuery) {

          $excel->sheet('Sheetname', function($sheet) use($getQuery) {
              $data = json_decode(json_encode(DB::select($getQuery)), True);
              $sheet->fromModel($data);
          });

      })->export('xls');
    }

    public function getSql($exportQuery){
        $builder = $exportQuery['binding'];
        $sql = $exportQuery['query'];
        foreach($builder as $binding)
        {
          $value = is_numeric($binding) ? $binding : "'".$binding."'";
          $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }

    public function bulkUpdate(Request $request)
    {
      $inputs = Input::all();

      foreach(array('personal','offsite') as $item):
          $inputs[$item] = (Input::has($item)==1) ? 1 : 0;
      endforeach;

      $equipmentIds = explode(':', $inputs['bulkIds']);
      if($inputs['bulkUpdate']==1 && !empty($equipmentIds)){
          $equpments = Equipment::whereIn('id', $equipmentIds)->where('unit_id', $this->userData->unit_id)->get();
          foreach($equpments as $equipment){
            $equipment->update($inputs);
            if(isset($inputs['computer'])) {
                $equipment->computers->update($inputs['computer']);
            }
            if(isset($inputs['purchase'])) {
                $equipment->purchases->update($inputs['purchase']);
            }
          }
          return Redirect::to('equipment')->withMessage('Mass Update Was Successfull!');
      }
      return Redirect::to('equipment')->withMessage('Some Error Occurred!');
    }

    public function saveItem(Request $request)
    {
        $inputs = Input::all();

        foreach(array('personal','offsite') as $item):
          $inputs[$item] = (Input::has($item)==1) ? 1 : 0;
        endforeach;

        $rules = array(
            'type_id'                 => 'required|numeric',
            'make_id'                 => 'required|numeric',
            'model'                   => 'required',
        );

        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            if ($inputs['id']>0) {
                $equipment = Equipment::find($inputs['id']);


                /* Update equipment table */
                $equipment->fill($inputs);
                $equipment->computers->fill($inputs['computer']);
                $equipment->purchases->fill($inputs['purchase']);

                /* Histroy Stuff */
                $oldData = array_merge(
                    $equipment->getOriginal(),
                    $equipment->computers->getOriginal(),
                    $equipment->purchases->getOriginal()
                );

                $newData = array_merge(
                    $equipment->getDirty(),
                    $equipment->computers->getDirty(),
                    $equipment->purchases->getDirty()
                );

                $equipment->save();
                $equipment->computers->save();
                $equipment->purchases->save();

                $this->history->saveChanges($oldData, $newData, $this->userData, 'equipment', 'update');

                $this->insertNotes($inputs['note'], $equipment);

                return Redirect::to('equipment')->withMessage('Equipment updated!');
            } else {
                $equipment = new Equipment($inputs);
                $computers = new EquipmentComputer($inputs['computer']);
                $purchases = new EquipmentPurchase($inputs['purchase']);

                /* Update equipment table */
                $equipment->unit_id = $this->userData->unit_id;
                $equipment->save();
                $equipment->computers()->save($computers);
                $equipment->purchases()->save($purchases);

                $this->history->insertChanges($equipment->id, $this->userData, 'equipment', 'insert');

                $this->insertNotes($inputs['note'], $equipment);

                return Redirect::to('equipment')->withMessage('Equipment saved!');
            }
        }
        dd($inputs);

    }

    public function insertNotes($note = NULL, $equipment = NULL){
        if(empty($equipment)) {
          $equipment = Equipment::find(Input::get('equipmentID'));
          $note = Input::get('note');
          echo date('Y-m-d H:m:i');
        }
        $notes = new Notes();
        $notes->note = $note;
        $notesSave = $equipment->notes()->save($notes);
        $this->history->insertChanges($notesSave->id, $this->userData, 'equipment notes', 'insert');
    }

    public function addEditItem()
    {
        $timeout = 2400;
        $data['userData'] = $this->userData;

        $equpmentModel = new Equipment;

        /* My Buildings Dropdown */
        $data['buildings']['popular'] = Cache::remember('buildingsPopular', $timeout,
            function() use($equpmentModel) {
              return $this->getPopularItems($equpmentModel, 'buildings', 'building_id');
            }
        );
        $data['buildings']['other']   = array_diff(Buildings::where("name", '!=', "")->orderBy('name', 'asc')->lists('name', 'id')->toArray(), $data['buildings']['popular']);

        /* My Types Dropdown */
        $data['equipmentType']['popular'] = Cache::remember('equipmentTypePopular', $timeout,
            function() use($equpmentModel) {
              return $this->getPopularItems($equpmentModel, 'equipment_type', 'type_id');
            }
        );
        $data['equipmentType']['other']   = array_diff(EquipmentType::where("name", '!=', "")->orderBy('name', 'asc')->lists('name', 'id')->toArray(), $data['equipmentType']['popular']);

        /* My Makes Dropdown */
        $data['make']['popular'] = Cache::remember('makePopular', $timeout,
            function() use($equpmentModel) {
              return $this->getPopularItems($equpmentModel, 'equipment_make', 'make_id');
            }
        );
        $data['make']['other']   = array_diff(EquipmentMake::where("name", '!=', "")->orderBy('name', 'asc')->lists('name', 'id')->toArray(), $data['make']['popular']);


        $data['groups']           = Groups::where("name", '!=', "")->where('unit_id', $this->userData->unit_id)->lists('name', 'id');
        $data['os']               = Os::where("name", '!=', "")->orderBy('name', 'asc')->lists('name', 'id');
        $data['domain']           = Domains::where("name", '!=', "")->orderBy('name', 'asc')->lists('name', 'id');
        //$data['users']            = Groups::find($this->userData->unit_id)->users->lists('unity_id', 'id');

        $equipmentID = Request::segment(3);
        if (is_numeric($equipmentID)) {
            $data['pagename']     = 'Update Equipment';
            $data['equipment']    = Equipment::findOrfail($equipmentID);
            $data['computers']    = $data['equipment']->computers;
            $data['purchases']    = $data['equipment']->purchases;
        }elseif(Request::segment(2)=='bulk-update'){
            $data['equipment']    = new Equipment;
            $data['computers']    = new EquipmentComputer;
            $data['purchases']    = new EquipmentPurchase;
            $data['pagename']     = 'Mass Update Equipment';
            $data['bulkUpdate']   = true;
            $data['fieldNames']   = $this->bulkUpdateFields;
            $data['bulkIds']      = Request::segment(3);
            $data['updateFields'] = array_merge($data['equipment']->getFillable(), $data['computers']->getFillable(), $data['purchases']->getFillable());;
        } else {
            $data['equipment']    = new Equipment;
            $data['pagename']     = 'Add New Equipment';
        }



        return view('forms.equipment_form', $data);
    }

    public  function getPopularItems($model, $coTable, $column){
      return $model::select(DB::RAW("DISTINCT(equipment.{$column})"), "coTable.id", "coTable.name")
      ->where("equipment.unit_id", $this->userData->unit_id)
      ->where("coTable.name", '!=', "")
      ->where("equipment.active", 1)
      ->leftJoin("{$coTable} as coTable", "coTable.id", '=', "equipment.{$column}")
      ->orderBy("coTable.name", 'asc')
      ->lists('coTable.name', 'coTable.id')->toArray();
    }

    public function itemStatus()
    {
        $itemID = Input::get('itemID');
        $type   = Input::get('type');

        if(is_numeric($itemID)){
            $equipment = Equipment::find($itemID);

            if(in_array($type, array('surplused','retired'))){
                $equipment->$type  = 1;
                $equipment->{$type."_at"}  = date('Y-m-d H:i:s');
                $equipment->active = 0;
                //$equipment->save();
            }else{
                $equipment->retired     = 0;
                $equipment->surplused   = 0;
                $equipment->active      = 1;
            }

            $equipment->save();
        }
    }

}
