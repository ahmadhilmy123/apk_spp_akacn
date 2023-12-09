@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-capitalize">Prodi {{ $prodi->nama }}</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Semester</h5>
                    <a href="{{ route('data-master.prodi.semester.create', $prodi->id) }}" class="btn btn-primary">Tambah Semester</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            @can('edit_semester', 'delete_semester')
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
            ajax: '{{ route("data-master.prodi.semester.data", request("prodi")) }}',
            columns: [
                        { "data": "DT_RowIndex" },
                        { "data": "nama" },
                        @can('edit_semester', 'hapus_semester')
                            { "data": "options" }
                        @endcan
                    ],
            pageLength: 25,
            responsive: true,
        });
    });
</script>
@endpush