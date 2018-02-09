<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Http\Requests\MemberRequest;

class AdminController extends Controller
{
    public function list(){
    	$model = Member::OrderBy('id','DESC')->get();
    	return response()->json($model);
    	// return Member::OrderBy('id','DESC')->get();
    }
    public function index(){
    	return view('page');
    }
    public function create(MemberRequest $request){
    	$model = new Member();
        $model->name = $request->name;
        $model->address = $request->address;
        $model->age = $request->age;
        if ($request->hasFile('photo')) {
            if($request->file('photo')->isValid()) {
                try {
                    $photoName = $request->photo->getClientOriginalName();
                    $request->photo->move(public_path('images/'), $photoName);
                    $model->photo = $photoName;
                } catch (\League\Flysystem\Exception $e) {

                }
            }
        }
        $model->save();
        return response()->json($model);
    }
    public function store($id){
    	// dd($id);
    	return Member::findOrFail($id);
    }
    public function update(MemberRequest $request, $id){
    	$model = Member::findOrFail($id);
    	$model->name = $request->name;
        $model->address = $request->address;
        $model->age = $request->age;
        if ($request->hasFile('photo')) {
            if($request->file('photo')->isValid()) {
                try {
                    $photoName = $request->photo->getClientOriginalName();
                    $request->photo->move(public_path('images/'), $photoName);
                    $model->photo = $photoName;
                } catch (\League\Flysystem\Exception $e) {

                }
            }
        }
        $model->save();
        return $model;
    }
    public function destroy($id){
    	$model = Member::findOrFail($id);
    	$model->delete();
    	return $model;
    }
}
