@extends('admin.app')

@section('right-panel')
<section class="right-panel">
    
    @can('downloadables-list')
    <div class="card mb-3">
        <div class="card-header">Directory Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('downloadables-create')
                <li><a href="{{ route('admin.downloadables.create') }}"><span class='raq'>&raquo;</span><span>Create Directory</span></a></li>
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
                Downloadable ID # {{ $downloadables->id }}
                @can('downloadables-list')
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
                            <dt class="col-sm-2">Directory Name:</dt>
                            <dd class="col-sm-9">{!! $downloadables->directory !!}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Files:</dt>
                            <dd class="col-sm-9">
                                @foreach($images as $image)
                                <a href="{{ $image->value }}"> {{ $image->title }} </a> <br />
                                @endforeach
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection