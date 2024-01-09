@extends('layouts.navbar')
@section('container')
<div class="container mt-4">
    <img src="{{asset('storage/'.$book->cover)}}" class="img-fluid" alt="...">
    <h3>Title : {{$book->title}}</h3>
    <h3>Author : {{$book->author}}</h3>
    <h3>Description :</h3>
    <p>{{$book->description}}</p>
    <h3>Stock : {{$book->stock}}</h3>

    {{-- Pinjam buku --}}
    @if ($book->stock > 0)
    @cannot('admin')
    @auth
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjam">
        Pinjam Buku
        </button>
      
        <!-- Modal -->
        <div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body">
                            Ingin meminjam buku ini?          
                                @csrf
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Pinjam</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth
    @endcannot
    @endif
    {{-- End Pinjam Buku --}}


    {{-- Update Buku, Hapus Buku --}}
    @can('admin')
        {{-- UPDATE --}}
        <!-- Button trigger modal  -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUpdate">
            Update stock
        </button>
          
            <!-- Modal -->
            <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/update/{{$book->id}}" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required min="0">
                                </div>         
                                @csrf
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            {{-- DELETE --}}
            <!-- Button trigger modal  -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                Hapus buku
            </button>
              
                <!-- Modal -->
                <div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/delete/{{$book->id}}" method="POST">
                                <div class="modal-body">       
                                    @csrf
                                    Yakin ingin menghapus buku {{$book->title}}?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>        
    @endcan
    
</div>
@endsection