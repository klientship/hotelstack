<?php

namespace App\Http\Controllers;

use App\PaidService;
use Illuminate\Http\Request;
use App\Http\Resources\PaidService as PaidServiceResource;

class PaidServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paid_services = PaidService::all();
        return PaidServiceResource::collection($paid_services);
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
            'title'=>'required|max:50|unique:paid_services',
            'price'=>'required|numeric',
            'description'=>'max:191|nullable',
            'status'=>'required|boolean',
        ]);

        $paid_service = new PaidService;
        $paid_service->title = $request->title;
        $paid_service->price = $request->price;
        $paid_service->description = $request->description;
        $paid_service->status = $request->status;
        $paid_service->save();

        return new PaidServiceResource($paid_service);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaidService  $paidService
     * @return \Illuminate\Http\Response
     */
    public function show(PaidService $paidService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaidService  $paidService
     * @return \Illuminate\Http\Response
     */
    public function edit(PaidService $paidService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaidService  $paidService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaidService $paidService)
    {
        $this->validate($request,[
            'title'=>"required|max:50|unique:paid_services,title,$paidService->id",
            'price'=>'required|numeric',
            'description'=>'max:191|nullable',
            'status'=>'required|boolean',
        ]);

    
        $paidService->title = $request->title;
        $paidService->price = $request->price;
        $paidService->description = $request->description;
        $paidService->status = $request->status;
        $paidService->save();

        return new PaidServiceResource($paidService);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaidService  $paidService
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaidService $paidService)
    {
        $paidService->delete();
        return response()->json(null,204);
    }
}
