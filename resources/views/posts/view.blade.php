@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Post View</div>

                <div class="card-body">
                    @if(count($posts) > 0)
                            @foreach($posts->all() as $post)
                                <h4>{{$post->post_title}}</h4>
                                <img src="{{$post->post_image}}" alt="">
                                <p>{{$post->post_body}}</p>

                                <ul class="nav nav-pills">
                                    <li role="presentation">
                                        <a href='{{url("/view/{$post->id}")}}'>
                                            <span class="fa fa-eye" > VIEW</span>
                                        </a>
                                    </li>
                                    @if(!empty($user_id) && $user_id== $post->user_id)
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
                            @endforeach
                        @else
                            <p>No Post Avaialble</p>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
