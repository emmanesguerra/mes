@extends('admin.app')

@section('right-panel')
<section class="right-panel">
    <div class="card mb-3">
        <div class="card-header">Office Location Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('offices-create')
                <li><a href="{{ route('admin.offices.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
    @can('offices-trash')
    <div class="card mb-3">
        <div class="card-header">Deleted Records</div>
        <div class="card-body">
            <ul class="admin-menu">
                <li><a href="{{ route('admin.offices.trashed') }}"><span class='raq'>&raquo;</span><span>View Lists</span></a></li>
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
                Office Location Management
            </div>
            
            <div class="card-body">
                
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="officelists" class="datatable table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Telephone</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Date Updated</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Telephone</th>
                            <th>Mobile</th>
                            <th>Email</th>
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
    
    
    function striptags (str) {
        if ((str===null) || (str==='') || typeof(str) === 'undefined')
            return '';
        else
        str = str.toString();

        return str.replace(/<[^>]*>/g, '');
    }
            
    $(document).ready(function () {
        
        $('#officelists').DataTable({
            "ajax": {
                "url": "{{ route('admin.offices.data') }}",
                "data": {
                    isTrashed: false
                }
            },
            "columns": [
                {"data": "id"},
                {
                    render: function (data, type, full) { 
                        return striptags(full.address)
                    }
                },
                {"data": "telephone"},
                {"data": "mobile"},
                {"data": "email"},
                {"data": "updated_at"},
                {
                    width: "13%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        var straction = "";
                        @can('offices-edit')
                            straction += "<a href='{{ route('admin.offices.index') }}/" + full.id + "/edit'>Edit</a> | ";
                        @endcan
                        @can('offices-list')
                            straction +=  "<a href='{{ route('admin.offices.index') }}/" + full.id + "'>View Details</a>";
                        @endcan
                        @can('offices-delete')
                            straction += ' | <a href="#" onclick="showdeletemodal(' + full.id + ',\'\', \'{{ route("admin.offices.index") }}\/' + full.id + '\')" class="text-danger">Delete</a>';
                        @endcan
                        return straction;
                    }
                }
            ],
            // to fix error in responsive: true option
            "columnDefs": [{
                "defaultContent": "-",
                "targets": "_all"
            }]
        });
    });
</script>
@endsection