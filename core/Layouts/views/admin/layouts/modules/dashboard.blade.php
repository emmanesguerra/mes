@extends('admin.app')

@section('module-content')
<section class="main-panel">
    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            @if (session('status-success'))
            <div class="alert alert-success" role="alert">
                {{ session('status-success') }}
            </div>
            @endif

            <div class="row">
                <div class="col-sm-7">
                    <h4>Change Logs</h4>
                    <table id="changelogs" class="datatable table table-striped table-bordered small">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Event</th>
                                <th>Module</th>
                                <th class="text-nowrap">Module #</th>
                                <th class="text-nowrap">Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Email</th>
                                <th>Event</th>
                                <th>Module</th>
                                <th class="text-nowrap">Module #</th>
                                <th class="text-nowrap">Date Created</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-sm-5">
                    <h4>User Logs</h4>
                    <table id="userlogs" class="datatable table table-striped table-bordered small">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th class="text-nowrap">Time In</th>
                                <th class="text-nowrap">Time Out</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Email</th>
                                <th class="text-nowrap">Time In</th>
                                <th class="text-nowrap">Time Out</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade in" id="audit-display-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Updates</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <audit-table :info="panels">
                </audit-table>    
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link href="{{ asset('plugins/DataTables-Bootstrap/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
<script src="{{ asset('plugins/DataTables-Bootstrap/datatables.min.js') }}"></script>
<script>
    
    var showAuditValues = function(id) {
        axios.get("{{ route('admin.users.changelog.value') }}/" + id)
        .then(function (response) {
            window.app.panels = response.data;
            $('#audit-display-modal').modal('show');
        }).catch(function (error) {
            alert(error.response.data.message);
        });
    }
    
    $(document).ready(function () {        
        $('#userlogs').DataTable({
            "ajax": "{{ route('admin.users.log.data') }}",
            "order": [[ 1, "desc" ]],
            "columns": [
                {"data": "email"},
                {"data": "log_in"},
                {"data": "log_out"}
            ],
        });
        
        $('#changelogs').DataTable({
            "ajax": "{{ route('admin.users.changelog.data') }}",
            "order": [[ 4, "desc" ]],
            "columns": [
                {"data": "email"},
                {
                    "render": function (data, type, full) {
                        return "<a href='#' onclick='showAuditValues("+full.id+")'> "+full.event+" </a>";
                    }
                },
                {
                    "render": function (data, type, full) {
                        var module = _.split(full.auditable_type, '\\');
                        return _.last(module);
                    }
                },
                {"data": "auditable_id"},
                {"data": "created_at"}
            ],
        });
    });
</script>
@endsection