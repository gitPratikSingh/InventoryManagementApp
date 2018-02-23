<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use App\History;

class HistoryController extends Controller
{

    protected $userData;
    protected $history;

    public function __construct(History $history)
    {
        $this->userData = Session::get('signedUser');
        $this->history = $history;
    }

    public function index()
    {
        $data['userData'] = $this->userData;
        $data['pagename'] = 'history';
        return view('displays.history', $data);
    }

    public function datatable(Request $request)
    {

        $datatables = $this->history->select([
            'history.id',
            'history.item_id',
            'db_user.unity_id as unity_id',
            'history.screen',
            'history.field',
            'history.action',
            'history.value_old',
            'history.value_new',
            'history.created_at',
        ])
        ->leftJoin(config('constants.DB_USERS').' as db_user',                        'db_user.id',                      '=', 'history.user_id');
        return Datatables::of($datatables)->make(true);
    }

}
