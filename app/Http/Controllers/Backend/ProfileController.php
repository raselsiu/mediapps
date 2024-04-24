<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function view()
    {
        $id = Auth::user()->id;
        $authUser = User::find($id);
        return view('backend.user.view_profile',compact('authUser'));
    }

    
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        return view('backend.user.edit_profile',compact('user'));
        
    }

 
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if($request->file('image')){
            $file = $request->file('image');
            @unlink(public_path('backend/img/uploads/'.$user->image));
            $fileName = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('backend/img/uploads/'),$fileName);
            $user->image = $fileName;
        }

        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->save();
        return redirect()->route('profileView')->with('success','Profile Updated Successfully!');


    }

    public function passwordView(){
        return view('backend.user.edit_password');
    }

    public function updatePassword(Request $request){

        if(Auth::attempt(['id' => Auth::user()->id, 'password' => $request->current_password])){
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect()->route('profileView')->with('success', 'Password Changed Successfully!');
        }
        else{
            return redirect()->back()->with('error', 'Sorry your current password does not match!');
        }
        
    }


}
