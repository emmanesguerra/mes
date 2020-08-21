@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Newsletters
                @can('newsletters-list')
                <a href="{{ route('admin.newsletters.index') }}" class="float-right">Back</a>
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
                
                {!! Form::model($newsletters, ['method' => 'PATCH','route' => ['admin.newsletters.update', $newsletters->id], 'files'=>true]) !!}
                {!! Form::hidden('id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('title') text-danger @enderror" for="title">Title</label>
                                    <input maxlength="191" type="text" class="form-control ae-input-field @error('title') is-invalid @enderror " name="title" value="{{ old('title', $newsletters->title) }}" id="title" placeholder="Title"/>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <tinymce-form  :value="{{ (Session::getOldInput('content')) ? json_encode(Session::getOldInput('content')): json_encode($newsletters->content) }}"
                                               :textareaname="{{ json_encode('content') }}"
                                               :label="{{ json_encode('Content') }}"
                                               :height="{{ json_encode('400') }}"
                                               :styles="{{ json_encode(null) }}"
                                               :bodyclass="{{ json_encode('none') }}"
                                               :imagelists="{{ json_encode($images) }}"
                                               :toolbar="{{ json_encode('undo redo | styleselect |  fontsizeselect forecolor bold italic underline | link unlink | alignleft aligncenter alignright | bullist numlist | image | code fullscreen') }}"
                                               :plugins="{{ json_encode('code print preview autolink fullscreen image link media table insertdatetime advlist lists  wordcount textpattern help') }}"
                                               :showmenu="{{ json_encode(true) }}">
                                </tinymce-form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('newsletters-edit')
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