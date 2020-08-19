@extends('admin.app')


@section('right-panel')
<section class="right-panel">
    
    @can('news-list')
    <div class="card mb-3">
        <div class="card-header">News Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('news-create')
                <li><a href="{{ route('admin.news.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('news-trash')
                <li><a href="{{ route('admin.news.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted list</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
    @endcan
    
    @can('newscategory-list')
    <div class="card mb-3">
        <div class="card-header">News Category Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                <li><a href="{{ route('admin.newscategory.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @can('newscategory-create')
                <li><a href="{{ route('admin.newscategory.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('newscategory-trash')
                <li><a href="{{ route('admin.newscategory.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted list</span></a></li>
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
                News Management
            </div>
            
            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="newslists" class="datatable table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th >ID</th>
                            <th class="text-nowrap">Category Name</th>
                            <th>Title</th>
                            <th class="text-nowrap">Short Description</th>
                            <th>Image</th>
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
                            <th>Image</th>
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
        $('#newslists').DataTable({
            "ajax": {
                "url": "{{ route('admin.news.data') }}",
                "data": {
                    isTrashed: false
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "title"},
                {"data": "short_description"},
                {
                    bSearchable: false,
                    bSortable: false,
                    render: function (data, type, full) {
                        return '<img src="/storage/news/icon/'+full.image+'" alt="'+full.image_alt+'"  title="'+full.image_alt+'"/>'
                    }
                },
                {"data": "updated_at"},
                {
                    width: "20%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('news-edit')
                            straction += "<a href='{{ route('admin.news.index') }}/" + full.id + "/edit'>Edit</a>";
                        @endcan
                        @can('news-list')
                            straction +=  " | <a href='{{ route('admin.news.index') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('news-delete')
                            straction += ' | <a href="#" onclick="showdeletemodal(' + full.id + ',\''+full.title+'\', \'{{ route("admin.news.index") }}\/' + full.id + '\')" class="text-danger">Delete</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection