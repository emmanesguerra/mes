@extends('admin.app')


@section('module-content')

<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Trashed Pages
                
                @can('pages-list')
                <a href="{{ route('admin.pages.index') }}" class="float-right">Back</a>
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
                            <th>Description</th>
                            <th>Template</th>
                            <th class="text-nowrap">Date Updated</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Url</th>
                            <th>Description</th>
                            <th>Template</th>
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
<link href="{{ asset('plugins/plugins/DataTables-Bootstrap/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
<script src="{{ asset('plugins/plugins/DataTables-Bootstrap/datatables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        var pagedtable = $('#pageslists').DataTable({
            "ajax": {
                "url": "{{ route('admin.pages.data') }}",
                "data": {
                    isTrashed: true
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
                    width: "15%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('pages-restore')
                            straction +=  "<a href='{{ route('admin.pages.restore') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('pages-fdelete')
                            straction += '<br /><a href="#" onclick="showdeletemodal(' + full.id + ',\'' + full.title + '\', \'{{ route("admin.pages.forcedelete") }}\/' + full.id + '\')" class="text-danger">Delete Permanently</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection