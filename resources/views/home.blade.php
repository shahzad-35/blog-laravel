@extends('layouts.app')
<style>
    .avatar{
        border-radius: 80%;
        max-width: 100px;
    }
</style>
@section('content')
<div class="card-deck">
    <div class="card col-sm-2 align-items-center ml-4" style="background-color: rgb(163, 197, 199)">
        <img class="rounded-circle mt-3 w-75 " src="{{ $profile->profile_pic }}" alt="Card image cap">
        <span class="name mt-3">{{ $profile->name }}</span>
    </div>

    <div class="card col-md-10">
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
        @if (session('response'))
            <div class="alert alert-success">{{ session('response') }}</div>
        @endif
        <div class="card-header">Home</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="col-md-8">
                @if (count($posts) > 0)
                    @foreach ($posts as $post)
                    <img class="rounded-circle" style="width: 10%" src="{{ $profile->profile_pic }}" alt="Card image cap">
                    <b style="font-size: 1.3rem; mb-2"> You shared a post </b><hr>
                        <h4>{{ $post->post_title }}</h4>
                        <img class="w-75 p-3" src="{{ $post->post_image }}" alt="">
                        <p>{{ substr($post->post_body, 0, 150) }}</p>

                        <ul class="nav nav-pills">
                            <li role="presentation">
                                <a href='{{ url("/view/{$post->id}") }}'>
                                    <span class="fa fa-eye mr-2"> VIEW</span>
                                </a>
                            </li>
                            @if (!empty($user_id) && $user_id == $post->user_id)
                                <li role="presentation">
                                    <a href='{{ url("/edit/{$post->id}") }}'>
                                        <span class="fa fa-pencil-square-o mr-2"> EDIT</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href='{{ url("/delete/{$post->id}") }}'>
                                        <span class="fa fa-trash mr-2"> DELETE</span>
                                    </a>
                                </li>
                            @elseif (!empty($result) && $result->role == 'Admin')
                                <li role="presentation">
                                    <a href='{{ url("/edit/{$post->id}") }}'>
                                        <span class="fa fa-pencil-square-o"> EDIT</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href='{{ url("/delete/{$post->id}") }}'>
                                        <span class="fa fa-trash"> DELETE</span>
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <cite style="float:left">Posted On:
                            {{ date('M j, y H:i', strtotime($post->updated_at)) }}</cite>
                        <hr />
                    @endforeach
                @else
                    <p>No Post Avaialble</p>
                @endif
                {{ $posts->onEachSide(5)->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
