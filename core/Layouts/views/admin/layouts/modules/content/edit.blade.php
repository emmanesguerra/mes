@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Content: {{ $content->name }}
                @can('contents-list')
                <a href="{{ route('admin.contents.index') }}" class="float-right">Back</a>
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
                
                {!! Form::model($content, ['method' => 'PATCH','route' => ['admin.contents.update', $content->id]]) !!}
                {!! Form::hidden('id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-5">
                                    <label class="@error('name') text-danger @enderror" for="name">Name *</label>
                                    <input minlength="4" maxlength="50" type="text" class="form-control ae-input-field @error('name') is-invalid @enderror " name="name" value="{{ old('name', $content->name) }}" id="name" placeholder="Name" required/>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-row">
                            <tinymce-form  :value="{{ (Session::getOldInput('html_template')) ? json_encode(Session::getOldInput('html_template')): json_encode($content->html_template) }}"
                                           :textareaname="{{ json_encode('html_template') }}"
                                           :label="{{ json_encode('Content') }}"
                                           :height="{{ json_encode('400') }}"
                                           :styles="{{ json_encode($styles) }}"
                                           :bodyclass="{{ json_encode($content->container_class) }}"
                                           :imagelists="{{ json_encode($images) }}"
                                           :toolbar="{{ json_encode('undo redo | styleselect |  fontsizeselect forecolor bold italic underline | link unlink | alignleft aligncenter alignright | bullist numlist | image | code fullscreen') }}"
                                           :plugins="{{ json_encode('code print preview autolink fullscreen image link media table insertdatetime advlist lists  wordcount imagetools textpattern help') }}"
                                           :showmenu="{{ json_encode(true) }}">
                            </tinymce-form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        @can('contents-edit')
                        <button data-toggle="modal" data-target="#contentModal" type="button" class="btn btn-primary">Proceed</button>
                        @endcan
                    </div>
                    <div class="modal fade" id="contentModal" tabindex="-1" role="dialog" aria-labelledby="contentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="settingsModalLabel">Continue Posting</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Continue saving content? Kindly double check the content and check the preview before continue posting.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <input  type="submit" class="btn btn-primary" value="Submit" />
                                </div>
                            </div>
                        </div>
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