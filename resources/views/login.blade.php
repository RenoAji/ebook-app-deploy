@extends('layouts.main')

@section('body')
<h1>Login</h1>
<div class="container m-auto p-5">
    <form action="" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control @error('username') is-invalid @enderror" id="name" aria-describedby="emailHelp" name="username" required value={{old('username')}}>
          @error('username')
          <div class="invalid-feedback">
            {{$message}}
          </div>    
          @enderror
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control  @error('password') is-invalid @enderror" id="exampleInputPassword1" name='password'>
          @error('password')
          <div class="invalid-feedback">
            {{$message}}
          </div>    
          @enderror
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Remember me</label>
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
</div>


<p>Belum punya akun? <a href="/register">Register</a></p>
<a class="btn btn-secondary" href="/">Lanjutkan Sebagai Guest</a>
@endsection
