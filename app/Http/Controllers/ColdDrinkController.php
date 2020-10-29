<?php

namespace App\Http\Controllers;

use App\ColdDrink;
use Illuminate\Http\Request;
use App\Http\Resources\ColdDrink as ColdDrinkResource;

class ColdDrinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cold_drinks = ColdDrink::all();
        return ColdDrinkResource::collection($cold_drinks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
   
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
            'product_name'=>'required|string|max:255',
            'quantity'=>'required|integer',
            'price'=>'required|numeric',
        ]);

        $cold_drink = new ColdDrink;
        $cold_drink->product_name = $request->product_name;
        $cold_drink->quantity = $request->quantity;
        $cold_drink->price = $request->price;
        $cold_drink->save();
        return new ColdDrinkResource($cold_drink);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ColdDrink  $coldDrink
     * @return \Illuminate\Http\Response
     */
    public function show(ColdDrink $coldDrink)
    {
        return new ColdDrinkResource($coldDrink);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ColdDrink  $coldDrink
     * @return \Illuminate\Http\Response
     */
    public function edit(ColdDrink $coldDrink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ColdDrink  $coldDrink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ColdDrink $coldDrink)
    {
        $this->validate($request,[
            'product_name'=>'required|string|max:255',
            'quantity'=>'required|integer',
            'price'=>'required|numeric',
        ]);

      
        $coldDrink->product_name = $request->product_name;
        $coldDrink->quantity = $request->quantity;
        $coldDrink->price = $request->price;
        $coldDrink->save();
        return new ColdDrinkResource($coldDrink);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ColdDrink  $coldDrink
     * @return \Illuminate\Http\Response
     */
    public function destroy(ColdDrink $coldDrink)
    {
        $coldDrink->delete();
        return response()->json(null,204);

    }
}
