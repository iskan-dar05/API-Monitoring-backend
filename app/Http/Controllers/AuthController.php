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


		if (User::where('email', $request->email)->exists()) {
	        return response()->json([
	            "message" => "Email already exists"
	        ], 409); // conflict
    	}

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

		try{
			
			$credentials = [
			    'email' => $request->email,
			    'password' => $request->password
			];

			if(!Auth::attempt($credentials)) {
				return response()->json([
					'message' => 'Invalid credentials'
				], 401);
			}

			$request->session()->regenerate();
			$user = Auth::user();
			return response()->json([
		        'message' => 'Login successful',
		        "user" => $user
		    ]);

		}catch(\Exception $e){
			\Log::info($e);
			return response()->json([
            	'message' => 'Server error'
        	], 500);
		}

	}




	




}
