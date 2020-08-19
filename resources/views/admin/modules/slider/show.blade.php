@extends('admin.app')


@section('right-panel')
<section class="right-panel">
    <div class="card mb-3">
        <div class="card-header">Slider Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('slider-list')
                <li><a href="{{ route('admin.sliders.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @endcan
                @can('slider-create')
                <li><a href="{{ route('admin.sliders.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('slider-trash')
                <li><a href="{{ route('admin.sliders.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted lists</span></a></li>
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
                Slider ID # {{ $slider->id }}
                @can('slider-list')
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
                        @if($slider->title)
                        <dl class="row">
                            <dt class="col-sm-2">Title:</dt>
                            <dd class="col-sm-9">{!! $slider->title !!}</dd>
                        </dl>
                        @endif
                        @if($slider->description)
                        <dl class="row">
                            <dt class="col-sm-2">Description:</dt>
                            <dd class="col-sm-9">{{ $slider->description }}</dd>
                        </dl>
                        @endif
                        @if($slider->link)
                        <dl class="row">
                            <dt class="col-sm-2">Link:</dt>
                            <dd class="col-sm-9">{{ $slider->link }}</dd>
                        </dl>
                        @endif
                        <dl class="row">
                            <dt class="col-sm-2">Image:</dt>
                            <dd class="col-sm-9"><img src='{{ asset('storage/sliders/icon/' . $slider->image) }}' alt="{{ $slider->image_alt }}" title="{{ $slider->image_alt }}" /></dd>
                        </dl>
                        
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $slider->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $slider->updated_at }}</dd>
                        </dl>
                        @if($slider->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $slider->deleted_at }}</dd>                            
                        </dl>
                        
                        {!! Form::model($slider, ['method' => 'POST','route' => ['admin.sliders.processrestore', $slider->id]]) !!}
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