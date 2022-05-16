<?php

namespace App\Http\Controllers\Api\Passenger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use PDF;

class BookFlights extends Controller {
	
	public function bookFlights(Request $request){
		
		$RequestData = $request->all();
		$validator = Validator::make($RequestData,[
			'flight' => ['required','string'],
			'email' => ['nullable','email'],
			'phone' => ['nullable','digits:10'], 
			'seat' => ['required','int','min:1','max:180'],
			'bookingprice' => ['required','int','min:300']
		]);
		
		if ($validator->fails()) {
			$result = response()->json(['Success'=>false,'Msg'=>$validator->messages()],400);
			return $result;
		} elseif (!isset($RequestData['email']) && !isset($RequestData['phone'])) {
			$result = response()->json(['Success'=>false,'Msg'=>'You must provide either email or phone.'],400);
			return $result;
		} else {
			$flightid = explode("-",$RequestData['flight'])[1];
			$isConfirmed = ($RequestData['bookingprice'] >= 3000)?2:1; //dynamic
			$weekday = getdate(date("U"))['weekday'];
			$confirmMessage = ($RequestData['bookingprice'] >= 3000)?"is confirmed.":"has been booked.";
			$passengerId = DB::table('passenger_masters')
				->select('id')
				->where('email',$request->input('email'))
				->orWhere('phone',$request->input('phone'))->get();
				
			if(sizeof($passengerId)==0) {
				$result = response()->json(['Success'=>false,'Msg'=>'Please register yourself to book flight tickets.'],401);
				return $result;
			}
			
			$seatStatus = DB::table('flight_bookings')
				->select('id')
				->where([['seat',$RequestData['seat']],['flightschduleid',$flightid]])->get();
				
			if(sizeof($seatStatus)>0){
				$result = response()->json(['Success'=>false,'Msg'=>'Seat already taken. Please choose another seat'],401);
				return $result;
			}
			
			$bookingData = DB::table('flight_masters as a')
			->join('flight_schedules as b','a.id','=','b.flightid')
			->select('a.location as Location','b.vacantseats as AvailableSeats','b.dept_time as Departure','b.arrival_time as Arrival','b.isreturn as ReturnStatus','b.day as Day','a.id as MasterId')
			->where('b.id',$flightid)->get()->toArray();
			$day = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
			if($day[$bookingData[0]->Day-1] === $weekday && ((int)bookingData[0]->Departure<date("G"))){
				$result = response()->json(['Success'=>false,'Msg'=>'Flight not available for booking'],401);
				return $result;
			}
			
			DB::table('flight_bookings')->insert([
				array(
					'flightschduleid' => $flightid,
					'passengerid' => $passengerId[0]->id,
					'seat' => $RequestData['seat'],
					'bookingprice' => $RequestData['bookingprice'],
					'isconfirmed' => $isConfirmed
				)
			]);
			
			if($bookingData[0]->ReturnStatus==1){
				$msg = "Your Return Flight to Mumbai ".$confirmMessage." Departure: ".$bookingData[0]->Departure." Arrival: ".$bookingData[0]->Arrival." Day: ".$day[$bookingData[0]->Day-1];
			} else {
				$msg = "Your Flight to ".$bookingData[0]->Location." ".$confirmMessage." Departure: ".$bookingData[0]->Departure." Arrival: ".$bookingData[0]->Arrival." Day: ".$day[$bookingData[0]->Day-1];
			}
			
			DB::table('flight_schedules as b')->where('b.id',$flightid)->update(['b.vacantseats' => $bookingData[0]->AvailableSeats-1]);
			$result = ['Success'=>'true','Msg'=>$msg];
			$pdf = PDF::loadView('pdf',$result);
			
			//$result = response()->json(['Success'=>true,'Msg'=>$msg],200);
			return $pdf->download('ticket.pdf');
		}
	}
}