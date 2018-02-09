<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class PageController extends Controller
{
    public function index(){
    	$model = Member::orderBy('id','DESC')->paginate(5);
    	return view('index',compact('model'));
    }
}
