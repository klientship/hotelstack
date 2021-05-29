<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;
use App\User;

class FileController extends Controller
{
      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function upload(Request $request, User $user){
        
        $request->validate([
           'file' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
        
        ]);

        $fileUpload = new FileUpload;

        if($request->file()) {
            $file_name = time().'_'.$request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');

            $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
            $fileUpload->path = '/storage/' . $file_path;
            $fileUpload->user_id = $user->id;
            $fileUpload->save();

            $user->profile_img_id = $fileUpload->id;
            $user->save();
            return response()->json(['success'=>'File uploaded successfully.']);
        }
   }
}
