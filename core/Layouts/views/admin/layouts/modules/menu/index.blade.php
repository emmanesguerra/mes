@extends('admin.app')


@section('module-content')

<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Menus Management
                @can('menus-create')
                <span id="addnew" class="float-right text-primary" style="cursor: pointer"> Create Menu</span>
                @endcan
            </div>
            
            <div class="card-body">
                @if (session('status-success'))
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
                @endif
            
                <table id="menulists" class="table table-striped table-bordered small">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Title</th>
                            <th width="30%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
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
        
    var counter = 1;
    var iscreating = false;
    function createNewRow(parentid, lvl, isNew, element) {
        if(!iscreating) {
            var currentPage = menudtable.page();
                        
            var strtitle = "";
            for (var i=0;i<lvl;i++) {
                strtitle += "<i class='fas fa-long-arrow-alt-right'> </i> &nbsp;&nbsp;&nbsp;&nbsp;";
            }
            
            var strinput = '<input maxlength="46" id="ntitle-'+counter+'" type="text" class="form-control form-control-sm" placeholder="Menu Title"/>';
            if(!isNew) {
                var options = "<option value='0'>Select a page</option>";
                @foreach ($pages as $page)
                    options += "<option value='{{$page->id}}'>{{$page->name}}</option>";
                @endforeach
                strinput = '<select id="pageid-'+counter+'" class="form-control form-control-sm">'+options+'</select>';
            }
            
                        
            menudtable.row.add({
                'id': "",
                'title': '<div class="form-inline">\n\
                        '+strtitle + strinput +'\n\
                        <div id="error-'+counter+'" class="col-sm-12 text-danger my-1"></div>\n\
                    </div>',
                'button': '<button onclick="saveRow('+counter+', '+parentid+')" type="button" class="btn btn-sm btn-primary">Save</button>\n\
                 <button onclick="removeRow(this)" type="button" data-role="help" class="btn btn-sm btn-default">Cancel</button>'}).draw();

            counter++;
            iscreating = true;
            

            //move added row to desired index (here the row we clicked on)
            var index = menudtable.row( $(element).closest('tr') ).index()+1,
                rowCount = menudtable.data().length-1,
                insertedRow = menudtable.row(rowCount).data(),
                tempRow;

            for (var i=rowCount;i>index;i--) {
                tempRow = menudtable.row(i-1).data();
                menudtable.row(i).data(tempRow);
                menudtable.row(i-1).data(insertedRow);
            }     
            //refresh the current page
            menudtable.page(currentPage).draw(true);
        }
    }
    
    function deleteRow(id) {
        axios.delete("{{ route('admin.menus.index') }}" + '/' + id)
        .then(function (response) {
            window.location = "{{ route('admin.menus.index') }}";
        }).catch(function (error) {
            window.location = "{{ route('admin.menus.index') }}";
        });
    }
    
    $(document).ready(function () {
        
        menudtable = $('#menulists').DataTable({
            serverSide: false,
            processing: true,
            ordering: false,
            paging: false,
            bInfo : false,
            "ajax": "{{ route('admin.menus.data') }}",
            "columns": [
                {"data": "id"},
                {
                    bSortable: false,
                    mRender: function (data, type, full) { 
                        var strtitle = "";
                        for (var i=1;i<full.lvl;i++) {
                            strtitle += "<i class='fas fa-long-arrow-alt-right'></i>&nbsp;&nbsp;&nbsp;&nbsp;";
                        }
                        return strtitle + full.title;
                    }
                },
                {
                    width: "30%",
                    bSearchable: false,
                    bSortable: false,
                    mRender: function (data, type, full) {
                        if(full.button) {
                            return full.button;
                        } else {
                            var str = "";
                            @can('menus-create')
                            str += "<span onclick='createNewRow("+full.id+","+full.lvl +" , false, this)' class='text-primary' style='cursor:pointer'>Add Sub Menu</span>";
                            @endcan
                            @can('menus-delete')
                            if((full.lft + 1) == full.rgt) {
                                str += ' | <span onclick="showdeletemodal(' + full.id + ',\'' + full.title + '\', \'{{ route("admin.menus.index") }}\/' + full.id + '\')" class="text-danger"  style="cursor:pointer">Remove Menu</span>'
                            }
                            @endcan
                            @can('menus-edit')
                            if(!full.page_id)
                            {
                                str += " | <a href='{{ route('admin.menus.settings') }}/" + full.id + "'>Manage Settings</a> ";
                            }
                            @endcan
                            return str;
                        }
                    }
                }
            ]
        });
        
        $('#addnew').on( 'click', function () {
            createNewRow(0, 0, true);
        });
    
        removeRow = function (element) {
            menudtable.row($(element).closest('tr')).remove().draw(false);
            iscreating = false;
        }
    
        saveRow = function (counterid, parentid) {
            axios.post("{{ route('admin.menus.store') }}", {
                nTitle: $('#ntitle-'+counterid).val(),
                pageId: $('#pageid-'+counterid).val(),
                parentId: parentid
            }).then(function (response) {
                window.location = "{{ route('admin.menus.index') }}";
            }).catch(function (error) {
                var strerror = "";
                $.each(error.response.data.errors, function(index, err) {
                    $.each(err, function(i, strerr) {
                        strerror += strerr + "<br />";
                    });
                });
                if(error.response.data.message) {
                    strerror += error.response.data.message ;
                }
                $('#error-'+counterid).html(strerror);
            });
        }
    });
</script>
@endsection