<?php

namespace App\Http\Controllers\Api\Passenger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class AddPassenger extends Controller {
	
	public function addPassenger(Request $request){
		$validator = Validator::make($request->all(),[
			'name' => ['required','string'],
			'sex' => ['required','string'],
			'age' => ['nullable','int'],
			'email' => ['required','email'],
			'phone' => ['required','digits:10']
		]);

		if ($validator->fails()) {
			$result = response()->json(['Success'=>false,'Msg'=>$validator->messages()],400);
			return $result;
		} else {
			$checkDuplicate = DB::table('passenger_masters')
				->select('id')
				->where('email',$request->input('email'))
				->orWhere('phone',$request->input('phone'))->get();
				
			if(sizeof($checkDuplicate)>0) {
				$result = response()->json(['Success'=>false,'Msg'=>'Email or Phone already exists'],400);
				return $result;
			}
			
			$result = DB::table('passenger_masters')->insert(
				array(
					'name' => $request->input('name'),
					'sex' => $request->input('sex'),
					'age' => $request->input('age'),
					'email' => $request->input('email'),
					'phone'=>$request->input('phone')
				)
			);
			if($result){
				$result = response()->json(['Success'=>true,'Msg'=>'Passenger registered successfully'],200);
				return $result;
			}
		}
	}
	
	public function checkDuplicate(){
		$checkDuplicate = DB::table('passenger_masters')->select('id')->where('email',$request->input('email'))->orWhere('phone',$request->input('mobileno'))->get();
		if(sizeof($checkDuplicate)>0) {
			$result = response()->json(['Success'=>false,'Msg'=>'Email or Phone already exists'],400);
			return $result;
		}
	}
}