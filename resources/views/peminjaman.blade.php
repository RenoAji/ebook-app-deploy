@extends('layouts.navbar')
@php
    use Illuminate\Support\Carbon;
@endphp
@section('active_peminjaman')
    active
@endsection
@section('aria_peminjaman')
    aria-current="page"
@endsection

@section('container')
<div class="accordion" id="accordionPanelsStayOpenExample">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
          Buku yang sedang dipinjam
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
        <div class="accordion-body">
          @if ($confirmed->count()>0)
            <table class="table table-bordered table-hover">
                <tbody>
                    <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nama Buku</th>
                          <th scope="col">Tanggal Peminjaman disetujui</th>
                          <th scope="col">Berlaku sampai</th>
                          @cannot('admin')
                            <th scope="col">Aksi</th>
                          @endcannot 
                          @can('admin')
                          <th scope="col">Peminjam</th>
                          @endcan
                        </tr>
                      </thead>
                        @foreach ($confirmed as $peminjaman)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$peminjaman->book->title}}</td>
                            <td>                              
                              @php
                                $dt = new Carbon($peminjaman->confirmed_at);
                                echo $dt->format("d F Y");
                              @endphp
                            </td>
                            <td>
                              @php
                                  $expired_dt = new Carbon($peminjaman->expired_at);
                                  echo $expired_dt->format("d F Y");
                              @endphp
                            </td>
                            @can('read',$peminjaman)
                              <td>
                                <a href="/baca/{{$peminjaman->id}}" class="btn btn-primary">Baca</a>
                                <form action="/kembali/{{$peminjaman->id}}" method="POST">
                                  @csrf
                                  <button type="submit" class="btn btn-secondary">Kembalikan buku</button>
                                </form>
                              </td>
                            @endcan
                            @can('admin')
                                <td>{{$peminjaman->user->username}}</td>
                            @endcan  
                          </tr>
                        @endforeach
            @else
                Tidak Ada Peminjaman
            @endif

                </tbody>
              </table>
        </div>
      </div>
    </div>

    <br>
    {{-- ------------------------------------------------------------------------------------------------------------------- --}}
    <br>

    
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
            @can('admin')
                Antrian peminjaman yang belum disetujui
            @endcan
            @cannot('admin')
                Menunggu persetujuan dari admin
            @endcannot
        </button>
      </h2>
      <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
        <div class="accordion-body">
          @if ($notConfirmed->count() > 0)
          <table class="table table-bordered table-hover">
            <tbody> 
                <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nama Buku</th>
                      <th scope="col">Tanggal Peminjaman</th>
                      @can('admin')
                      <th scope="col">Peminjam</th>
                      @endcan
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                    @foreach ($notConfirmed as $peminjaman)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$peminjaman->book->title}} 
                          <a href="detail/{{$peminjaman->book->id}}" class="badge text-bg-primary">Detail</a>
                        </td>
                        <td>
                          @php
                            $dt = new Carbon($peminjaman->created_at);
                            echo $dt->format("d F Y");
                          @endphp
                        </td>
                        @can('admin')
                        <td>
                          {{$peminjaman->user->username}}
                        </td>
                        @endcan
                        <td>
                          <form action="cancel/{{$peminjaman->id}}" method="POST">
                              @csrf
                              <button type="submit" class="btn btn-danger">
                                @can('admin')
                                    Tolak Peminjaman
                                @endcan
                                @cannot('admin')
                                    Batalkan Peminjaman
                                @endcannot
                              </button>
                          </form>
                        
                          @can('admin')
                          <form action="confirm/{{$peminjaman->id}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Setujui Peminjaman</button>
                          </form>
                          @endcan
                        </td>
                      </tr>

                    @endforeach
                    </table>
                @else
                  Tidak Ada Peminjaman
                @endif
        </div>
      </div>
    </div>



    <br>
    {{-- ------------------------------------------------------------------------------------------------------------------- --}}
    <br>

    
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
          Peminjaman Kadaluarsa
        </button>
      </h2>
      <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
        <div class="accordion-body">
          @if ($expired->count() > 0)
          <table class="table table-bordered table-hover">
            <tbody>
                <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nama Buku</th>
                      <th scope="col">Tanggal Peminjaman Berakhir</th>
                      @can('admin')
                      <th scope="col">Peminjam</th>
                      @endcan
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                    @foreach ($expired as $peminjaman)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$peminjaman->book->title}} 
                          <a href="detail/{{$peminjaman->book->id}}" class="badge text-bg-primary">Detail</a>
                        </td>
                        <td>
                          @php
                            $dt = new Carbon($peminjaman->expired_at);
                            echo $dt->format("d F Y");
                          @endphp
                        </td>
                        @can('admin')
                        <td>
                          {{$peminjaman->user->username}}
                        </td>
                        @endcan
                        <td>
                          <form action="/kembali/{{$peminjaman->id}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary">
                              @cannot('admin')
                                Kembalikan Buku
                              @endcannot
                              @can('admin')
                                  Tarik buku
                              @endcan
                            </button>
                          </form>
                          
                          @cannot('admin')
                            <form action="perpanjang/{{$peminjaman->id}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                  Perpanjang peminjaman
                                </button>
                            </form>    
                          @endcannot
                        </td>
                      </tr>

                    @endforeach
          </table>
                @else
                  Tidak Ada Peminjaman
                @endif
        </div>
      </div>
    </div>
</div>
@endsection