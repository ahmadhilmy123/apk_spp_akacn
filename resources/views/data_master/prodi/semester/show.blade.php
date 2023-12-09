@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-capitalize">Biaya {{ $prodi->nama }} | {{ $data->nama }}</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('data-master.prodi.semester.biaya.create', ['prodi_id' => $prodi->id, 'semester_id' => $data->id]) }}" class="btn btn-primary mb-3">Tambah</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun Ajaran</th>
                            <th>Nominal</th>
                            <th>Publish</th>
                            @can('edit_biaya', 'delete_biaya')
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
            ajax: '{{ route("data-master.prodi.semester.biaya.data", ['prodi_id' => request('prodi_id'), 'semester_id' => request('semester_id')]) }}',
            columns: [
                        { "data": "DT_RowIndex" },
                        { "data": "tahun_ajaran" },
                        { "data": "nominal" },
                        { "data": "publish" },
                        @can('edit_biaya', 'hapus_biaya')
                            { "data": "options" }
                        @endcan
                    ],
            pageLength: 25,
            responsive: true,
        });
    });
</script>
@endpush