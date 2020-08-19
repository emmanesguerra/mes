@extends('admin.app')


@section('right-panel')
<section class="right-panel">
    <div class="card mb-3">
        <div class="card-header">Page Banner Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('pagebanner-list')
                <li><a href="{{ route('admin.pagebanner.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @endcan
                @can('pagebanner-create')
                <li><a href="{{ route('admin.pagebanner.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('pagebanner-trash')
                <li><a href="{{ route('admin.pagebanner.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted lists</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
</section>
@endsection


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Page Banner ID # {{ $pageBanner->id }}
                @can('pagebanner-list')
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
                        @if($pageBanner->title)
                        <dl class="row">
                            <dt class="col-sm-2">Title:</dt>
                            <dd class="col-sm-9">{!! $pageBanner->title !!}</dd>
                        </dl>
                        @endif
                        @if($pageBanner->description)
                        <dl class="row">
                            <dt class="col-sm-2">Description:</dt>
                            <dd class="col-sm-9">{{ $pageBanner->description }}</dd>
                        </dl>
                        @endif
                        <dl class="row">
                            <dt class="col-sm-2">Image:</dt>
                            <dd class="col-sm-9"><img src='{{ asset('storage/pagebanner/icon/' . $pageBanner->image) }}' alt="{{ $pageBanner->image_alt }}" title="{{ $pageBanner->image_alt }}" /></dd>
                        </dl>
                        
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $pageBanner->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $pageBanner->updated_at }}</dd>
                        </dl>
                        @if($pageBanner->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $pageBanner->deleted_at }}</dd>                            
                        </dl>
                        
                        {!! Form::model($pageBanner, ['method' => 'POST','route' => ['admin.pagebanner.processrestore', $pageBanner->page_id]]) !!}
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