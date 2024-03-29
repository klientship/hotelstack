<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Expense;
use App\ReservationPaidService;
use App\Reservation;
use App\ReservationColdDrink;
use App\ColdDrink;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Resources\Payment as PaymentResource;
use App\Http\Resources\AllPayment as AllPaymentResource;
use Helpers;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $payments = Payment::latest()->get();
       return AllPaymentResource::collection($payments);
    }

    public function this_month()
    {
      $payments = Helpers::getThisMonth(Payment::class);
       return AllPaymentResource::collection($payments);
    }
    public function last_month()
    {
      $payments = Helpers::getLastMonth(Payment::class);
       return AllPaymentResource::collection($payments);
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
           
            'amount'=>'required|numeric|min:1',
            // 'advance'=>'required|boolean|max:100',
            'reservation_id'=>'required|integer|max:100',
            'type'=>'required|max:255'
        ]);
        
   
        $payment = new Payment;
        $payment->amount = $request->amount;
        $payment->reservation_id = $request->reservation_id;
        $payment->advance = $request->advance ? 1:0;
        $payment->type = $request->type;
        $payment->save();

        return $payment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
     $payment->delete();
     return response()->json(null,204); 
    }

    public function todays_details()
    {

   
    
     $today =  Carbon::today()->format('Y-m-d');
     $yesterday = Carbon::yesterday()->format('Y-m-d');

  
     $payments_array = Payment::where('created_at', 'like', $today .'%')->pluck('amount')->toArray();
     $expenses_array = Expense::where('created_at', 'like', $today .'%')->pluck('amount')->toArray();
     $todays_business_array = Reservation::where('created_at', 'like', $today .'%')->pluck('total')->toArray();
     $todays_pending_payment_array =  Payment::where('created_at', 'like', $today .'%')->pluck('amount')->toArray();
     $todays_walkin_business_array = Reservation::where('created_at', 'like', $today .'%')->where('checked_in',1)->where('oyo',0)->pluck('total')->toArray();
     $todays_oyo_business_array = Reservation::where('created_at', 'like', $today .'%')->where('oyo',1)->pluck('total')->toArray();
     $todays_cold_drink_business_array = ReservationColdDrink::where('created_at', 'like', $today .'%')->pluck('total')->toArray();
     $todays_paid_service_business_array = ReservationPaidService::where('created_at', 'like', $today .'%')->pluck('price')->toArray();
     $todays_checkin_business_array = Reservation::where('created_at', 'like', $today .'%')->where('checked_in',1)->pluck('total')->toArray();
     $todays_checkout_business_array = Reservation::where('created_at', 'like', $today .'%')->where('checked_out',1)->pluck('total')->toArray();
     $todays_future_bookings_business_array = Reservation::where('created_at', 'like', $today .'%')->where('checked_in',0)->pluck('total')->toArray();

     $total_expense = Expense::where('date', 'like', $today .'%')->sum('amount');
     
     $total_paid_service = ReservationPaidService::where('created_at', 'like', $today .'%')->sum('price');
     
     $total_payment = Payment::where('created_at', 'like', $today .'%')->sum('amount');
     
     $todays_walkin_business = Reservation::where('created_at', 'like', $today .'%')->where('checked_in',1)->where('oyo',0)->sum('total') - Reservation::where('created_at', 'like', $today .'%')->where('checked_in',1)->where('oyo',0)->sum('discount');
     
     $todays_cold_drink_business = ReservationColdDrink::where('created_at', 'like', $today .'%')->sum('total');
     
    //  $todays_business = ((Reservation::where('created_at', 'like', $today .'%')->sum('total') + $total_paid_service + $todays_cold_drink_business) - Reservation::where('created_at', 'like', $today .'%')->sum('discount')) - $total_expense;
     $todays_business =(($total_payment + $todays_cold_drink_business + $total_paid_service) - $total_expense);
     
    $current_checkedins = Reservation::where('checked_in',1)->where('checked_out',0)->orWhere('check_out', 'like', $today .'%')->get();

    // $todays_business = 0;

    //   foreach ($current_checkedins as $key => $checkedin) {
    //     $todays_business += $checkedin->rooms->sum('price');
    //   }
    
     $todays_pending_payment =  $todays_business - $total_payment;
     
     $todays_oyo_business =  Reservation::where('created_at', 'like', $today .'%')->where('oyo',1)->sum('total') - Reservation::where('created_at', 'like', $today .'%')->where('oyo',1)->sum('discount');
     
     $todays_cold_drink_business =  ReservationColdDrink::where('created_at', 'like', $today .'%')->sum('total');
     $todays_paid_service_business =  ReservationPaidService::where('created_at', 'like', $today .'%')->sum('price');
     
    //  payments
     $total_payments_received =  Payment::all()->sum('amount');
     $total_business = Reservation::all()->sum('total') - Reservation::all()->sum('discount');
     $total_pending_payments =  $total_business - $total_payments_received;

     



    //  $total_cold_drinks =  ColdDrink::all()->count();
    //  $total_paid_services =  ReservationPaidService::all()->count();
     $total_no_walkin_business =  Reservation::where('created_at', 'like', $today .'%')->where('checked_in',1)->where('oyo',0)->count();
     $total_no_oyo_business =  Reservation::where('created_at', 'like', $today .'%')->where('oyo',1)->count();
     $total_no_today_checkin =  Reservation::where('created_at', 'like', $today .'%')->where('checked_in',1)->count();
     $total_no_checkedin =  Reservation::where('checked_in',1)->where('checked_out',0)->sum('number_of_room');
     $total_no_today_checkout =  Reservation::where('check_out', 'like', $today .'%')->where('checked_out',1)->count();
     $total_no_future_bookings =  Reservation::where('created_at', 'like', $today .'%')->where('checked_in',0)->count();
     $total_no_checkin =  Reservation::where('checked_in',1)->count();

     $income = (($todays_business) - $total_expense);

     $yesterdays_total_payment = Payment::where('created_at', 'like', $yesterday .'%')->sum('amount');
     $yesterdays_total_expense = Expense::where('created_at', 'like', $yesterday .'%')->sum('amount');
     $yesterdays_total_paid_service = ReservationPaidService::where('created_at', 'like', $yesterday .'%')->sum('price');
     $yesterday_income = ($yesterdays_total_payment+$yesterdays_total_paid_service) - $yesterdays_total_expense;

   
    //  seven days details
  

     $LastSevenPayments = Helpers::getSevenDays($payments_array);
     $LastSevenExpenses = Helpers::getSevenDays($expenses_array);
     $LastSevenBusiness = Helpers::getSevenDays($todays_business_array);
     $LastSevenPendingPayments = Helpers::getSevenDays($todays_pending_payment_array);
     $LastSevenWalkinBusiness = Helpers::getSevenDays($todays_walkin_business_array);
     $LastSevenOyoBusiness = Helpers::getSevenDays($todays_oyo_business_array);
     $LastSevenColdDrinkBusiness = Helpers::getSevenDays(  $todays_cold_drink_business_array);
     $LastSevenColdServiceBusiness = Helpers::getSevenDays($todays_paid_service_business_array);
     $LastSevenCheckInBusiness = Helpers::getSevenDays( $todays_checkin_business_array);
     $LastSevenCheckOutBusiness = Helpers::getSevenDays($todays_checkout_business_array);
     $LastSevenFutureBookingsBusiness = Helpers::getSevenDays($todays_future_bookings_business_array);


     $awaiting_checkout = count(Helpers::getAwaitingCheckout());

     if($yesterday_income){
      $gain_perc = (100*$income)/$yesterday_income;
     }else {
      $gain_perc = 0;
     }
   
    

     $o = [
         'total_payment' => $total_payment,
         'total_payments_received'=> $total_payments_received,
         'total_pending_payments'=> $total_pending_payments,
         'total_expense' => $total_expense,
         'todays_business' => $todays_business,
         'todays_pending_payment' => $todays_pending_payment,
         'todays_walkin_business' => $todays_walkin_business,
        //  'total_cold_drinks' => $total_cold_drinks,
         'todays_oyo_business' => $todays_oyo_business,
        //  'total_paid_services' => $total_paid_services,
         'total_no_walkin_business' => $total_no_walkin_business,
         'total_no_oyo_business' => $total_no_oyo_business,
         'total_no_today_checkin' => $total_no_today_checkin,
         'total_no_today_checkout' => $total_no_today_checkout,
         'total_no_future_bookings' => $total_no_future_bookings,
         'total_no_checkedin' => $total_no_checkedin,
         'todays_cold_drink_business' => $todays_cold_drink_business,
         'todays_paid_service_business' => $todays_paid_service_business,
         'total_no_checkin' => $total_no_checkin,

         'awaiting_checkout' => $awaiting_checkout,
     
         'future_bookings_business' => [
            'series'=> [
              [
                'name' => "Checkin",
                'data' =>  $LastSevenFutureBookingsBusiness,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
         'checkout_business' => [
            'series'=> [
              [
                'name' => "Checkin",
                'data' =>  $LastSevenCheckOutBusiness,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
     
         'checkin_business' => [
            'series'=> [
              [
                'name' => "Checkin",
                'data' =>  $LastSevenCheckInBusiness,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
         'paid_services' => [
            'series'=> [
              [
                'name' => "Paid Service",
                'data' =>  $LastSevenColdServiceBusiness,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
         'cold_drinks' => [
            'series'=> [
              [
                'name' => "Cold Drink",
                'data' =>  $LastSevenColdDrinkBusiness,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
         'oyo_business' => [
            'series'=> [
              [
                'name' => "Oyo Business",
                'data' =>  $LastSevenOyoBusiness,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
         'walkin_business' => [
            'series'=> [
              [
                'name' => "Walkin Business",
                'data' =>  $LastSevenWalkinBusiness,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
         'business' => [
            'series'=> [
              [
                'name' => "Business",
                'data' =>  $LastSevenBusiness,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
         'payments' => [
            'series'=> [
              [
                'name' => "Payment",
                'data' => $LastSevenPayments,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
        'expenses' => [
            'series'=> [
              [
                'name' => "Expense",
                'data' =>  $LastSevenExpenses ,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
        'pending_payments' => [
            'series'=> [
              [
                'name' => "Pending Payment",
                'data' =>  $LastSevenPendingPayments ,
              ],
            ],
            'analyticsData' => [
              'orders'=> 97500,
         ],
        ],
         'income' => $income,
         'gain_percentage' => $gain_perc
        ];
     return $o;
    }
}
