<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Expense;
use App\ReservationPaidService;
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

     $total_expense = Expense::where('date', 'like', $today .'%')->sum('amount');
     $total_paid_service = ReservationPaidService::where('created_at', 'like', $today .'%')->sum('price');
     $total_payment = Payment::where('created_at', 'like', $today .'%')->sum('amount');

     $income = (($total_payment + $total_paid_service) - $total_expense);

     $yesterdays_total_payment = Payment::where('created_at', 'like', $yesterday .'%')->sum('amount');
     $yesterdays_total_expense = Expense::where('created_at', 'like', $yesterday .'%')->sum('amount');
     $yesterdays_total_paid_service = ReservationPaidService::where('created_at', 'like', $yesterday .'%')->sum('price');
     $yesterday_income = ($yesterdays_total_payment+$yesterdays_total_paid_service) - $yesterdays_total_expense;

     $payments = array_fill(0, 7, 0);
     $expenses = array_fill(0, 7, 0);

    //  7 items
     for ($i=0; $i < 7; $i++) { 
         if(isset($payments_array[$i]))
         {
            $payments[$i] = $payments_array[$i];
         }
         if(isset($expenses_array[$i]))
         {
            $expenses[$i] = $expenses_array[$i];
         }
     }

     if($yesterday_income){
      $gain_perc = (100*$income)/$yesterday_income;
     }else {
      $gain_perc = 0;
     }
   
    

     $o = [
         'total_payment' => $total_payment,
         'total_expense' => $total_expense,
         'payments' => [
            'series'=> [
              [
                'name' => "Payment",
                'data' => $payments,
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
                'data' => $expenses,
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
