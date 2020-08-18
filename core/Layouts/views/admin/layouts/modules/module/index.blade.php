@extends('admin.app')


@section('module-content')

<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Module Management
                @can('modules-create')
                <a href="{{ route('admin.modules.create') }}" class="float-right"> Create New Module</a>
                @endcan
            </div>
            
            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="moduleslists" class="datatable table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th >ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Index Url</th>
                            <th>Date Updated</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th >ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Index Url</th>
                            <th>Date Updated</th>
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
        $('#moduleslists').DataTable({
            "ajax": "{{ route('admin.modules.data') }}",
            "columns": [
                {"data": "id"},
                {"data": "module_name"},
                { width: "20%","data": "description"},
                {"data": "route_root_name"},
                {"data": "updated_at"},
                {
                    width: "13%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('modules-edit')
                            straction += "<a href='{{ route('admin.modules.index') }}/" + full.id + "/edit'>Edit</a> | ";
                        @endcan
                        @can('modules-list')
                            straction +=  "<a href='{{ route('admin.modules.index') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection