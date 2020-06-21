@extends('template')

@section('content')
    <form action="{{ action('Web\TeamController@store') }}" method="POST">
        @csrf
        @inputTextBox('title')
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
    <p>Team {{ $points }}</p>
@endsection
