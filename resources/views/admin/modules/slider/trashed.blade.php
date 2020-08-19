@extends('admin.app')


@section('right-panel')
<section class="right-panel">
    <div class="card mb-3">
        <div class="card-header">Slider Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('slider-list')
                <li><a href="{{ route('admin.sliders.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @endcan
                @can('slider-create')
                <li><a href="{{ route('admin.sliders.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
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
                Trashed Sliders
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
                            <th>Image</th>
                            <th>Link</th>
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
                            <th></th>
                            <th>Link</th>
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
                "url": "{{ route('admin.sliders.data') }}",
                "data": {
                    isTrashed: true
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "title"},
                {
                    bSearchable: false,
                    bSortable: false,
                    render: function (data, type, full) {
                        return '<img src="/storage/sliders/icon/'+full.image+'" alt="'+full.image+'"  title="'+full.image+'"/>'
                    }
                },
                {"data": "link"},
                {"data": "updated_at"},
                {
                    width: "20%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('slider-restore')
                            straction +=  "<a href='{{ route('admin.sliders.restore') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('slider-fdelete')
                            straction += ' | <br /> <a href="#" onclick="showdeletemodal(' + full.id + ',\'\', \'{{ route("admin.sliders.forcedelete") }}\/' + full.id + '\')" class="text-danger">Delete Permanently</a>';
                        @endcan
                        return straction;
                    }
                }
            ]
        });
    });
</script>
@endsection