@extends('layouts.app')

  @section('content')
  <div class="container">
      <h1>Create Brand</h1>
      <form action="{{ route('brands.store') }}" method="POST">
          @csrf
          <div class="mb-3">
              <label for="code" class="form-label">Code</label>
              <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
              @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-control">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
              </select>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
  </div>
  @endsection
