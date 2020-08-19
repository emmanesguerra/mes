@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Category: {{ $newscategory->name }}
                @can('newscategory-list')
                <a href="{{ route('admin.newscategory.index') }}" class="float-right">Back</a>
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
                
                {!! Form::model($newscategory, ['method' => 'PATCH','route' => ['admin.newscategory.update', $newscategory->id]]) !!}
                {!! Form::hidden('id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-10">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('name') text-danger @enderror" for="name">Name</label>
                                    <input maxlength="191" type="text" class="form-control ae-input-field @error('name') is-invalid @enderror " name="name" value="{{ old('name', $newscategory->name) }}" id="name" placeholder="Name"/>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('short_description') text-danger @enderror" for="short_description">Description</label>
                                    <textarea class="form-control ae-input-field @error('short_description') is-invalid @enderror " name="short_description" id="short_description" rows="5"/>{{ old('short_description', $newscategory->short_description) }}</textarea>
                                    @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('newscategory-edit')
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