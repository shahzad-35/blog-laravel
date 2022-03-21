<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Post;
use App\User;

class PostController extends Controller
{
    public function post(){
        if(Auth::user() != null){
        $categories = Category::all();
        return view('posts.post', ['categories' => $categories]);
        }else{
            return redirect('/')->with('response', 'Login First to create post');
        }
    }

    public function addPost(Request $request){
        $this->validate($request, [
            'post_title'=> 'required',
            'post_body'=> 'required',
            'category_id'=> 'required',
            'post_image'=> 'required',
            ]);
            $posts = new Post;
            $posts->post_title = $request->input('post_title');
            $posts->user_id=Auth::user()->id;
            $posts->post_body = $request->input('post_body');
            $posts->category_id = $request->input('category_id');

            if(Input::hasFile('post_image')){
                $this->validate($request, [
                    'post_image'  => 'required| mimes:jpeg,jpg,png|max:2048'
                ]);
                $file = Input::file('post_image');
                $file->move(public_path().'/uploads',$file->getClientOriginalName());
                $url = URL::to("/") . '/uploads/'.$file->getClientOriginalName();
            }
            $posts->post_image = $url;
            $posts->save();
            return redirect ('/home')->with('response', 'Post Created Successfully');
    }
    public function view($post_id){
        $posts = Post::where('id','=',$post_id)->get();
        $categories = Category::all();
        $user_id = Auth::User()->id;
        $result = User::where('id',$user_id)
                ->where('role','Admin')
                ->first();
        return view('posts.view',['posts' =>$posts, 'categories' => $categories,'user_id' => $user_id,'result' => $result]);
    }
    public function edit($post_id){
        $categories = Category::all();
        $posts = Post::find($post_id);
        $category = Category::find($posts->category_id);

        return view('posts.edit',['categories'=>$categories, 'posts' =>$posts, 'category' => $category]);
    }

    public function editPost(Request $request, $post_id){
        $this->validate($request, [
            'post_title'=> 'required',
            'post_body'=> 'required',
            'category_id'=> 'required',
            'post_image'=> 'required',
            ]);
            $posts = new Post;
            $posts->post_title = $request->input('post_title');
            $posts->user_id=Auth::user()->id;
            $posts->post_body = $request->input('post_body');
            $posts->category_id = $request->input('category_id');

            if(Input::hasFile('post_image')){
                $this->validate($request, [
                    'post_image'  => 'required| mimes:jpeg,jpg,png|max:2048'
                ]);
                $file = Input::file('post_image');
                $file->move(public_path().'/uploads',$file->getClientOriginalName());
                $url = URL::to("/") . '/uploads/'.$file->getClientOriginalName();
            }
            //$posts->post_image = $url;
            $data = array(
                'post_title' => $posts->post_title,
                'user_id' => $posts->user_id,
                'post_body' => $posts->post_body,
                'category_id' => $posts->category_id,
                'post_image' => $posts->post_image
            );
            Post::where('id',$post_id)
                ->update($data);
            $posts->update();
            return redirect ('/home')->with('response', 'Post Updated Successfully');
    }

    public function deletePost($post_id){
        Post::where('id',$post_id)
            ->delete();
            return redirect ('/home')->with('response', 'Post Deleted Successfully');
    }

    public function deleteApiPost($post_id){
        if(Post::where('id', $post_id)->exists()) {
            $student = Post::find($post_id);
            $student->delete();

            return response()->json([
              "message" => "records deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Post not found"
            ], 404);
          }
    }

    public function getAllPosts(){
        $posts = Post::get()->toJson(JSON_PRETTY_PRINT);
        return response($posts, 200);
    }

    public function apiCreatePost(Request $request){
        $posts = new Post;
        $posts->post_title = $request->post_title;
        $posts->user_id=$request->user_id;
        $posts->post_body = $request->post_body;
        $posts->category_id = $request->category_id;

        if(Input::hasFile('post_image')){
            $this->validate($request, [
                'post_image'  => 'required| mimes:jpeg,jpg,png|max:2048'
            ]);
            $file = Input::file('post_image');
            $file->move(public_path().'/uploads',$file->getClientOriginalName());
            $url = URL::to("/") . '/uploads/'.$file->getClientOriginalName();
        }
        $posts->post_image = $url;
        $posts->save();
        return response()->json([
            "message" => "Post record created"
        ], 201);
    }

    public function viewPost($id){
        if (Post::where('id', $id)->exists()) {
            $posts = Post::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($posts, 200);
          } else {
            return response()->json([
              "message" => "Post not found"
            ], 404);
          }
    }

    public function editApiPost(Request $request){
        $post_id = $request->post_id;

        if (Post::where('id', $post_id)->exists()) {
            $post = Post::find($post_id);
            $post->post_title = is_null($request->post_title) ? $post->post_title : $request->post_title;
            $post->user_id = is_null($request->user_id) ? $post->user_id : $request->user_id;
            $post->post_body = is_null($request->post_body) ? $post->post_body : $request->post_body;
            $post->category_id = is_null($request->category_id) ? $post->category_id : $request->category_id;
            $post->post_image = $request->post_image;
            if(Input::hasFile('post_image')){
                $this->validate($request, [
                    'post_image'  => 'required| mimes:jpeg,jpg,png|max:2048'
                ]);
                $file = Input::file('post_image');
                $file->move(public_path().'/uploads',$file->getClientOriginalName());
                $url = URL::to("/") . '/uploads/'.$file->getClientOriginalName();
            }

            $post->post_image = $url;
            // $data = array(
            //     'post_title' => $posts->post_title,
            //     'user_id' => $posts->user_id,
            //     'post_body' => $posts->post_body,
            //     'category_id' => $posts->category_id,
            //     'post_image' => $posts->post_image
            // );
            // Post::where('id',$post_id)
            //     ->update($data);
            // $posts->update();




            $post->save();

            return response()->json([
                "message" => "Post updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Post not found"
            ], 404);

        }
    }
}

