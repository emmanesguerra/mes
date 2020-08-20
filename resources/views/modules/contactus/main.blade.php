@foreach($contacts as $contact)
<section class="contactlist">
    <div class="row list">
        <div class="col-sm-6">
            <iframe src="{{ $contact->marker }}" width="{{ $contact->m_width }}" height="{{ $contact->m_height }}" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="col-sm-6 py-4">
            {!! $contact->address !!}
            @if($contact->contact_person)
            <dl class="row">
                <dt class="col-sm-3">Contact Person(s):</dt>
                <dd class="col-sm-9">{{ $contact->contact_person }}</dd>
            </dl>
            @endif
            @if($contact->telephone)
            <dl class="row">
                <dt class="col-sm-3">Telephone:</dt>
                <dd class="col-sm-9">{{ $contact->telephone }}</dd>
            </dl>
            @endif
            @if($contact->mobile)
            <dl class="row">
                <dt class="col-sm-3">Mobile:</dt>
                <dd class="col-sm-9">{{ $contact->mobile }}</dd>
            </dl>
            @endif
            @if($contact->email)
            <dl class="row">
                <dt class="col-sm-3">Email:</dt>
                <dd class="col-sm-9">{{ $contact->email }}</dd>
            </dl>
            @endif      
            {!! $contact->store_hours !!}
        </div>
    </div>
</section>
@endforeach

<h2>Send us a message</h2>
 
@if (session('status-success'))
<div id='contactusform' class="alert alert-success text-left">
    {{ session('status-success') }}
</div>
@endif

@if (count($errors) > 0)
<div id='contactusform' class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif

{!! Form::open(array('route' => 'contactus.store','method'=>'POST', 'class'=>'contactusform')) !!}
<fieldset>
    <div class=" form-group row">
        <div class="col-md-6">
            <label class="@error('name') text-danger @enderror" for="name">Name</label>
            <input type="text" id="name" name='name'  class="form-control @error('name') is-invalid @enderror " value="{{ old('name') }}" />
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror 
        </div>
        <div class="col-md-6">
            <label class="@error('email') text-danger @enderror" for="email">Email</label>
            <input type="text" id="email" name='email'  class="form-control @error('email') is-invalid @enderror " value="{{ old('email') }}" />
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror 
        </div>
    </div>
    <div class=" form-group row">
        <div class="col-md-12">
            <label class="@error('message') text-danger @enderror" for="message">Message/ Inquiry</label>
            <textarea name="message"  class="form-control @error('message') is-invalid @enderror " rows="5">{{ old('message') }}</textarea>
            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror 
        </div>
    </div>
    <div class=" form-group row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary"/>
        </div>
    </div>
</fieldset>
{!! Form::close() !!}
