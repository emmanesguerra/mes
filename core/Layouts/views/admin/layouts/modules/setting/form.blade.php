@extends('admin.app')

@section('module-content')
<!-- Main content -->
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">Site Management</div> 
            
            @if (session('status-success'))
            <div class="card-body">
                <div class="alert alert-success text-left">
                    {{ session('status-success') }}
                </div>
            </div>
            @endif
            
            @if (session('status-failed'))
            <div class="card-body">
                <div class="alert alert-danger text-left">
                    {{ session('status-failed') }}
                </div>
            </div>
            @endif
            
            @if (count($errors) > 0)
            <div class="card-body">
                <div class="alert alert-danger text-left">
                    <strong>Whoops!</strong> There were problems with the input: <br />
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            <div class="card-body">
                <form autocomplete="off" id="settingsform" action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="col-sm-12">
                                <div  class="form-group row">
                                    <h4>Website Profile</h4>
                                </div>
                                <div class="form-row">
                                    <div  class="custom-control form-group  col-sm-12">
                                        <label class="@error('domain_name') text-danger @enderror" for="domain_name">Root Domain *</label>
                                        <input maxlength="191" type="text" class="form-control ae-input-field @error('domain_name') is-invalid @enderror " name="domain_name" value="{{ old('domain_name', $data['model']['domain_name']) }}" id="domain_name" placeholder="ex. your.website.com" required/>
                                        @error('domain_name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-12">
                                        <label class="@error('website_name') text-danger @enderror" for="website_name">Website name *</label>
                                        <input maxlength="191" type="text" class="form-control ae-input-field @error('website_name') is-invalid @enderror " name="website_name" value="{{ old('website_name', $data['model']['website_name']) }}" id="website_name" placeholder="ex. Your Website" required/>
                                        @error('website_name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-12">
                                        <label class="@error('owner') text-danger @enderror" for="owner">Owner</label>
                                        <input maxlength="100" type="text" class="form-control ae-input-field @error('owner') is-invalid @enderror " name="owner" value="{{ old('owner', $data['model']['owner']) }}" id="owner" placeholder="Owner's name" />
                                        @error('owner') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                
                                <div  class="form-group row mt-5">
                                    <h4>Other Settings</h4>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-12">
                                        <label class="@error('office_css') text-danger @enderror" for="office_css">Css style where "Office" data displays</label>
                                        <input maxlength="100" type="text" class="form-control ae-input-field @error('office_css') is-invalid @enderror " name="office_css" value="{{ old('office_css', $data['model']['office_css']) }}" id="office_css"/>
                                        @error('office_css') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-12">
                                        <label class="@error('office_block_class') text-danger @enderror" for="office_block_class">Block class of "Office"</label>
                                        <input maxlength="100" type="text" class="form-control ae-input-field @error('office_block_class') is-invalid @enderror " name="office_block_class" value="{{ old('office_block_class', $data['model']['office_block_class']) }}" id="office_block_class"/>
                                        @error('office_block_class') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="col-sm-12">

                                <div  class="form-group row">
                                    <h4>Contact Us Emailing Addresses</h4>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-12">
                                        <label class="@error('email_title') text-danger @enderror" for="email_title">Default Title:</label>
                                        <input maxlength="50" type="text" class="form-control ae-input-field @error('email_title') is-invalid @enderror " name="email_title" value="{{ old('email_title', $data['model']['email_title']) }}" id="email_title" placeholder="Title" />
                                        @error('email_title') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-12">
                                        <label class="@error('email_reciever') text-danger @enderror" for="email_reciever">Send To: <span class="small">(comma seperated)</span></label>
                                        <input type="text" class="form-control ae-input-field @error('email_reciever') is-invalid @enderror " name="email_reciever" value="{{ old('email_reciever', $data['model']['email_reciever']) }}" id="email_reciever" placeholder="Send To" />
                                        @error('email_reciever') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-12">
                                        <label class="@error('email_cc') text-danger @enderror" for="email_cc">CCs: <span class="small">(comma seperated)</label>
                                        <input type="text" class="form-control ae-input-field @error('email_cc') is-invalid @enderror " name="email_cc" value="{{ old('email_cc', $data['model']['email_cc']) }}" id="email_cc" placeholder="Cc" />
                                        @error('email_cc') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div  class="form-group  col-sm-12">
                                        <label class="@error('email_bcc') text-danger @enderror" for="email_bcc">BCCs: <span class="small">(comma seperated)</label>
                                        <input type="text" class="form-control ae-input-field @error('email_bcc') is-invalid @enderror " name="email_bcc" value="{{ old('email_bcc', $data['model']['email_bcc']) }}" id="email_bcc" placeholder="Bcc" />
                                        @error('email_bcc') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            @can('settings-edit')
                            <input  type="submit" class="btn btn-primary" value="Submit" />
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection