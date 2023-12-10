@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <form
                action="{{ isset($data) ? route('users.update', ['role' => request('role'), 'id' => $data->id]) : route('users.store', ['role' => request('role')]) }}"
                method="POST">
                @csrf
                @if (isset($data))
                @method('patch')
                @endif
                <div class="col-xl-12">
                    <!-- HTML5 Inputs -->
                    <div class="card mb-4">
                        <h5 class="card-header text-capitalize">{{ isset($data) ? 'Edit' : 'Tambah' }} {{
                            request('role') }}</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    value="{{ isset($data) ? $data->name : old('name') }}" id="name"
                                    placeholder="Name User" name="name" />
                                @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ (request('role') ==
                                    'petugas' ? 'NIP' : 'NIS') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="text"
                                    value="{{ isset($data) ? $data->email : old('email') }}" id="email"
                                    placeholder="{{ (request('role') == 'petugas' ? 'NIP' : 'NIS') }}" name="email" />
                                @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if (!isset($data))
                            <div class="mb-3">
                                <label for="email" class="form-label">Password</label>
                                <input class="form-control" type="text" value="000000" name="number" disabled />
                            </div>
                            @endif
                            @if (request('role') == 'mahasiswa')
                            <div class="mb-3">
                                <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                                <select class="form-select @error('tahun_ajaran_id') is-invalid @enderror"
                                    name="tahun_ajaran_id">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($tahun_ajarans as $tahun_ajaran)
                                    <option value="{{ $tahun_ajaran->id }}">{{ $tahun_ajaran->nama }}</option>
                                    @endforeach
                                </select>
                                @error('tahun_ajaran_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="prodi_id" class="form-label">Prodi</label>
                                <select class="form-select @error('prodi_id') is-invalid @enderror"
                                    name="prodi_id">
                                    <option value="">Pilih Prodi</option>
                                    @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                                    @endforeach
                                </select>
                                @error('prodi_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @endif
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