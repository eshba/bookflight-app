<?php

namespace App\Http\Controllers\Api\Passenger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class ConfirmFlights extends Controller {
	
	public function confirm(Request $request){
		
		$RequestData = $request->all();
		$validator = Validator::make($RequestData,[
			'flight' => ['required','string'],
			'email' => ['nullable','email'],
			'phone' => ['nullable','digits:10'], 
			'seat' => ['required','int','min:1','max:180']
		]);
		
		if ($validator->fails()) {
			$result = response()->json(['Success'=>false,'Msg'=>$validator->messages()],400);
			return $result;
		} elseif (!isset($RequestData['email']) && !isset($RequestData['phone'])) {
			$result = response()->json(['Success'=>false,'Msg'=>'You must provide either email or phone.'],400);
			return $result;
		} 
		else {
			$flightid = explode("-",$RequestData['flight'])[1];
			$passengerId = DB::table('passenger_masters')
				->select('id')
				->where('email',$request->input('email'))
				->orWhere('phone',$request->input('phone'))->get();
				
			if(sizeof($passengerId)==0) {
				$result = response()->json(['Success'=>false,'Msg'=>'Passenger not found.'],400);
				return $result;
			}
			
			$seatStatus = DB::table('flight_bookings')
				->select('id')
				->where([['seat',$RequestData['seat']],['flightschduleid',$flightid],['isconfirmed','!=',0]])->get();
			
			if(sizeof($seatStatus)==0){
				$result = response()->json(['Success'=>false,'Msg'=>'Booking got Cancelled. Holding time Exceeded'],200);
				return $result;
			}
			
			DB::table('flight_bookings')->where('id',$seatStatus[0]->id)->update(['isconfirmed'=>2]);
			$result = response()->json(['Success'=>true,'Msg'=>'Booking Confirmed.'],200);
			return $result;
		}
	}
}