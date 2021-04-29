<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|email|unique:users,email,'.$user->id,
            // 'password' => ['required', 'string', 'min:4'],
            'phone' => ['string', 'max:255'],
            'gst_no' => ['string', 'max:255'],
            'address_line_1' => ['string', 'max:1000'],
            'address_line_2' => ['string', 'max:1000'],
            'zipcode' => ['string', 'max:255'],
        ]);
     
        // dont allow user to update role & password
        $input = $request->all();
        if($input['role'])
        {
            unset($input['role']);
        }
        if($input['password'])
        {
            unset($input['password']);
        }
        $user->fill($input)->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
