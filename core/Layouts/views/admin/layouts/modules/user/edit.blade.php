@extends('admin.app')

@section('module-content')
<!-- Main content -->
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit User: {{ $user->firstname }} {{ $user->lastname }}
                @can('users-list')
                <a href="{{ route('admin.users.index') }}" class="float-right">Back</a>
                @endcan
            </div> 

            <div class="card-body">
            
                @if (session('status-failed'))
                <div class="alert alert-danger text-left">
                    {{ session('status-failed') }}
                </div>
                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger text-left">
                    <strong>Whoops!</strong> There were problems with the input: <br />
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', $user->id]]) !!}
                {!! Form::hidden('id') !!}
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <div class="col-sm-12">
                                <div class="form-row">
                                    <div  class="form-group  col-sm-4">
                                        <label class="@error('firstname') text-danger @enderror" for="firstname">First name *</label>
                                        <input maxlength="50" type="text" class="form-control ae-input-field @error('firstname') is-invalid @enderror " name="firstname" value="{{ old('firstname', $user->firstname) }}" id="firstname" placeholder="First name" required />
                                        @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                    <div  class="form-group  col-sm-4">
                                        <label class="@error('middlename') text-danger @enderror" for="middlename">Middle name</label>
                                        <input maxlength="50" type="text" class="form-control ae-input-field @error('middlename') is-invalid @enderror " name="middlename" value="{{ old('middlename', $user->middlename) }}" id="middlename" placeholder="Middle name" />
                                        @error('middlename') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                    <div  class="form-group  col-sm-4">
                                        <label class="@error('lastname') text-danger @enderror" for="lastname">Last name</label>
                                        <input maxlength="50" type="text" class="form-control ae-input-field @error('lastname') is-invalid @enderror " name="lastname" value="{{ old('lastname', $user->lastname) }}" id="lastname" placeholder="Last name" />
                                        @error('lastname') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-6">
                                        <label class="@error('email') text-danger @enderror" for="email">Email *</label>
                                        <input maxlength="191" type="text" class="form-control ae-input-field @error('email') is-invalid @enderror " name="email" value="{{ old('email', $user->email) }}" id="email" placeholder="Email" required />
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-6">
                                        <label class="@error('roles') text-danger @enderror" for="roles">Role *</label>
                                        <treeselect-form-multi
                                            @if(!empty($role))
                                            v-bind:value="{{ (Session::getOldInput('roles')) ? json_encode(Session::getOldInput('roles')): json_encode($role->id) }}"
                                            @else
                                            v-bind:value="{{ (Session::getOldInput('roles')) ? json_encode(Session::getOldInput('roles')): json_encode(null) }}"
                                            @endif
                                            v-bind:selectoptions="{{ json_encode($data['roles']) }}"
                                            v-bind:haserror="{{ $errors->has('roles') ? "true": "false" }}"
                                            v-bind:fieldname="{{ json_encode('roles') }}">
                                        </treeselect-form-multi>
                                        @error('roles') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            @can('users-edit')
                            <input  type="submit" class="btn btn-primary" value="Submit" />
                            @endcan
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection