@extends('admin.app')

@section('right-panel')
<section class="right-panel">
    
    @can('news-list')
    <div class="card mb-3">
        <div class="card-header">News Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                <li><a href="{{ route('admin.news.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @can('news-create')
                <li><a href="{{ route('admin.news.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('news-trash')
                <li><a href="{{ route('admin.news.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted list</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
    @endcan
    
    @can('newscategory-list')
    <div class="card mb-3">
        <div class="card-header">News Category Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                <li><a href="{{ route('admin.newscategory.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @can('newscategory-create')
                <li><a href="{{ route('admin.newscategory.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('newscategory-trash')
                <li><a href="{{ route('admin.newscategory.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted list</span></a></li>
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
                News ID # {{ $news->id }}
                @can('news-list')
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
                            <dd class="col-sm-9">{!! $news->title !!}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Category:</dt>
                            <dd class="col-sm-9">{!! $news->category->name !!}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Short description:</dt>
                            <dd class="col-sm-9">{{ $news->short_description }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Content:</dt>
                            <dd class="col-sm-9">{!! $news->description !!}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Image:</dt>
                            <dd class="col-sm-9"><img src='{{ asset('storage/news/icon/' . $news->image) }}' alt="{{ $news->image_alt }}" title="{{ $news->image_alt }}" /></dd>
                        </dl>
                        
                        <dl class="row">
                            <dt class="col-sm-2">Alt:</dt>
                            <dd class="col-sm-9">{{ $news->image_alt }}</dd>
                        </dl>
                        
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $news->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $news->updated_at }}</dd>
                        </dl>
                        @if($news->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $news->deleted_at }}</dd>                            
                        </dl>
                        
                        {!! Form::model($news, ['method' => 'POST','route' => ['admin.news.processrestore', $news->id]]) !!}
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