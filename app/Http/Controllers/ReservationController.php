<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\ReservationRoom;
use App\Payment;
use App\Invoice;
use App\User;
use App\HouseKeeping;
use App\ReservationPaidService;
use Helpers;


use Illuminate\Http\Request;
use App\Http\Resources\Reservation as ReservationResource;
use App\Http\Resources\ReservationPaidService as ReservationPaidServiceResource;
use App\Http\Resources\HomeReservation as HomeReservationResource;
use App\Http\Resources\ReservationPayment as ReservationPaymentResource;

use Carbon\Carbon;
class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where('checked_in', 0)->latest()->get();
        return ReservationResource::collection($reservations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $this->validate($request,[
           
            'adults'=>'required|integer|max:100',
            'kids'=>'required|integer|max:100',
            'check_in'=>'required|date',
            'check_out'=>'required|date',
            'total'=>'required|numeric',
            'discount'=>'required|numeric',
            'advance'=>'required|numeric',
            'balance'=>'required|numeric',
            'email'=>'nullable|email|max:255',
            'name'=>'required|max:255',
            'phone'=>'required|max:255',
            'rooms'=>'required|max:255',
            'oyo_id'=>'nullable|max:255',
            'oyo' =>'nullable|boolean'
        ]);

        $request->rooms = json_encode($request->rooms);
        $request->rooms = json_decode($request->rooms);

        // create guest
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->company_name = $request->company_name;
        $user->gst_no = $request->gst_no;
        $user->address = $request->address;
        $user->password = '123456';
        $user->role = 'customer';
        $user->save();

       

        $reservation = new Reservation;
        $reservation->uid = sprintf("%06d", mt_rand(1, 999999));
        $reservation->guest_id = $user->id;
        $reservation->adults = $request->adults;
        $reservation->kids = $request->kids;
        $reservation->check_in = Carbon::createFromFormat('d-m-Y H:i', $request->check_in)->format('Y-m-d H:i');
        $reservation->check_out = Carbon::createFromFormat('d-m-Y H:i',$request->check_out)->format('Y-m-d H:i');
        $reservation->number_of_room = count($request->rooms);
        $reservation->total = $request->total;
        $reservation->discount = $request->discount;
        $reservation->checked_in = $request->checked_in;
        $reservation->oyo_id = $request->oyo_id;
        $reservation->oyo = $request->oyo ? 1:0;
        $reservation->status = 'SUCCESS';
        $reservation->save();
        

        $reservation->uid = Helpers::createUid($reservation->id);
        $reservation->save();
        // advance
        if( $request->advance> 0) {
            $payment = new Payment;
            $payment->amount = $request->advance;
            $payment->reservation_id = $reservation->id;
            $payment->advance = 1;
            $payment->type = $request->payment_type;
            $payment->save();
        }
    

        foreach ($request->rooms as $key => $r) {
            $room  = new ReservationRoom;
            $room->room_id = $r->id;
            $room->reservation_id = $reservation->id;
            $room->price= $r->price;
            $room->save();
        }
  
        return new ReservationResource($reservation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {

        return new ReservationResource($reservation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
     
        $this->validate($request,[
           
            'adults'=>'required|integer|max:100',
            'kids'=>'required|integer|max:100',
            'check_in'=>'nullable|date',
            'check_out'=>'nullable|date',
            'total'=>'required|numeric',
            'discount'=>'required|numeric',
            'balance'=>'required|numeric',
            'email'=>'nullable|email|max:255',
            'name'=>'required|max:255',
            'phone'=>'required|max:255',
            'rooms'=>'required',
            'uid' => 'required|max:255',
            'payments'=>'nullable',
            'oyo_id'=>'nullable|max:255',
            'oyo' =>'nullable|boolean'
        ]);

// $reservation = Reservation::findOrFail($request->id);
        $request->rooms = json_encode($request->rooms);
        $request->rooms = json_decode($request->rooms);

        $request->payments = json_encode($request->payments);
        $request->payments = json_decode($request->payments);
  

        // // create guest
        $user = User::findOrFail($reservation->guest->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->company_name = $request->company_name;
        $user->gst_no = $request->gst_no;
        $user->address = $request->address;
        $user->password = '123456';
        $user->role = 'customer';
        $user->save();

     
        
        $reservation->uid = $request->uid;
        $reservation->oyo_id = $request->oyo_id;
        $reservation->oyo = $request->oyo ? 1:0;
        $reservation->guest_id = $user->id;
        $reservation->adults = $request->adults;
        $reservation->kids = $request->kids;
        if($request->check_in && $request->check_out) {
            $reservation->check_in = Carbon::createFromFormat('d-m-Y H:i', $request->check_in)->format('Y-m-d H:i');
            $reservation->check_out = Carbon::createFromFormat('d-m-Y H:i',$request->check_out)->format('Y-m-d H:i');
              
            ReservationRoom::where('reservation_id',$reservation->id)->delete();

            foreach ($request->rooms as $key => $r) {
                $room  = new ReservationRoom;
                $room->room_id = $r->room_id;
                $room->reservation_id = $reservation->id;
                $room->price= $r->price;
                $room->save();
            }
        }

  

        $reservation->number_of_room = count($request->rooms);
        $reservation->total = $request->total;
        $reservation->discount = $request->discount;
        $reservation->checked_in = $request->checked_in;
        $reservation->uid = $request->uid;
        $reservation->status = 'SUCCESS';
        $reservation->save();

   
  
        return new ReservationResource($reservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        ReservationRoom::where('reservation_id',$reservation->id)->delete();
        Payment::where('reservation_id',$reservation->id)->delete();
        ReservationPaidService::where('reservation_id',$reservation->id)->delete();
        Invoice::where('reservation_id',$reservation->id)->delete();

        $reservation->delete();
        return response()->json(null,204);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function getInvoice(Reservation $reservation)
    {
 
        
        if(!$reservation->invoice) 
        {
            $reservation->invoice = true;
            $reservation->save();
            $invoice = new Invoice;
            $invoice->reservation_id = $reservation->id;
            $my_id = sprintf('%05d', $reservation->id);
            $invoice->no = "INV2021". $my_id;
            $invoice->save();
            $my_id = sprintf('%05d', $invoice->id);
            $invoice->no = "INV2021". $my_id;
            $invoice->save();
        }
      
        return new ReservationResource($reservation);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function check_in(Reservation $reservation)
    {
      
        $reservation->checked_in = 1;
        $reservation->save();
        return $reservation;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function check_out(Reservation $reservation)
    {
      
        $reservation->checked_out = 1;
        $reservation->check_out = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i');

        // nights calculation
       $nights = Helpers::getNights($reservation->check_in, $reservation->check_out);
        //recalculate Total 
        
        if ($reservation->rooms && count($reservation->rooms)) {
        
            $total = 0;
        
            for ($i=0; $i < count($reservation->rooms); $i++) { 
                if($nights) {
                $total += $reservation->rooms[$i]->price * $nights;
                }else {
                    $total += $reservation->rooms[$i]->price;
                }
            }
            $reservation->total = $total;
        } else {
            $reservation->total = 0;
        }

        $reservation->save();

  

        foreach ($reservation->rooms as $key => $room) {
            $houseKeeping = new HouseKeeping;
            $houseKeeping->room_id = $room->room_id;
            $houseKeeping->save();
        }
        return $reservation;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function no_show(Reservation $reservation)
    {
      
        $reservation->no_show = 1;
        $reservation->save();
        return $reservation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function getPaidServices(Reservation $reservation)
    {

        return new ReservationPaidServiceResource($reservation);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function getPayments(Reservation $reservation)
    {

        return ReservationPaymentResource::collection($reservation->payments);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recent_checkins()
    {
        $reservations = Reservation::where('checked_in', 1)->take(5)->latest()->get();
        return HomeReservationResource::collection($reservations);
    }
    public function todays_checkins()
    {
         $today = strval(Carbon::now()->format('Y-m-d'));
        $reservations = Reservation::where('checked_in', 1)->where('check_in', 'like', $today.'%' )->latest()->get();
        return HomeReservationResource::collection($reservations);
    }
    public function todays_checkouts()
    {
        $today = strval(Carbon::now()->format('Y-m-d'));
        $reservations = Reservation::where('checked_out', 1)->where('check_out', 'like', $today.'%' )->latest()->get();
        return HomeReservationResource::collection($reservations);
    }

}
