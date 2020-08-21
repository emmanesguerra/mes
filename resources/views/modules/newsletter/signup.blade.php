<div class='row' id="signupnewsletter">
    <div class='col-md-12'>
        <i class='far fa-envelope'></i>

        <h3>Keep up with our latest news and events!</h3>
        
@if (session('status-success'))
<div class="alert alert-success text-left">
    {{ session('status-success') }}
</div>
@endif
        
@if (session('status-failed'))
<div class="alert alert-danger text-left">
    {{ session('status-failed') }}
</div>
@endif

        {!! Form::open(array('route' => 'subscriber.store','method'=>'POST', 'class'=>'contactusform')) !!}
            <div class="form-row">
                <div class="form-group col-md-12">
                    <input class="form-control form-control-lg @error('email') is-invalid @enderror" name='email' type="text" placeholder="Your email address">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn mb-2">Subscribe</button>
                </div>
            </div>
        {!! Form::close() !!}

        <h4>OR</h4>

        <h3>Follow us on facebook</h3>
        <i class='fab fa-facebook-square'> </i>
    </div>
</div>