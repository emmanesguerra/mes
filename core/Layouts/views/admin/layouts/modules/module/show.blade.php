@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Displaying details of {{ $module->module_name }}
                @can('modules-list')
                <a href="{{ route('admin.modules.index') }}" class="float-right">Back</a>
                @endcan
            </div> 
        
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <dl class="row">
                            <dt class="col-sm-2">Module name:</dt>
                            <dd class="col-sm-9">{{ $module->module_name }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Description:</dt>
                            <dd class="col-sm-9">{{ $module->description }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Route Index Name:</dt>
                            <dd class="col-sm-9">{{ $module->route_root_name }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Icon:</dt>
                            <dd class="col-sm-9"><i class="{{ $module->icon }}"></i> {{ $module->icon }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $module->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $module->updated_at }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection