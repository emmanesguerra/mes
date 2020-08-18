@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Permission: {{ $permission->name }}
                @can('permissions-list')
                <a href="{{ route('admin.roles.index') }}" class="float-right">Back</a>
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
                
                {!! Form::model($permission, ['method' => 'PATCH','route' => ['admin.permissions.update', $permission->id]]) !!}
                {!! Form::hidden('id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-7">
                                    <label class="@error('name') text-danger @enderror" for="name">Name *</label>
                                    <input type="text" class="form-control ae-input-field @error('name') is-invalid @enderror " name="name" value="{{ old('name', $permission->name) }}" id="module" placeholder="Name" required/>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-5">
                                    <label class="@error('module') text-danger @enderror" for="module">Module *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('module') is-invalid @enderror " name="module" value="{{ old('module', $permission->module) }}" id="module" placeholder="Module" required/>
                                    @error('module') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-5">
                                    <label class="@error('module') text-danger @enderror" for="module">Guard *</label>
                                    <treeselect-form 
                                        v-bind:value="{{ (Session::getOldInput('guard_name')) ? json_encode(Session::getOldInput('guard_name')): json_encode($permission->guard_name) }}"
                                        v-bind:selectoptions="{{ json_encode($guards) }}"
                                        v-bind:haserror="{{ $errors->has('guard_name') ? "true": "false" }}"
                                        v-bind:fieldname="{{ json_encode('guard_name') }}"
                                        v-bind:multiple="{{ json_encode(false) }}"
                                        v-bind:forpagetemplate="{{ json_encode(false) }}"
                                        v-bind:forpagetemplateurl="{{ json_encode(null) }}">
                                    </treeselect-form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('permissions-edit')
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