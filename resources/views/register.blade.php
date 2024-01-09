@extends('layouts.main')
@section('body')
<h1>Register</h1>
<div class="container m-auto p-5">
    <form action="" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" aria-describedby="emailHelp" name="username" required value={{old('username')}}>
            @error('username')
            <div class="invalid-feedback">
              {{$message}}
            </div>    
          @enderror
        </div>
    
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" name='email' required value={{old('email')}}>
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          @error('email')
          <div class="invalid-feedback">
            {{$message}}
          </div>    
          @enderror
        </div>
    
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name='password'>
          @error('password')
          <div class="invalid-feedback">
            {{$message}}
          </div>    
        @enderror
        </div>
    
        <div class="mb-3">
            <label for="confirmpass" class="form-label">Confirm Password</label>
            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirmpass" name='confirm_password'>
        </div>
          {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
</div>

<p>Sudah punya akun? <a href="/login">Login</a></p>

  
@endsection