@extends('layouts.navbar')

@section('container')
    <h1>{{$book->title}}</h1>
    <img src="{{asset('storage/'.$book->cover)}}" class="img-fluid" alt="{{$book->title}} image">
    <p>{{$book->content}}</p>
@endsection