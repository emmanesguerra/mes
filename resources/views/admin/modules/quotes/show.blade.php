@extends('admin.app')


@section('right-panel')
<section class="right-panel">
    <div class="card mb-3">
        <div class="card-header">Slider Menu</div>
        <div class="card-body">
            <ul class="admin-menu">
                @can('quotation-list')
                <li><a href="{{ route('admin.quotes.index') }}"><span class='raq'>&raquo;</span><span>View lists</span></a></li>
                @endcan
                @can('quotation-create')
                <li><a href="{{ route('admin.quotes.create') }}"><span class='raq'>&raquo;</span><span>Create New Record</span></a></li>
                @endcan
                @can('quotation-trash')
                <li><a href="{{ route('admin.quotes.trashed') }}"><span class='raq'>&raquo;</span><span>View deleted lists</span></a></li>
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
                Quotation ID # {{ $quotation->id }}
                @can('quotation-list')
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
                        @if($quotation->title)
                        <dl class="row">
                            <dt class="col-sm-2">Title:</dt>
                            <dd class="col-sm-9">{!! $quotation->title !!}</dd>
                        </dl>
                        @endif
                        @if($quotation->description)
                        <dl class="row">
                            <dt class="col-sm-2">Description:</dt>
                            <dd class="col-sm-9">{{ $quotation->description }}</dd>
                        </dl>
                        @endif
                        
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $quotation->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $quotation->updated_at }}</dd>
                        </dl>
                        @if($quotation->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $quotation->deleted_at }}</dd>                            
                        </dl>
                        
                        {!! Form::model($quotation, ['method' => 'POST','route' => ['admin.quotes.processrestore', $quotation->id]]) !!}
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