@extends('layouts.navbar')

@section('active_home')
    active
@endsection
@section('aria_home')
    aria-current="page"
@endsection

@section('container')
<div class="container mt-4 d-flex flex-wrap">
    @foreach ($books as $book )
    <div class="card m-3" style="width: 18rem;">
        <img src="{{asset('storage/'.$book->cover)}}" class="card-img-top" alt="Book Cover">
        <div class="card-body">
        <h5 class="card-title">{{$book->title}}</h5>
        <p class="card-text">Author : {{$book->author}}</p>
        @if ($book->stock>0)
        <span class="badge text-bg-success">Tersedia</span> 
        @else
        <span class="badge text-bg-danger">Tidak Tersedia</span>
        @endif
        
        <a href="/detail/{{$book->id}}" class="btn btn-primary">detail</a>
        </div>
    </div>
    @endforeach 
</div>
@endsection
