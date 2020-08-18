@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Module: {{ $module->module_name }}
                @can('modules-list')
                <a href="{{ route('admin.modules.index') }}" class="float-right">Back</a>
                @endcan
            </div> 
            
            <div class="card-body">
            
                @if (session('status-failed'))
                <div class="alert alert-danger text-left">
                    {{ session('status-failed') }}
                </div>
                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                
                {!! Form::model($module, ['method' => 'PATCH','route' => ['admin.modules.update', $module->id]]) !!}
                {!! Form::hidden('id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-5">
                                    <label>Module name</label>
                                    <span type="text" class="form-control ae-input-field text-secondary" >{{ $module->module_name }}</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-10">
                                    <label class="@error('description') text-danger @enderror" for="description">Description</label>
                                    <input type="text" class="form-control ae-input-field @error('description') is-invalid @enderror " name="description" value="{{ old('description', $module->description) }}" id="description" placeholder="Description" />
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <label>Route Name (index)</label>
                                    <span type="text" class="form-control ae-input-field text-secondary">{{ $module->route_root_name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('modules-edit')
                        <button type="submit" class="btn btn-primary">Submit</button>
                        @endcan
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection