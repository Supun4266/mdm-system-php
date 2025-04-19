@extends('layouts.app')

  @section('content')
  <div class="container">
      <h2 class="text-center mb-4">MDM Login</h2>
      <div class="row justify-content-center">
          <div class="col-md-6">
              <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="mb-3">
                      <label for="email" class="form-label">{{ __('Email Address') }}</label>
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                      @error('email')
                          <span class="invalid-feedback" role="alert">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="mb-3">
                      <label for="password" class="form-label">{{ __('Password') }}</label>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                      @error('password')
                          <span class="invalid-feedback" role="alert">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="mb-3">
                      <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  @endsection
