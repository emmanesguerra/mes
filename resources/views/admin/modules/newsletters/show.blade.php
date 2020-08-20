@extends('admin.app')

@section('right-panel')
<section class="right-panel">
    
    @can('newsletters-list')
    <div class="card mb-3">
        <div class="card-header">Newsletters Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                <li><a href="{{ route('admin.newsletters.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @can('newsletters-create')
                <li><a href="{{ route('admin.newsletters.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('newsletters-trash')
                <li><a href="{{ route('admin.newsletters.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted list</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
    @endcan
    
    @can('subscribers-list')
    <div class="card mb-3">
        <div class="card-header">Subscriber Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('subscribers-list')
                <li><a href="{{ route('admin.newsletterssubs.index') }}"><span class='raq'>&raquo;</span><span>View list</span></a></li>
                @endcan
                @can('subscribers-create')
                <li><a href="{{ route('admin.newsletterssubs.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
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
                Newsletters ID # {{ $newsletters->id }}
                @can('newsletters-list')
                <a href="{{ url()->previous() }}" class="float-right">Back</a>
                @endcan
            </div> 
        
            <div class="card-body">
            
                @if (session('status-failed'))
                <div class="alert alert-danger text-left">
                    {{ session('status-failed') }}
                </div>
                @endif
                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <dl class="row">
                            <dt class="col-sm-2">Title:</dt>
                            <dd class="col-sm-9">{!! $newsletters->title !!}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Content:</dt>
                            <dd class="col-sm-9">{!! $newsletters->content !!}</dd>
                        </dl>
                        
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $newsletters->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $newsletters->updated_at }}</dd>
                        </dl>
                        @if($newsletters->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $newsletters->deleted_at }}</dd>                            
                        </dl>
                        
                        {!! Form::model($newsletters, ['method' => 'POST','route' => ['admin.newsletters.processrestore', $newsletters->id]]) !!}
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