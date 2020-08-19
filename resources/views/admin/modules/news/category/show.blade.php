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
                <li><a href="{{ route('admin.newscategory.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('news-trash')
                <li><a href="{{ route('admin.newscategory.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted list</span></a></li>
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
                Category ID # {{ $newscategory->id }}
                @can('newscategory-list')
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
                        @if($newscategory->name)
                        <dl class="row">
                            <dt class="col-sm-2">Name:</dt>
                            <dd class="col-sm-9">{!! $newscategory->name !!}</dd>
                        </dl>
                        @endif
                        @if($newscategory->short_description)
                        <dl class="row">
                            <dt class="col-sm-2">Description:</dt>
                            <dd class="col-sm-9">{{ $newscategory->short_description }}</dd>
                        </dl>
                        @endif
                        
                        
                        <dl class="row">
                            <dt class="col-sm-2">News Titles:</dt>
                            <dd class="col-sm-9">
                                @foreach($newscategory->news as $key => $news)
                                    <p>{{ $key + 1 }}. {{ $news->title }}</p>
                                @endforeach
                            </dd>
                        </dl>
                        
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $newscategory->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $newscategory->updated_at }}</dd>
                        </dl>
                        @if($newscategory->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $newscategory->deleted_at }}</dd>                            
                        </dl>
                        
                        @can('newscategory-restore')
                        {!! Form::model($newscategory, ['method' => 'POST','route' => ['admin.newscategory.processrestore', $newscategory->id]]) !!}
                        <button type="submit" class="btn btn-primary">Restore Record</button>
                        {!! Form::close() !!}
                        @endcan
                        
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection