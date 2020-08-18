@extends('admin.app')

@section('module-content')
<!-- Main content -->
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Create New User
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
                
                {!! Form::open(array('route' => 'admin.users.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <div class="col-sm-12">
                                <div class="form-row">
                                    <div  class="form-group  col-sm-4">
                                        <label class="@error('firstname') text-danger @enderror" for="firstname">First name *</label>
                                        <input maxlength="50" type="text" class="form-control ae-input-field @error('firstname') is-invalid @enderror " name="firstname" value="{{ old('firstname') }}" id="firstname" placeholder="First name" required />
                                        @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                    <div  class="form-group  col-sm-4">
                                        <label class="@error('middlename') text-danger @enderror" for="middlename">Middle name</label>
                                        <input maxlength="50" type="text" class="form-control ae-input-field @error('middlename') is-invalid @enderror " name="middlename" value="{{ old('middlename') }}" id="middlename" placeholder="Middle name" />
                                        @error('middlename') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                    <div  class="form-group  col-sm-4">
                                        <label class="@error('lastname') text-danger @enderror" for="lastname">Last name</label>
                                        <input maxlength="50" type="text" class="form-control ae-input-field @error('lastname') is-invalid @enderror " name="lastname" value="{{ old('lastname') }}" id="lastname" placeholder="Last name" />
                                        @error('lastname') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-6">
                                        <label class="@error('email') text-danger @enderror" for="email">Email *</label>
                                        <input maxlength="191" type="text" class="form-control ae-input-field @error('email') is-invalid @enderror " name="email" value="{{ old('email') }}" id="email" placeholder="Email" required />
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                    <div  class="form-group  col-sm-6">
                                        <label class="@error('roles') text-danger @enderror" for="roles">Role *</label>
                                        <treeselect-form-multi
                                            v-bind:value="{{ (Session::getOldInput('roles')) ? json_encode(Session::getOldInput('roles')): json_encode(null) }}"
                                            v-bind:selectoptions="{{ json_encode($data['roles']) }}"
                                            v-bind:haserror="{{ $errors->has('roles') ? "true": "false" }}"
                                            v-bind:fieldname="{{ json_encode('roles') }}">
                                        </treeselect-form-multi>
                                        @error('roles') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-6">
                                        <label class="@error('password') text-danger @enderror" for="password">Password *</label>
                                        <input type="text" class="form-control ae-input-field @error('password') is-invalid @enderror " name="password" value="{{ old('password') }}" id="password" placeholder="Password" required />
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                    <div  class="form-group  col-sm-6">
                                        <label class="@error('password_confirmation') text-danger @enderror" for="password_confirmation">Re Password *</label>
                                        <input type="text" class="form-control ae-input-field @error('password_confirmation') is-invalid @enderror " name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirmation" placeholder="Re-type Password" required />
                                        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                    
                                    <div  class="form-group  col-sm-12">
                                        <p class="form-text text-info small">
                                            Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            @can('users-create')
                            <button data-toggle="modal" data-target="#usersModal" type="button" class="btn btn-primary">Proceed</button>
                            @endcan
                        </div>
                        <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="settingsModalLabel">Continue Posting</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Continue saving records? Make sure to remember your email and password, it will be use to log in the system.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input  type="submit" class="btn btn-primary" value="Submit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection