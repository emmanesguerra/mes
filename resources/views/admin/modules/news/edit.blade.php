@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit News
                @can('news-list')
                <a href="{{ route('admin.news.index') }}" class="float-right">Back</a>
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
                
                {!! Form::model($news, ['method' => 'PATCH','route' => ['admin.news.update', $news->id], 'files'=>true]) !!}
                {!! Form::hidden('id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-10">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('title') text-danger @enderror" for="title">Title</label>
                                    <input maxlength="191" type="text" class="form-control ae-input-field @error('title') is-invalid @enderror " name="title" value="{{ old('title', $news->title) }}" id="title" placeholder="Title"/>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-6">
                                    <label class="@error('category_id') text-danger @enderror" for="category_id">Category *</label>
                                    <treeselect-form-multi
                                        v-bind:value="{{ (Session::getOldInput('category_id')) ? json_encode(Session::getOldInput('category_id')): json_encode($news->category_id) }}"
                                        v-bind:selectoptions="{{ json_encode($categories) }}"
                                        v-bind:haserror="{{ $errors->has('category_id') ? "true": "false" }}"
                                        v-bind:fieldname="{{ json_encode('category_id') }}">
                                    </treeselect-form-multi>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('short_description') text-danger @enderror" for="short_description">Short Description</label>
                                    <textarea class="form-control ae-input-field @error('short_description') is-invalid @enderror " name="short_description" id="short_description" rows="5"/>{{ old('short_description', $news->short_description) }}</textarea>
                                    @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                 </div>
                            </div>
                            <div class="form-row">
                                <tinymce-form  :value="{{ (Session::getOldInput('description')) ? json_encode(Session::getOldInput('description')): json_encode($news->description) }}"
                                               :textareaname="{{ json_encode('description') }}"
                                               :label="{{ json_encode('Content') }}"
                                               :height="{{ json_encode('400') }}"
                                               :styles="{{ json_encode($styles) }}"
                                               :bodyclass="{{ json_encode('aetinymce-content') }}"
                                               :imagelists="{{ json_encode($images) }}"
                                               :toolbar="{{ json_encode('undo redo | styleselect |  fontsizeselect forecolor bold italic underline | link unlink | alignleft aligncenter alignright | bullist numlist | image | code fullscreen') }}"
                                               :plugins="{{ json_encode('code print preview autolink fullscreen image link media table insertdatetime advlist lists  wordcount imagetools textpattern help') }}"
                                               :showmenu="{{ json_encode(true) }}">
                                </tinymce-form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('news-edit')
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

@section('styles')
<style>
.tox-tinymce {
    border: 1px solid #665847 !important;
}
</style>
@endsection

@section('javascripttop')
<script src="{{ asset('plugins/tinymce_5.4.1/js/tinymce/tinymce.min.js') }}"></script>
@endsection