@extends('layouts.app')
<style>
    .avatar{
        border-radius: 80%;
        max-width: 100px;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            @endif
            @if(session('response'))
                        <div class="alert alert-success">{{session('response')}}</div>
            @endif
                <div class="card-header">Home</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-6">
                        @if(!empty($profile))
                            <img src="{{ $profile->profile_pic}}" class="avatar" alt="" />
                            <p class="lead">{{$profile->name}}</p>
                            <p>{{$profile->designation}}</p>
                        @else
                            <img src="{{ url('images/blank.png') }}" class="avatar" alt="" />
                            <p></p>
                            <p></p>
                        @endif
                        @if(count($posts) > 0)
                            @foreach($posts->all() as $post)
                                <h4>{{$post->post_title}}</h4>
                                <img class="w-75 p-3" src="{{$post->post_image}}" alt="">
                                <p>{{substr($post->post_body,0,150)}}</p>

                                <ul class="nav nav-pills">
                                    <li role="presentation">
                                        <a href='{{url("/view/{$post->id}")}}'>
                                            <span class="fa fa-eye mr-2"> VIEW</span>
                                        </a>
                                    </li>
                                    @if(!empty($user_id) && $user_id== $post->user_id)
                                        <li role="presentation">
                                            <a href='{{url("/edit/{$post->id}")}}'>
                                                <span class="fa fa-pencil-square-o mr-2"> EDIT</span>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href='{{url("/delete/{$post->id}")}}'>
                                                <span class="fa fa-trash mr-2"> DELETE</span>
                                            </a>
                                        </li>
                                    @elseif (!empty($result) && $result->role == 'Admin')
                                        <li role="presentation">
                                            <a href='{{url("/edit/{$post->id}")}}'>
                                                <span class="fa fa-pencil-square-o"> EDIT</span>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href='{{url("/delete/{$post->id}")}}'>
                                                <span class="fa fa-trash"> DELETE</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                                <cite style="float:left">Posted On: {{date('M j, y H:i', strtotime($post->updated_at))}}</cite>
                                <hr/>
                            @endforeach
                        @else
                            <p>No Post Avaialble</p>
                        @endif
                        {{-- {{$posts->links()}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
