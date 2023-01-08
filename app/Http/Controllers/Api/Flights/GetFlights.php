<?php

namespace App\Http\Controllers\Api\Flights;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class GetFlights extends Controller {
	
	public function getFlights(Request $request){
		$RequestData = $request->all();
		// var_dump($RequestData);
		// die();
		$validator = Validator::make($RequestData,[
			'to' => ['required','string'],
			'day' => ['required','string'], 
			'isreturn' => ['required','boolean'],
		]);
		
		if ($validator->fails()) {
			$result = response()->json(['Success'=>false,'Msg'=>$validator->messages()],400);
		} 
		else {
			$flights = DB::table('flight_masters as a')
			->join('flight_schedules as b','a.id','=','b.flightid')
			->where(strtolower('a.location'),strtolower($RequestData['to']))
			->whereRaw('b.day = '.date('N', strtotime($RequestData['day'])))
			->selectRaw('concat(a.name,\'-\',cast(b.id as char)) as Flight')
			->addSelect('b.dept_time as Dept','b.arrival_time as Arrival','b.vacantseats as SeatsAvailable','a.totalseats as Seats','a.priceperseat as Price');
			if($RequestData['isreturn']) {
				$query = DB::raw("(case b.isreturn when 1 then 'Mumbai' else '".$RequestData['to']."' end) as 'To',(case b.isreturn when 2 then 'Mumbai' else '".$RequestData['to']."' end) as 'From'");
				$data = $flights->addSelect($query)->get();
			} else {
				$data = $flights->selectRaw("a.location as 'To',concat('Mumbai') as 'From'")->where('b.isreturn',2)->get();
			}
			$result = response()->json(['Success'=>true,'Data'=>$data]);
		}

		return $result;
	}
}
