@extends('auth.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Change password form</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.changepswd.post') }}">
                        @csrf

                        @if (session('feedback'))
                        <div class="alert alert-danger text-left">
                            {{ session('feedback') }}
                        </div>
                        @endif

                        <div  class="form-group row">
                            <div class="col-md-12">
                                <p class="">
                                    You are required to change the password on initial login . Please follow this guidelines below for a secure password:
                                </p>
                                <ul class="">
                                    <li>should be <strong class="text-danger">8 characters</strong> long</li>
                                    <li>should contain <strong class="text-danger">at-least 1 UPPERCASE</strong></li>
                                    <li>should contain <strong class="text-danger">at-least 1 lowercase</strong></li>
                                    <li>should contain <strong class="text-danger">at-least 1 Numeric</strong></li>
                                </ul>
                            </div>
                        </div>
                        <div  class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right @error('password') text-danger @enderror" for="password">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror " name="password" value="{{ old('password') }}" id="password" placeholder="Password" required />
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                            </div>
                        </div>
                        <div  class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right @error('password_confirmation') text-danger @enderror" for="password_confirmation">Re Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror " name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirmation" placeholder="Re-type Password" required />
                                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                            </div>
                        </div>
                                    

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary"> Change Password </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
