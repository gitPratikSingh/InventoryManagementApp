<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class DatatablesTestController extends Controller
{
   	   /**
        * Displays datatables front end view
        *
        * @return \Illuminate\View\View
        */
       public function getIndex()
       {
           return view('test.index');
       }

       /**
        * Process datatables ajax request.
        *
        * @return \Illuminate\Http\JsonResponse
        */
       public function anyData()
       {
           return Datatables::of(User::select('*'))->make(true);
       }
}
