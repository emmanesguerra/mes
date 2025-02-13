@extends('admin.app')

@section('right-panel')
<section class="right-panel">
    
    @can('news-list')
    <div class="card mb-3">
        <div class="card-header">News Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                <li><a href="{{ route('admin.news.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @can('news-create')
                <li><a href="{{ route('admin.news.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
    @endcan
    
    @can('newscategory-list')
    <div class="card mb-3">
        <div class="card-header">Category Menu</div>
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
                Trashed News
                @can('news-list')
                <a href="{{ route('admin.news.index') }}" class="float-right">Back</a>
                @endcan
            </div>
            
            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="sliderlists" class="datatable table table-striped table-bordered small">
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
        
        $('#sliderlists').DataTable({
            responsive: true,
            processing: true,
            "ajax": {
                "url": "{{ route('admin.news.data') }}",
                "data": {
                    isTrashed: true
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
                        @can('news-restore')
                            straction +=  "<a href='{{ route('admin.news.restore') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('news-fdelete')
                            straction += ' | <br /> <a href="#" onclick="showdeletemodal(' + full.id + ',\''+full.title+'\', \'{{ route("admin.news.forcedelete") }}\/' + full.id + '\')" class="text-danger">Delete Permanently</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection