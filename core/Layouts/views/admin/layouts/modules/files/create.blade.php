@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Upload File(s)
                @can('files-list')
                <a href="{{ route('admin.files.index') }}" class="float-right">Back</a>
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

                {!! Form::open(array('route' => 'admin.files.store','method'=>'POST','files'=>'true')) !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div  class="form-group  col-sm-12">
                                    <label class="@error('module_name') text-danger @enderror" for="module_name">Select the file(s) to upload.</label>
                                    {!! Form::file('attachments[]', [ 'id'=>'attachement', 'multiple' => true,  'accept'=>"application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                                    text/plain, application/pdf, image/jpg, image/jpeg, image/gif, image/png"]) !!} 
                                    @error('module_name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <button type="button" onclick="$('#attachement').next().find('.ff_fileupload_actions button.ff_fileupload_start_upload').click(); return false;" class='btn btn-secondary'>Upload all files</button>
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
<link href="{{ asset('plugins/jquery-fancyfileuploader-master/fancy-file-uploader/fancy_fileupload.css') }}" rel="stylesheet">
@endsection

@section('javascript')
<script src="{{ asset('plugins/jquery-fancyfileuploader-master/fancy-file-uploader/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('plugins/jquery-fancyfileuploader-master/fancy-file-uploader/jquery.fileupload.js') }}"></script>
<script src="{{ asset('plugins/jquery-fancyfileuploader-master/fancy-file-uploader/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('plugins/jquery-fancyfileuploader-master/fancy-file-uploader/jquery.fancy-fileupload.js') }}"></script>
<script>
$(document).ready(function () {
    $('#attachement').FancyFileUpload({
        url: '{{ route("admin.files.store") }}',
        params: {
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        maxfilesize: 2000000, //2MB
        retries : 1
    });
});
</script>
@endsection