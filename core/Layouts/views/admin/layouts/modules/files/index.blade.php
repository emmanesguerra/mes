@extends('admin.app')


@section('module-content')

<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                File Management
                @can('menus-create')
                <a href="{{ route('admin.files.create') }}" class="float-right"> Upload File(s)</a>
                @endcan
            </div>

            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif

                <table id="filelists" class="table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th width='10%'>Image/ Filename</th>
                            <th width='40%'>Use these texts for your contents</th>
                            <th width='10%'>Extension</th>
                            <th width='10%'>Size</th>
                            <th width='10%'>Action</th>
                        </tr>
                    </thead>
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
    $('#filelists').DataTable({
        initComplete : function () {
            return;
        },
        serverSide: false,
        "ajax": "{{ route('admin.files.data') }}",
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "columns": [
            {
                mRender: function (data, type, full) {
                    if (full.extension == 'jpg' || full.extension == 'png' || full.extension == 'gif') {
                        return '<img src="' + full.path + '" width="100" title="'+ full.basename +'"/>';
                    } else {
                        return '<i class="fa fa-file" style="font-size: 100px" title="'+ full.basename +'">';
                    }
                }
            },
            {"data": "text"},
            {"data": "extension"},
            {"data": "size"},
            {
                width: "5%",
                bSearchable: false,
                bSortable: false,
                mRender: function (data, type, full) {
                    return '<a href="#" onclick="showdeletemodal(' + 0 + ',\'' + full.basename + '\', \'{{ route("admin.files.index") }}\/' + full.basename + '\')" class="text-danger">Remove</a>'
                }
            }
        ]
    });
});
</script>
@endsection