@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-capitalize">Pembayaran</h5>
                <div class="d-flex" style="gap: 1rem;">
                    <select class="form-select" id="filter-status" style="width: 20rem;">
                        <option value="pengajuan" selected>pengajuan</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <select class="form-select" id="filter-prodi" style="width: 20rem;">
                        <option value="" selected>Pilih Prodi</option>
                        @foreach ($prodis as $prodi)
                        <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                        @endforeach
                    </select>
                    <select class="form-select" id="filter-tahun-ajaran" style="width: 20rem;">
                        <option value="" selected>Pilih Tahun Ajaran</option>
                        @foreach ($tahun_ajarans as $tahun_ajaran)
                        <option value="{{ $tahun_ajaran->id }}">{{ $tahun_ajaran->nama }}</option>
                        @endforeach
                    </select>
                    <form action="{{ route('kelola.pembayaran.export') }}" method="get" class="form-export">
                        <input type="hidden" name="status">
                        <input type="hidden" name="prodi">
                        <input type="hidden" name="tahun_ajaran">
                        <button type="button" class="btn btn-primary">Export</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Status</th>
                            <th>DIverifikasi</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function(){
        let table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ route("kelola.pembayaran.data") }}',
                data: function (p) {
                    p.status = $('#filter-status').val();
                    p.prodi = $('#filter-prodi').val();
                    p.tahun_ajaran = $('#filter-tahun-ajaran').val();
                }
            },
            columns: [
                        { "data": "DT_RowIndex" },
                        { "data": "nim" },
                        { "data": "nama_mhs" },
                        { "data": "prodi" },
                        { "data": "status" },
                        { "data": "verify_id" },
                        @can('edit_users', 'hapus_users')
                            { "data": "options" }
                        @endcan
                    ],
            pageLength: 25,
            responsive: true,
        });

        $('#filter-status, #filter-prodi, #filter-tahun-ajaran').on('change', function(){
            table.ajax.reload();
        });

        $('.form-export button').on('click', function(){
            $('.form-export input[name="status"]').val($('#filter-status').val());
            $('.form-export input[name="prodi"]').val($('#filter-prodi').val());
            $('.form-export input[name="tahun-ajaran"]').val($('#filter-tahun_ajaran').val());
            $('.form-export').submit();
        })
    });
</script>
@endpush