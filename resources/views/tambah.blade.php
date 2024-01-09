@extends('layouts.main')

@section('body')
<form action="tambah" method="POST" enctype="multipart/form-data">
      @csrf
      {{-- Title --}}
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input required type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
      </div>
      @error('title')
      <div class="invalid-feedback">
        {{$message}}
      </div>    
      @enderror
      {{-- Author --}}
      <div class="mb-3">
        <label for="author" class="form-label">Author</label>
        <input type="text" required class="form-control @error('author') is-invalid @enderror" id="author" name="author">
      </div>
      @error('author')
      <div class="invalid-feedback">
        {{$message}}
      </div>    
      @enderror
      {{-- Desc --}}
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea required class="form-control @error('description') is-invalid @enderror" id="description" rows="3" name='description'></textarea>
      </div> 
      @error('description')
      <div class="invalid-feedback">
        {{$message}}
      </div>    
      @enderror                         
      {{-- Content --}}
      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea required class="form-control @error('content') is-invalid @enderror" id="content" rows="8" name='content'></textarea>
      </div>
      @error('content')
      <div class="invalid-feedback">
        {{$message}}
      </div>    
      @enderror
      {{-- Cover --}}
      <div class="mb-3">
        <label for="cover" class="form-label">Cover</label>
        <input class="form-control @error('cover') is-invalid @enderror" type="file" required id="cover" name="cover">
      </div>
      @error('cover')
      <div class="invalid-feedback">
        {{$message}}
      </div>    
      @enderror
      {{-- Stock --}}
      <div class="mb-3">
        <label for="stock" class="form-label">Jumlah</label>
        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" required min="1">
      </div>
      @error('stock')
      <div class="invalid-feedback">
        {{$message}}
      </div>    
      @enderror

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
<a href="/">Batal</a>

@endsection