@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
      <div class="card-header d-flex align-items-center">
        <a href="{{ route('profile.index') }}"><i class="menu-icon tf-icons bx bx-chevron-left"></i></a>
        <h5 class="mb-0">Ubah Password</h5>
      </div>
      <div class="card-body">
        <form id="formAuthentication" class="mb-3" action="{{ route('password.update') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="password" class="form-label">Password Saat ini</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
              name="password" placeholder="Password Saat ini" autofocus required />
            @error('password')
            <div class="invalid-feedback d-block">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="new_password" class="form-label">Password Baru</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password"
              name="new_password" placeholder="Password Baru" autofocus required />
            @error('new_password')
            <div class="invalid-feedback d-block">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
              id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" autofocus
              required />
            @error('password_confirmation')
            <div class="invalid-feedback d-block">
              {{ $message }}
            </div>
            @enderror
          </div>
          <button class="btn btn-primary d-grid w-100">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection