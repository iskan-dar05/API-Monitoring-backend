<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
	$request->validate([
		"name"=>"required|min:4",
		"email"=>"required|email",
		"password"=>"required|min:8"
	]);

	$dt = Carbon::now();
	$join_date = $dt->toDayDateTimeString();
	$user = new User();
	$user->name = $request->name;
	$user->email = $request->email;
	$user->password = Hash::make($request->password);
	$user->save();

	$data = [];
	$data["response_code"] = '200';
	$data["status"] = 'success';
	$data["message"] = 'register success';
	return response()->json($data);
}

    public function login(Request $request){
	$request->validate([
		"email"=>"required|string",
		"password"=>"required|string"
	]);

	




}
