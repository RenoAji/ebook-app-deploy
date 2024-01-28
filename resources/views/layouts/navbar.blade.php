@extends('layouts.main')
@section('body')
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Ebook App</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link @yield('active_home')" @yield('aria_home') href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link @guest disabled @endguest @yield('active_peminjaman')" @yield('aria_peminjaman') href="/peminjaman">Peminjaman</a>
          </li>
          <li class="nav-item dropdown d-flex">
            @auth
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Welcome, {{auth()->user()->username}}
              </a>
              <ul class="dropdown-menu">
                <li>
                  <form action="/logout" method="post">
                    @csrf
                    <button type="submit">Logout</button>
                  </form>
                </li>
                @can('admin')
                <li>
                  <a type="button" class="btn btn-primary" href="/tambah">
                    Tambah Buku
                  </a>
                </li>
                @endcan
              </ul>
            @endauth
            @guest
            <li class="nav-item">
              <a class="nav-link" href="/login">login</a>
            </li>
            @endguest
          </li>
        </ul>
      </div>
    </div>
  </nav>
  @yield('container')


@endsection