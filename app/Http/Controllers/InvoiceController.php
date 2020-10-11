<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\Invoice;
use Illuminate\Http\Request;
use App\Http\Resources\Invoice as InvoiceResource;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return InvoiceResource::collection($invoices);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function this_month()
    {
        $date = Carbon::now();
        $invoices = $this->getMonthly($date);
        return InvoiceResource::collection($invoices);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function last_month()
    {
        $date = Carbon::now();
        $invoices = $this-> getLastMonth($date);
        return InvoiceResource::collection($invoices);
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
        //
    }

    /**
     * Display the specified resource.
     *

     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function show(Reservation $invoice, Request $request)
    {
        // $invoice = Reservation::findOrfail('id', $invoice->id)

        // if(Invoice::findOrfail('id', $invoice->id)) 
        // {
        //     return $invoice;
        // }else {
        //     $invoice = new Invoice;
        //     $invoice
        // }

 

        
    }

    /**
     * Show the form for editing the specified resource.
     *
    * @param  \App\Reservation  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function getMonthly($date)
    {
        $year = $date->year;
        $month = $date->month;

        if ($month < 10) {
            $month = '0' . $month;
        }

        $search = $year . '-' . $month;

        $invoices = Invoice::where('created_at', 'like', $search .'%')->latest()->get();

        return $invoices;
    }
    public function getLastMonth($date)
    {
        $year = $date->year;
        $month = $date->month - 1;

        if ($month < 10) {
            $month = '0' . $month;
        }

        $search = $year . '-' . $month;

        $invoices = Invoice::where('created_at', 'like', $search .'%')->latest()->get();

        return $invoices;
    }
}
