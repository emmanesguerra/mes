@extends('admin.app')


@section('right-panel')
<section class="right-panel">
    <div class="card mb-3">
        <div class="card-header">Quotation Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('quotation-create')
                <li><a href="{{ route('admin.quotes.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('quotation-trash')
                <li><a href="{{ route('admin.quotes.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted lists</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
</section>
@endsection


@section('module-content')

<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Quotation Management
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
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date Updated</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th >ID</th>
                            <th>Title</th>
                            <th>Description</th>
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
            "ajax": {
                "url": "{{ route('admin.quotes.data') }}",
                "data": {
                    isTrashed: false
                }
            },
            "columns": [
                {
                    width: "5%","data": "id"},
                {
                    width: "20%","data": "title"},
                {
                    width: "30%","data": "description"},
                {
                    width: "5%","data": "updated_at"},
                {
                    width: "20%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('quotation-edit')
                            straction += "<a href='{{ route('admin.quotes.index') }}/" + full.id + "/edit'>Edit</a>";
                        @endcan
                        @can('quotation-list')
                            straction +=  " | <a href='{{ route('admin.quotes.index') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('quotation-delete')
                            straction += ' | <a href="#" onclick="showdeletemodal(' + full.id + ',\''+full.title+'\', \'{{ route("admin.quotes.index") }}\/' + full.id + '\')" class="text-danger">Delete</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection