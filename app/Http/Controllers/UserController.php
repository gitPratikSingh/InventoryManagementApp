<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Validator;
use Session;
use Request;
use Redirect;
use Yajra\Datatables\Datatables;
use DB;

use App\Helpers\Helper;
use App\Groups;
use App\History;
use App\UserAccess;
use App\Oracle;
use App\User;

class UserController extends Controller
{
    protected $userData;
    protected $history;

    public function __construct(History $history)
    {
        $this->userData = Session::get('signedUser');
        if(@$this->userData->access_id>2){
            dd('You do not have access to this screen, please contact your manager!');
        }
        $this->history = $history;
    }

    public function index()
    {
        $data['userData'] = $this->userData;
        $data['pagename'] = 'user';
        return view('displays.user', $data);
    }

    public function datatable(Request $request)
    {
        $accessId = $this->userData->access_id;
        $userId = $this->userData->id;
        $unitId = $this->userData->unit_id;

        if($accessId>1){
          $oWhere['users.unit_id'] = $unitId;
        }

        if($accessId>2){
          $oWhere['users.id'] = $userId;
        }

        $datatables = User::select([
            'users.id',
            'users.unity_id',
            'users.first_name',
            'users.middle_name',
            'users.last_name',
            'users.email',
            'db_units.name as unit_name',
            'db_users_access.name as access_name',
        ])
        ->leftJoin(config('constants.DB_GROUPS').' as db_units',                         'db_units.id',                       '=', 'users.unit_id')
        ->leftJoin(config('constants.DB_USERS_ACCESS').' as db_users_access',            'db_users_access.id',                '=', 'users.access_id');

        if($accessId>1){
          $datatables->where('users.unit_id', $this->userData->unit_id);
        }

        if($accessId>2){
          $datatables->where('users.id', $userId);
        }

        return Datatables::of($datatables)->make(true);
    }

    public function saveItem(Request $request)
    {
        //dd(Input::all());
        $inputs = Input::all();
        $userID = $inputs['id'];

        $rules = array(
            'unity_id'         => 'required|unique:users,unity_id,'.$userID,
            'email'            => 'required|email|unique:users,email,'.$userID,
        );

        if($this->userData->access_id==1){
            $rules['unit_id'] = 'required|numeric';
        }else{
            $inputs['unit_id'] = $this->userData->unit_id;
        }

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            if ($userID>0) {
                $user = User::find($inputs['id']);

                /* Update users table */
                $user->fill($inputs);
                $oldData = $user->getOriginal();
                $newData = $user->getDirty();
                $user->save();
                $this->history->saveChanges($oldData, $newData, $this->userData, 'user', 'update');

                return Redirect::to('user')->withMessage('User updated!');
            } else {
                $user = new User;

                /* Update users table */
                $user->fill($inputs);
                $user->save();
                $this->history->insertChanges($user->id, $this->userData, 'user', 'insert');

                return Redirect::to('user')->withMessage('User saved!');
            }
        }

    }

    public function addEditItem()
    {

        $data['userData'] = $this->userData;

        $itemID = Request::segment(3);
        if ($itemID>0) {
            $data['pagename']   = 'Update User';
            $data['user']  = User::select(['users.*', 'db_groups.name as group_name'])->leftJoin('groups as db_groups','db_groups.id', '=', 'users.group_id')->find($itemID);
        } else {
            $data['user']  = new User;
            $data['pagename']   = 'Add New User';
        }

        $data['accessList']      = UserAccess::where('id', '!=', 1)->lists('name', 'id');

        if($this->userData->access_id!=1){
            $oWhereU['id'] = $this->userData->unit_id;
            $oWhereG['parent'] = $this->userData->unit_id;
        }
        $oWhereU['is_unit'] = 1;
        $oWhereG['is_unit'] = 0;
        // $oWhereG['is_department'] = 0;

        $data['unitsList']       = Groups::where($oWhereU)->lists('name', 'id');
        $data['groupsList']      = Groups::where($oWhereG)->lists('name', 'id');

        return view('forms.user_form', $data);
    }

    public function searchGroups(){
        $term = Input::get('term');
        if(strlen($term)>0) {
            echo json_encode(Groups::select('name as value', 'id')->where('is_unit', '0')->where('name', 'LIKE', "%$term%")->whereIn('id', explode(',', $this->userData->myGroups))->get()->toArray());
        }
    }

    public function getUserData(){
        $unity_id = Input::get('unity_id');
        if(strlen($unity_id)>0) {
            $oracleUserData = Oracle::where('oprid',strtoupper($unity_id))->first();
            echo json_encode($oracleUserData);
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/')->withMessage('Unit Switched!');
    }

    public function switchUnit($request)
    {
      if(in_array($this->userData->id, config('app.superUsers'))):
        $unitID = Request::segment(2);
        Session::forget('mockUnit');
        Session::put('mockUnit', $unitID);
        Auth::logout();
      endif;
      return Redirect::to('dashboard')->withMessage('Unit Switched!');
    }

    public function destroy($id)
    {
        if(!in_array($id, array(1,2,3))){
            User::destroy($id);
        }
    }
}
