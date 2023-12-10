@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
      <div class="card-body">

        <form id="formAuthentication" class="mb-3" action="{{ route('password.update') }}" method="POST">
          @csrf
          <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="text"
            class="form-control"
            id="email"
            name="email"
            placeholder="Enter your email"
            value="{{ $request->email, old('email') }}"
            autofocus
            required
          />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            placeholder="Enter your Password"
            value="{{ old('password') }}"
            autofocus
            required
          />
        </div>
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm Password</label>
          <input
            type="password"
            class="form-control"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="Enter your Confirm Password"
            value="{{ old('password_confirmation') }}"
            autofocus
            required
          />
        </div>
        <button class="btn btn-primary d-grid w-100">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection