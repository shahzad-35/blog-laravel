<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class DashBoardController extends Controller
{
    public function dashboard(){

        $id = !empty(Auth::user()->id)?Auth::user()->id:null;
        $posts = Post::all();
        $users = User::with('profile')
        ->get();
        $data['users'] = $users;
        $data['result'] = $users;

        if(!empty($id)){
            $result = User::where('id',$id)
                ->where('role','Admin')
                ->first();
            if($result){
                return view('posts.dashboard',['users' => $users,'result' => $result]);
            }
            else{
                return view('home',['posts' => $posts]);
            }
        }
        else{
            return view('home',['posts' => $posts]);
        }
    }
    public function getDashboard(){
        $id = Auth::user()->id;

        $result = User::where('id',$id)
                ->where('role','Admin')
                ->first();

        return view('layouts.app',['result' => $result]);
    }
}
