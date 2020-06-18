@extends('template')

@section('content')
    <form action="{{ action('Web\TeamController@store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label form="title">Title</label>
            <input type="text" class="form-control" name="title" id="title">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
