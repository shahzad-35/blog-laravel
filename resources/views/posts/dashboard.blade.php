@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">User Name</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($users) > 0)
                                @foreach($users->all() as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td><a href='{{url("/editU/{$user->id}")}}'><span class="fa fa-pencil-square-o" > Edit</span></a></td>
                                        <td><a href='{{url("/deleteU/{$user->id}")}}'><span class="fa fa-trash" > Delete</span></a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
