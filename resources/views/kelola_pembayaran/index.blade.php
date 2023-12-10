@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-capitalize">Pembayaran</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
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
        $('.table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route("kelola.pembayaran.data") }}',
            columns: [
                        { "data": "DT_RowIndex" },
                        { "data": "nis" },
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
    });
</script>
@endpush
