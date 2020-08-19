@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Slider
                @can('quotation-list')
                <a href="{{ route('admin.quotes.index') }}" class="float-right">Back</a>
                @endcan
            </div> 
            
            <div class="card-body">
            
                @if (session('status-failed'))
                <div class="alert alert-danger text-left">
                    {{ session('status-failed') }}
                </div>
                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                
                {!! Form::model($quotation, ['method' => 'PATCH','route' => ['admin.quotes.update', $quotation->id]]) !!}
                {!! Form::hidden('id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-10">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-6">
                                    <label class="@error('title') text-danger @enderror" for="title">Title</label>
                                    <input maxlength="191" type="text" class="form-control ae-input-field @error('title') is-invalid @enderror " name="title" value="{{ old('title', $quotation->title) }}" id="title" placeholder="Title"/>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('description') text-danger @enderror" for="description">Description</label>
                                    <textarea class="form-control ae-input-field @error('description') is-invalid @enderror " name="description" id="description" rows="5"/>{{ old('description', $quotation->description) }}</textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('quotation-edit')
                        <button type="submit" class="btn btn-primary">Submit</button>
                        @endcan
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection