@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Displaying details of {{ $page->title }}
                @can('pages-list')
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
                            <dt class="col-sm-2">Name:</dt>
                            <dd class="col-sm-9">{!! $page->name !!}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Title:</dt>
                            <dd class="col-sm-9">{!! $page->title !!}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Url Slug:</dt>
                            <dd class="col-sm-9">{{ $page->url }}</dd>
                        </dl>
                        @if($page->description)
                        <dl class="row">
                            <dt class="col-sm-2">Description:</dt>
                            <dd class="col-sm-9">{{ $page->description }}</dd>
                        </dl>
                        @endif
                        <dl class="row">
                            <dt class="col-sm-2">Loaded Javascripts:</dt>
                            <dd class="col-sm-9">{{ implode(',', $page->javascripts) }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Loaded CSS:</dt>
                            <dd class="col-sm-9">{{ implode(',', $page->css) }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Template used:</dt>
                            <dd class="col-sm-9">{{ $page->template }}</dd>
                            </dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Contents:</dt>
                        </dl>
                        
                        <div class="row mx-3">
                            <div class="col-sm-12">
                            @foreach( $page->contents as $content)
                                <dl class="row">
                                    <dt class="col-sm-2">Panel "{{ $content->pivot->tags }}":</dt>
                                </dl>
                                <div class="row mx-3">
                                    <div class="col-sm-12">
                                        <dl class="row">
                                            <dt class="col-sm-2">Name:</dt>
                                            <dd class="col-sm-2">{{ $content->name }}</dd>
                                        </dl>
                                        @if($content->html_template)
                                        <dl class="row">
                                            <dt class="col-sm-2">Content:</dt>
                                            <dd class="col-sm-2">{!! $content->html_template !!}</dd>
                                        </dl>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $page->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $page->updated_at }}</dd>
                        </dl>
                        @if($page->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $page->deleted_at }}</dd>                            
                        </dl>
                        
                        {!! Form::model($page, ['method' => 'POST','route' => ['admin.pages.processrestore', $page->id]]) !!}
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