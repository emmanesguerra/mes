@extends('admin.app')


@section('module-content')

<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Page Management
                
                @can('offices-trash')
                <a href="{{ route('admin.pages.trashed') }}" class="float-right"> Check Trashed Records</a>
                @endcan
                @can('pages-create')
                <a href="{{ route('admin.pages.create') }}" class="float-right mr-3"> Create New Page</a>
                @endcan
            </div>
            
            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="pageslists" class="datatable table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Url</th>
                            <th width="30%">Description</th>
                            <th>Template</th>
                            <th width="10%" class="text-nowrap">Date Updated</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Url</th>
                            <th width="30%">Description</th>
                            <th>Template</th>
                            <th width="10%" class="text-nowrap">Date Updated</th>
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
        var pagedtable = $('#pageslists').DataTable({
            "ajax": {
                "url": "{{ route('admin.pages.data') }}",
                "data": {
                    isTrashed: false
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "url"},
                {"data": "description"},
                {"data": "template"},
                {"data": "updated_at"},
                {
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('pages-edit')
                            straction += "<a href='{{ route('admin.pages.index') }}/" + full.id + "/edit'>Edit</a> | ";
                        @endcan
                        @can('pages-list')
                            straction +=  "<a href='{{ route('admin.pages.index') }}/" + full.id + "'>View Details</a> | ";
                        @endcan
                        @can('pages-delete')
                            straction += '<a href="#" onclick="showdeletemodal(' + full.id + ',\'' + full.title + '\', \'{{ route("admin.pages.index") }}\/' + full.id + '\')" class="text-danger">Delete</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection