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
<link href="{{ asset('DataTables-Bootstrap/datatables.min.css') }}" rel="stylesheet">

<style>
    .right-panel {
        float: right;
        width: 220px;
        margin-left: 15px
    }

    .right-panel .card {
        border: 1px solid #665847;
        border-radius: 0
    }

    .right-panel .card .card-header {
        background-color: #665847;
        border-radius: 0;
        color: #fff;
        padding: .5rem 1.25rem
    }

    .right-panel .card .card-body {
        padding: 0
    }

    .right-panel .card .card-body .admin-menu {
        padding: 0;
        margin: 0
    }

    .right-panel .card .card-body .admin-menu li {
        display: block;
        margin: 0;
        padding: 0;
        border-bottom: 1px solid #665847
    }

    .right-panel .card .card-body .admin-menu li a {
        display: block;
        margin: .25rem 0;
        padding: 0 1.25rem;
        color: #000
    }

    .right-panel .card .card-body .admin-menu li a.active .raq,.right-panel .card .card-body .admin-menu li a:hover .raq {
        display: block
    }

    .right-panel .card .card-body .admin-menu li a .raq {
        float: left;
        display: none;
        font-size: 16px
    }

    .right-panel .card .card-body .admin-menu li:last-child {
        border-bottom: 0
    }
</style>
@endsection

@section('javascript')
<script src="{{ asset('DataTables-Bootstrap/datatables.min.js') }}"></script>
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