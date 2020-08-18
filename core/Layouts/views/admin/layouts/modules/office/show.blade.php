@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Office Location ID # {{ $office->id }}
                @can('offices-list')
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
                            <dt class="col-sm-2">Address:</dt>
                            <dd class="col-sm-9">{!! $office->address !!}</dd>
                        </dl>
                        @if($office->contact_person)
                        <dl class="row">
                            <dt class="col-sm-2">Contact Person:</dt>
                            <dd class="col-sm-9">{{ $office->contact_person }}</dd>
                        </dl>
                        @endif
                        @if($office->telephone)
                        <dl class="row">
                            <dt class="col-sm-2">Telephone:</dt>
                            <dd class="col-sm-9">{{ $office->telephone }}</dd>
                        </dl>
                        @endif
                        @if($office->mobile)
                        <dl class="row">
                            <dt class="col-sm-2">Mobile:</dt>
                            <dd class="col-sm-9">{{ $office->mobile }}</dd>
                        </dl>
                        @endif
                        @if($office->email)
                        <dl class="row">
                            <dt class="col-sm-2">Email:</dt>
                            <dd class="col-sm-9">{{ $office->email }}</dd>
                        </dl>
                        @endif
                        <dl class="row">
                            <dt class="col-sm-2">Google Map Pin:</dt>
                            <dd class="col-sm-9">
                                <iframe src="{{ $office->marker }}" width="{{ $office->m_width }}" height="{{ $office->m_height }}" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </dd>
                        </dl>
                        @if($office->store_hours)
                        <dl class="row">
                            <dt class="col-sm-2">Store Hours:</dt>
                            <dd class="col-sm-9">{!! $office->store_hours !!}</dd>
                        </dl>
                        @endif
                        <dl class="row">
                            <dt class="col-sm-2">Created At:</dt>
                            <dd class="col-sm-9">{{ $office->created_at }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-sm-2">Updated At:</dt>
                            <dd class="col-sm-9">{{ $office->updated_at }}</dd>
                        </dl>
                        @if($office->deleted_at)
                        <dl class="row">
                            <dt class="col-sm-2">Deleted At:</dt>
                            <dd class="col-sm-9">{{ $office->deleted_at }}</dd>                            
                        </dl>
                        
                        {!! Form::model($office, ['method' => 'POST','route' => ['admin.offices.processrestore', $office->id]]) !!}
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