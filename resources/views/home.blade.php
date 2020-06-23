@extends('layouts.app')

@section('content')
    <div id="app" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if(Session::has('message'))
                    <div class="alert alert-success">
                        {{session('message')}}
                    </div>
                @endif
                <div class="card">

                    @if ($user_id == 1 || 1 == 1)
                        <div class="card-header">Send push to Users</div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <form action="" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$user->id}}" />

                                                <input class="btn btn-primary" type="submit" value="Send Push">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="card-header">User Panel</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
