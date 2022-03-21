<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Profile;
use App\User;

class ProfileController extends Controller
{
    public function profile(){
        return view('profiles.profile');
    }

    public function addProfile(Request $request){
        $this->validate($request, [
            'name'=> 'required',
            'designation'=> 'required',
            'profile_pic'=> 'required'
            ]);
            $profiles = new Profile;
            $profiles->name = $request->input('name');
            $profiles->user_id=Auth::user()->id;
            $profiles->designation = $request->input('designation');

            if(Input::hasFile('profile_pic')){
                $this->validate($request, [
                    'profile_pic'  => 'required| mimes:jpeg,jpg,png|max:2048'
                ]);
                $file = Input::file('profile_pic');
                $file->move(public_path().'/uploads',$file->getClientOriginalName());
                $url = URL::to("/") . '/uploads/'.$file->getClientOriginalName();
            }
            $profiles->profile_pic = $url;
            $profiles->save();
            return redirect ('/home')->with('response', 'Profile Added Successfully');
    }

    public function edit($user_id){
        $users = User::find($user_id);
        return view('users.edit',['users' => $users]);
    }

    public function editUser(Request $request, $user_id){
        $this->validate($request, [
            'username'=> 'required',
            'email'=> 'required',
            'password'=> 'required'
            ]);
            $inputs = $request->all();

            $data = array(
                'name' => $inputs['username'],
                'email' => $inputs['email'],
                'password' =>  Hash::make($inputs['password'])
            );
          $resp =  User::where('id',$user_id)
                ->update($data);

            return redirect ('/home')->with('response', 'User Updated Successfully');
    }

    public function deleteUser($user_id){
        User::where('id',$user_id)
            ->delete();
            return redirect ('/home')->with('response', 'User Deleted Successfully');
    }
}
