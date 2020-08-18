@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Displaying details of {{ $user->firstname }} {{ $user->lastname }}
                @can('users-list')
                <a href="{{ url()->previous() }}" class="float-right">Back</a>
                @endcan
            </div> 
        
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <dl class="row">
                            <dt class="col-sm-2">First name:</dt>
                            <dd class="col-sm-9">{{ $user->firstname }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Middle name:</dt>
                            <dd class="col-sm-9">{{ $user->middlename }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Last name:</dt>
                            <dd class="col-sm-9">{{ $user->lastname }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Email:</dt>
                            <dd class="col-sm-9">{{ $user->email }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Role:</dt>
                            @if(!empty($role))
                            <dd class="col-sm-9">{{ $role->name }}</dd>
                            @endif
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Permissions:</dt>
                            <dd class="col-sm-9">
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    {{ $v->name }},
                                @endforeach
                            @endif
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $user->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $user->updated_at }}</dd>
                        </dl>
                        @if($user->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $user->deleted_at }}</dd>                            
                        </dl>
                        
                        {!! Form::model($user, ['method' => 'POST','route' => ['admin.users.processrestore', $user->id]]) !!}
                        <button type="submit" class="btn btn-primary">Restore Record</button>
                        {!! Form::close() !!}
                        
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection