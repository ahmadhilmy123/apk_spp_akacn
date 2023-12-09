@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <form
                action="{{ isset($data) ? route('data-master.tahun-ajaran.update', $data->id) : route('data-master.tahun-ajaran.store') }}"
                method="POST">
                @csrf
                @if (isset($data))
                @method('patch')
                @endif
                <div class="col-xl-12">
                    <!-- HTML5 Inputs -->
                    <div class="card mb-4">
                        <h5 class="card-header text-capitalize">{{ isset($data) ? 'Edit' : 'Tambah' }} Tahun Ajaran</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                    value="{{ isset($data) ? $data->nama : old('nama') }}" id="nama"
                                    placeholder="contoh: Tahun Ajaran 2020" name="nama" />
                                @error('nama')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection