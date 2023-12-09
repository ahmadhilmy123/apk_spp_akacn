@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card" style="min-height: 65vh;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-capitalize">Tahun Ajaran</h5>
                @can('add_tahun_ajaran')
                <a href="{{ route('tahun-ajaran.create') }}" class="btn btn-primary text-capitalize">Tambah Tahun Ajaran</a>
                @endcan
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            @can('edit_tahun_ajaran', 'delete_tahun_ajaran')
                            <th>Actions</th>
                            @endcan
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
            ajax: '{{ route("tahun-ajaran.data") }}',
            columns: [
                        { "data": "DT_RowIndex" },
                        { "data": "nama" },
                        @can('edit_tahun_ajaran', 'hapus_tahun_ajaran')
                            { "data": "options" }
                        @endcan
                    ],
            pageLength: 25,
            responsive: true,
        });
    });
</script>
@endpush