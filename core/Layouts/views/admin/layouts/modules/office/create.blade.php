@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Create New Office Location
                @can('modules-list')
                <a href="{{ route('admin.offices.index') }}" class="float-right">Back</a>
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
                
                {!! Form::open(array('route' => 'admin.offices.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="col-sm-12">
                            <div class="form-row" id="addressrow">
                                <tinymce-form  :value="{{ (Session::getOldInput('address')) ? json_encode(Session::getOldInput('address')): json_encode("") }}"
                                               :textareaname="{{ json_encode('address') }}"
                                               :label="{{ json_encode('Address *') }}"
                                               :height="{{ json_encode('250') }}"
                                               :styles="{{ json_encode($styles) }}"
                                               :bodyclass="{{ json_encode($bodyClass) }}"
                                               :imagelists="{{ json_encode([]) }}"
                                               :toolbar="{{ json_encode('undo redo | styleselect |  fontsizeselect forecolor bold italic underline | link unlink | bullist numlist | code preview help') }}"
                                               :plugins="{{ json_encode('code preview autolink directionality fullscreen link hr insertdatetime advlist lists  wordcount textpattern help') }}"
                                               :showmenu="{{ json_encode(false) }}">
                                </tinymce-form>
                                @error('address')
                                <div  class="form-group  col-sm-12">
                                    <div class="text-danger small">{{ $message }}</div>  
                                </div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('contact_person') text-danger @enderror" for="contact_person">Contact Person</label>
                                    <input maxlength="191" type="text" class="form-control ae-input-field @error('contact_person') is-invalid @enderror " name="contact_person" value="{{ old('contact_person') }}" id="contact_person" placeholder="Contact Person"/>
                                    @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-4">
                                    <label class="@error('telephone') text-danger @enderror" for="telephone">Telephone</label>
                                    <input maxlength="100" type="text" class="form-control ae-input-field @error('telephone') is-invalid @enderror " name="telephone" value="{{ old('telephone') }}" id="telephone" placeholder="Telephone"/>
                                    @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-4">
                                    <label class="@error('mobile') text-danger @enderror" for="mobile">Mobile</label>
                                    <input maxlength="100" type="text" class="form-control ae-input-field @error('mobile') is-invalid @enderror " name="mobile" value="{{ old('mobile') }}" id="mobile" placeholder="Mobile"/>
                                    @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-4">
                                    <label class="@error('email') text-danger @enderror" for="email">Email</label>
                                    <input maxlength="100" type="text" class="form-control ae-input-field @error('email') is-invalid @enderror " name="email" value="{{ old('email') }}" id="email" placeholder="Email"/>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('marker') text-danger @enderror" for="marker">Google Map Pin *</label>
                                    <textarea class="form-control ae-input-field @error('marker') is-invalid @enderror " name="marker" id="marker" rows="5"/>{{ old('marker') }}</textarea>
                                    @error('marker') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                 </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <div class="form-group  col-sm-12">
                                        <label class="@error('m_width') text-danger @enderror" for="m_width">Map Width *</label>
                                        <input maxlength="4" type="text" class="form-control ae-input-field @error('m_width') is-invalid @enderror " name="m_width" value="{{ old('m_width') }}" id="m_width" placeholder="Map Width"/>
                                        @error('m_width') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                    <div class="form-group  col-sm-12">
                                        <label class="@error('m_height') text-danger @enderror" for="m_height">Map Height *</label>
                                        <input maxlength="4" type="text" class="form-control ae-input-field @error('m_height') is-invalid @enderror " name="m_height" value="{{ old('m_height') }}" id="m_height" placeholder="Map Height"/>
                                        @error('m_height') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div  class="form-group  col-sm-9">
                                    <div class="alert alert-info" role="alert">
                                        How to retrieve your google map pin?
                                        <ol>
                                            <li>Go to <a href="https://www.google.com/maps/" target="_blank">google maps</a></li>
                                            <li>Search for the location address</li>
                                            <li>Click the "Share" icon</li>
                                            <li>Go to "Embed a map" tab</li>
                                            <li>Click the "COPY HTML"</li>
                                            <li>Paste the copied html to the textarea above</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="store_hoursrow">
                                <tinymce-form  :value="{{ (Session::getOldInput('store_hours')) ? json_encode(Session::getOldInput('store_hours')): json_encode("") }}"
                                               :textareaname="{{ json_encode('store_hours') }}"
                                               :label="{{ json_encode('Store Hours') }}"
                                               :height="{{ json_encode('200') }}"
                                               :styles="{{ json_encode($styles) }}"
                                               :bodyclass="{{ json_encode($bodyClass) }}"
                                               :imagelists="{{ json_encode([]) }}"
                                               :toolbar="{{ json_encode('undo redo | styleselect |  fontsizeselect forecolor bold italic underline | link unlink | bullist numlist table | code preview help') }}"
                                               :plugins="{{ json_encode('code preview autolink directionality fullscreen link hr insertdatetime advlist lists  wordcount textpattern help table') }}"
                                               :showmenu="{{ json_encode(false) }}">
                                </tinymce-form> 
                                @error('store_hours')
                                <div  class="form-group  col-sm-12">
                                    <div class="text-danger small">{{ $message }}</div> 
                                </div>
                                @enderror 
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('modules-create')
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
@error('address') 
#addressrow .tox-tinymce {
    border: 1px solid #e3342f !important;
}
#addressrow label {
    color: #e3342f;
}
@enderror
@error('store_hours') 
#store_hoursrow .tox-tinymce {
    border: 1px solid #e3342f !important;
}
#store_hoursrow label {
    color: #e3342f;
}
@enderror
</style>
@endsection

@section('javascripttop')
<script src="{{ asset('plugins/tinymce_5.4.1/js/tinymce/tinymce.min.js') }}"></script>
@endsection