@extends('admin.app')


@section('right-panel')
<section class="right-panel">
    
    @can('downloadables-list')
    <div class="card mb-3">
        <div class="card-header">Directory Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('downloadables-create')
                <li><a href="{{ route('admin.downloadables.create') }}"><span class='raq'>&raquo;</span><span>Create Directory</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
    @endcan
</section>
@endsection

@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Downloadables Management
            </div>
            
            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="downloadableslists" class="datatable table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th >ID</th>
                            <th >Directory</th>
                            <th class="text-nowrap">Date Updated</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th >ID</th>
                            <th>Directory</th>
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
        $('#downloadableslists').DataTable({
            "ajax": {
                "url": "{{ route('admin.downloadables.data') }}",
                "data": {
                    isTrashed: false
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "directory"},
                {"data": "updated_at"},
                {
                    width: "20%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('downloadables-edit')
                            straction += "<a href='{{ route('admin.downloadables.index') }}/" + full.id + "/edit'>Upload Files</a>";
                        @endcan
                        @can('downloadables-list')
                            straction +=  " | <a href='{{ route('admin.downloadables.index') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('downloadables-delete')
                            straction += ' | <a href="#" onclick="showdeletemodal(' + full.id + ',\''+full.title+'\', \'{{ route("admin.downloadables.index") }}\/' + full.id + '\')" class="text-danger">Delete</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection