@extends('layouts.app')

  @section('content')
  <div class="container">
      <h1>Edit Category</h1>
      <form action="{{ route('categories.update', $category) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
              <label for="code" class="form-label">Code</label>
              <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $category->code) }}">
              @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}">
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
          <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
  </div>
  @endsection
