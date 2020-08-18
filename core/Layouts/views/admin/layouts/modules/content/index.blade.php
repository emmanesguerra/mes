@extends('admin.app')


@section('module-content')

<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Content Management
            </div>
            
            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="contentslists" class="datatable table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Displayed at pages</th>
                            <th>Date Updated</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th></th>
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
        
        $('#contentslists').DataTable({
            "ajax": "{{ route('admin.contents.data') }}",
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {
                    render: function (data, type, full) {
                        return (full.type == 'P') ? 'Panel': 'Main';
                    }
                },
                {
                    bSearchable: false,
                    bSortable: false,
                    render: function (data, type, full) {
                        var page = '';
                        _.each(full.pages, function(data) {
                            page += (page == '') ? data.title: ', ' + data.title;
                        });
                        return page;
                    }
                },
                {
                    "data": "updated_at"},
                {
                    width: "13%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('contents-edit')
                            straction += "<a href='{{ route('admin.contents.index') }}/" + full.id + "/edit'>Edit</a> | ";
                        @endcan
                        @can('contents-list')
                            straction +=  "<a href='{{ route('admin.contents.index') }}/" + full.id + "'>View in Page</a>";
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection