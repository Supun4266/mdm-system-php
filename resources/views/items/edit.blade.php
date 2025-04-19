@extends('layouts.app')

  @section('content')
  <div class="container">
      <h1>Edit Item</h1>
      <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
              <label for="brand_id" class="form-label">Brand</label>
              <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                  <option value="">Select Brand</option>
                  @foreach ($brands as $brand)
                      <option value="{{ $brand->id }}" {{ $brand->id == $item->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                  @endforeach
              </select>
              @error('brand_id')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="category_id" class="form-label">Category</label>
              <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                  <option value="">Select Category</option>
                  @foreach ($categories as $category)
                      <option value="{{ $category->id }}" {{ $category->id == $item->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                  @endforeach
              </select>
              @error('category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="code" class="form-label">Code</label>
              <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $item->code) }}">
              @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}">
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="attachment" class="form-label">Attachment</label>
              <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror">
              @if ($item->attachment)
                  <p>Current: <a href="{{ Storage::url($item->attachment) }}" target="_blank">View Attachment</a></p>
              @endif
              @error('attachment')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
          <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
  </div>
  @endsection
