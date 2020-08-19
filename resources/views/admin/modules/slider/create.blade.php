@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Create New Slider
                @can('slider-list')
                <a href="{{ route('admin.sliders.index') }}" class="float-right">Back</a>
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
                
                {!! Form::open(array('route' => 'admin.sliders.store','method'=>'POST', 'files'=>true)) !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-10">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div class="form-group  col-sm-12">
                                    <label>Image * </label>
                                    {{ Form::file('image') }}
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-6">
                                    <label class="@error('backgound_pos') text-danger @enderror" for="image_alt">Image position *</label>
                                    <treeselect-form 
                                        v-bind:value="{{ (Session::getOldInput('backgound_pos')) ? json_encode(Session::getOldInput('backgound_pos')): json_encode('center') }}"
                                        v-bind:selectoptions="{{ json_encode($positions) }}"
                                        v-bind:haserror="{{ $errors->has('backgound_pos') ? "true": "false" }}"
                                        v-bind:fieldname="{{ json_encode('backgound_pos') }}"
                                        v-bind:multiple="{{ json_encode(false) }}"
                                        v-bind:forpagetemplate="{{ json_encode(false) }}"
                                        v-bind:forpagetemplateurl="{{ json_encode(null) }}">
                                    </treeselect-form>
                                    @error('backgound_pos') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group  col-sm-12">
                                    <br />
                                    <br />
                                    <h5>Short Message <small>(optional)</small></h5>
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-6">
                                    <label class="@error('title') text-danger @enderror" for="title">Title</label>
                                    <input maxlength="191" type="text" class="form-control ae-input-field @error('title') is-invalid @enderror " name="title" value="{{ old('title') }}" id="title" placeholder="Title"/>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-6">
                                    <label class="@error('link') text-danger @enderror" for="link">Link</label>
                                    <input maxlength="100" type="text" class="form-control ae-input-field @error('link') is-invalid @enderror " name="link" value="{{ old('link') }}" id="link" placeholder="Link"/>
                                    @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('description') text-danger @enderror" for="description">Description</label>
                                    <textarea class="form-control ae-input-field @error('description') is-invalid @enderror " name="description" id="description" rows="5"/>{{ old('description') }}</textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                 </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-5">
                                    <label class="@error('text_pos1') text-danger @enderror @error('text_pos2') text-danger @enderror" for="link">Position</label>
                                    <div class="form-row">
                                        <div  class="form-group  col-sm-6">
                                            <treeselect-form-multi
                                                v-bind:value="{{ (Session::getOldInput('text_pos1')) ? json_encode(Session::getOldInput('text_pos1')): json_encode('top') }}"
                                                v-bind:selectoptions="{{ json_encode($pos1) }}"
                                                v-bind:haserror="{{ $errors->has('text_pos1') ? "true": "false" }}"
                                                v-bind:fieldname="{{ json_encode('text_pos1') }}">
                                            </treeselect-form-multi>
                                            @error('text_pos1') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                        </div>
                                        <div  class="form-group  col-sm-6">
                                            <treeselect-form-multi
                                                v-bind:value="{{ (Session::getOldInput('text_pos2')) ? json_encode(Session::getOldInput('text_pos2')): json_encode('lft') }}"
                                                v-bind:selectoptions="{{ json_encode($pos2) }}"
                                                v-bind:haserror="{{ $errors->has('text_pos2') ? "true": "false" }}"
                                                v-bind:fieldname="{{ json_encode('text_pos2') }}">
                                            </treeselect-form-multi>
                                            @error('text_pos2') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('slider-create')
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