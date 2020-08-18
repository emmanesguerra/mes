@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Create New Module
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
                
                {!! Form::open(array('route' => 'admin.modules.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-5">
                                    <label class="@error('module_name') text-danger @enderror" for="module_name">Module name *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('module_name') is-invalid @enderror " name="module_name" value="{{ old('module_name') }}" id="module_name" placeholder="Module name" required/>
                                    @error('module_name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-10">
                                    <label class="@error('description') text-danger @enderror" for="description">Description</label>
                                    <input type="text" class="form-control ae-input-field @error('description') is-invalid @enderror " name="description" value="{{ old('description') }}" id="description" placeholder="Description" />
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('route_root_name') text-danger @enderror" for="route_root_name">Route Name (index) *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('route_root_name') is-invalid @enderror " name="route_root_name" value="{{ old('route_root_name') }}" id="route_root_name" placeholder="Route Name" required/>
                                    @error('route_root_name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-8">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="haspanel" > Check this to create a "Panel" for this module
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('modules-create')
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