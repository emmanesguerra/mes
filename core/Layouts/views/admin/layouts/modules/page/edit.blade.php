@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Page: {{ $page->title }}
                @can('pages-list')
                <a href="{{ route('admin.pages.index') }}" class="float-right">Back</a>
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
                
                {!! Form::model($page, ['method' => 'PATCH','route' => ['admin.pages.update', $page->id]]) !!}
                {!! Form::hidden('id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-7">
                                    <label class="@error('name') text-danger @enderror" for="name">Name * <small>(as page/menu name)</small></label>
                                    <input minlength="4" maxlength="50" type="text" class="form-control ae-input-field @error('name') is-invalid @enderror " name="name" value="{{ old('name', $page->name) }}" id="name" placeholder="Name" required/>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-7">
                                    <label class="@error('title') text-danger @enderror" for="title">Title * <small>(as page/meta title)</small></label>
                                    <input minlength="4" maxlength="50" type="text" class="form-control ae-input-field @error('title') is-invalid @enderror " name="title" value="{{ old('title', $page->title) }}" id="title" placeholder="Title" required/>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-5">
                                    <label class="@error('url') text-danger @enderror" for="url">Url Slug *</label>
                                    <span class="form-control ae-input-field">{{ $page->url }}</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('description') text-danger @enderror" for="description">Description * <small>(as meta description)</small></label>
                                    <textarea class="form-control ae-input-field @error('description') is-invalid @enderror " name="description" id="description" rows="5" required>{{ old('description', $page->description) }}</textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-4">
                                    <label class="@error('template') text-danger @enderror" for="template">Html Template *</label>
                                    <treeselect-form 
                                        v-bind:value="{{ (Session::getOldInput('template')) ? json_encode(Session::getOldInput('template')): json_encode($page->template) }}"
                                        v-bind:selectoptions="{{ json_encode($files) }}"
                                        v-bind:haserror="{{ $errors->has('template') ? "true": "false" }}"
                                        v-bind:fieldname="{{ json_encode('template') }}"
                                        v-bind:multiple="{{ json_encode(false) }}"
                                        v-bind:forpagetemplate="{{ json_encode(true) }}"
                                        v-bind:forpagetemplateurl="'{!! route('admin.pages.template') !!}'">
                                    </treeselect-form>
                                    @error('template') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-4">
                                    <label class="@error('javascripts') text-danger @enderror" for="javascripts">Javascripts</label>
                                    <treeselect-form 
                                        v-bind:value="{{ (Session::getOldInput('javascripts')) ? json_encode(Session::getOldInput('javascripts')): json_encode($page->javascripts) }}"
                                        v-bind:selectoptions="{{ json_encode($scripts) }}"
                                        v-bind:haserror="{{ $errors->has('javascripts') ? "true": "false" }}"
                                        v-bind:fieldname="{{ json_encode('javascripts[]') }}"
                                        v-bind:multiple="{{ json_encode(true) }}"
                                        v-bind:forpagetemplate="{{ json_encode(false) }}"
                                        v-bind:forpagetemplateurl="{{ json_encode(null) }}">
                                    </treeselect-form>
                                    @error('javascripts') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-4">
                                    <label class="@error('css') text-danger @enderror" for="css">Styles</label>
                                    <treeselect-form 
                                        v-bind:value="{{ (Session::getOldInput('css')) ? json_encode(Session::getOldInput('css')): json_encode($page->css) }}"
                                        v-bind:selectoptions="{{ json_encode($styles) }}"
                                        v-bind:haserror="{{ $errors->has('css') ? "true": "false" }}"
                                        v-bind:fieldname="{{ json_encode('css[]') }}"
                                        v-bind:multiple="{{ json_encode(true) }}"
                                        v-bind:forpagetemplate="{{ json_encode(false) }}"
                                        v-bind:forpagetemplateurl="{{ json_encode(null) }}">
                                    </treeselect-form>
                                    @error('css') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            
                            <page-panel-form v-for="panel in panels"
                                        v-bind:model="panel"
                                        v-bind:contents="{{ json_encode($contents) }}">
                            </page-panel-form>
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('pages-edit')
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
@section('javascript')
<script>
    window.app.panels = {!! json_encode($panels) !!}
</script>
@endsection