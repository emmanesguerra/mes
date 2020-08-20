@extends('admin.app')


@section('right-panel')
<section class="right-panel">
    
    @can('newsletters-list')
    <div class="card mb-3">
        <div class="card-header">Newsletters Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('newsletters-create')
                <li><a href="{{ route('admin.newsletters.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('newsletters-trash')
                <li><a href="{{ route('admin.newsletters.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted list</span></a></li>
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
                Newsletters Management
            </div>
            
            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="newsletterslists" class="datatable table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th >ID</th>
                            <th class="text-nowrap">Category Name</th>
                            <th>Title</th>
                            <th class="text-nowrap">Short Description</th>
                            <th class="text-nowrap">Date Updated</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th >ID</th>
                            <th>Category Name</th>
                            <th>Title</th>
                            <th>Short Description</th>
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
        $('#newsletterslists').DataTable({
            "ajax": {
                "url": "{{ route('admin.newsletters.data') }}",
                "data": {
                    isTrashed: false
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "title"},
                {"data": "short_description"},
                {"data": "updated_at"},
                {
                    width: "20%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('newsletters-edit')
                            straction += "<a href='{{ route('admin.newsletters.index') }}/" + full.id + "/edit'>Edit</a>";
                        @endcan
                        @can('newsletters-list')
                            straction +=  " | <a href='{{ route('admin.newsletters.index') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('newsletters-delete')
                            straction += ' | <a href="#" onclick="showdeletemodal(' + full.id + ',\''+full.title+'\', \'{{ route("admin.newsletters.index") }}\/' + full.id + '\')" class="text-danger">Delete</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection