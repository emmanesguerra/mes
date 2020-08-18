@extends('admin.app')

@section('module-content')
<!-- Main content -->
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Users Management
                
                @can('users-trash')
                <a href="{{ route('admin.users.trashed') }}" class="float-right"> Check Trashed Records</a>
                @endcan
                @can('users-create')
                <a href="{{ route('admin.users.create') }}" class="float-right mr-3">Create New User</a>
                @endcan
            </div> 

            <div class="card-body">
            
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
                
                <table id="datatablelist" class="datatable table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th class="text-nowrap">First Name</th>
                            <th class="text-nowrap">Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-nowrap">Date Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th class="text-nowrap">First Name</th>
                            <th class="text-nowrap">Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-nowrap">Date Updated</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@section('styles')
<link href="{{ asset('plugins/DataTables-Bootstrap/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
<script src="{{ asset('plugins/DataTables-Bootstrap/datatables.min.js') }}"></script>
<script>
    $(document).ready(function () {        
        $('#datatablelist').DataTable({
            "ajax": {
                "url": "{{ route('admin.users.data') }}",
                "data": {
                    isTrashed: false
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "firstname"},
                {"data": "lastname"},
                {"data": "email"},
                {"data": "name"},
                {"data": "updated_at"},
                {
                    width: "18%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('users-edit')
                            straction += "<a href='{{ route('admin.users.index') }}/" + full.id + "/edit'>Edit</a> | ";
                        @endcan
                        @can('users-list')
                            straction +=  "<a href='{{ route('admin.users.index') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('users-delete')
                            straction += ' | <a href="#" onclick="showdeletemodal(' + full.id + ',\'' + full.email + '\', \'{{ route("admin.users.index") }}\/' + full.id + '\')" class="text-danger">Delete</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection