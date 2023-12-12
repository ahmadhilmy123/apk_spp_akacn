@extends('mylayouts.main')

@section('container')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-capitalize">{{ request('role') }}</h5>
                @can('add_users')
                <a href="{{ route('users.create', request('role')) }}" class="btn btn-primary text-capitalize">Tambah {{ request('role') }}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name User</th>
                                @if (request('role') == 'petugas')
                                <th>NIP</th>
                                @else
                                <th>NIM</th>
                                @endif
                                @can('edit_users', 'delete_users')
                                <th>Actions</th>
                                @endcan
                            </tr>
                        </thead>
                    </table>
                </div>
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
            ajax: '{{ route("users.data", request('role')) }}',
            columns: [
                        { "data": "DT_RowIndex" },
                        { "data": "name" },
                        { "data": "email" },
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