@extends('admin.app')


@section('module-content')
<section class="main-panel">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Navigation Setting
                @can('menus-list')
                <a href="{{ route('admin.menus.index') }}" class="float-right">Back</a>
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
                
                {!! Form::model($settings, ['method' => 'POST','route' => ['admin.menus.settings.store', $settings->menu_id]]) !!}
                {!! Form::hidden('menu_id') !!}
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <h3>Main Block</h3>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('blck_start') text-danger @enderror" for="blck_start"><code>Main</code> block *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('blck_start') is-invalid @enderror " name="blck_start" value="{{ old('blck_start', $settings->blck_start) }}" id="blck_start" required/>
                                    @error('blck_start') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('blck_end') text-danger @enderror" for="blck_end">End <code>Main</code> block *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('blck_end') is-invalid @enderror " name="blck_end" value="{{ old('blck_end', $settings->blck_end) }}" id="blck_end" required/>
                                    @error('blck_end') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('list_dflt') text-danger @enderror" for="list_dflt"><code>List</code> block *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('list_dflt') is-invalid @enderror " name="list_dflt" value="{{ old('list_dflt', $settings->list_dflt) }}" id="list_dflt" required/>
                                    @error('list_dflt') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('list_dflt_active') text-danger @enderror" for="list_dflt_active"><code>List</code> active block *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('list_dflt_active') is-invalid @enderror " name="list_dflt_active" value="{{ old('list_dflt_active', $settings->list_dflt_active) }}" id="list_dflt_active" required/>
                                    @error('list_dflt_active') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('list_chld') text-danger @enderror" for="list_chld"><code>List</code> block w/ children *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('list_chld') is-invalid @enderror " name="list_chld" value="{{ old('list_chld', $settings->list_chld) }}" id="list_chld" required/>
                                    @error('list_chld') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('list_end') text-danger @enderror" for="list_end">End <code>list</code> block *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('list_end') is-invalid @enderror " name="list_end" value="{{ old('list_end', $settings->list_end) }}" id="list_end" required/>
                                    @error('list_end') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('anch_dflt') text-danger @enderror" for="anch_dflt"><code>Anchor</code> class *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('anch_dflt') is-invalid @enderror " name="anch_dflt" value="{{ old('anch_dflt', $settings->anch_dflt) }}" id="anch_dflt" required/>
                                    @error('anch_dflt') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('anch_chld') text-danger @enderror" for="anch_chld"><code>Anchor</code> class w/ children *</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('anch_chld') is-invalid @enderror " name="anch_chld" value="{{ old('anch_chld', $settings->anch_chld) }}" id="anch_chld" required/>
                                    @error('anch_chld') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <h3>Succeeding Block(s)</h3>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('subblck_start') text-danger @enderror" for="subblck_start">Succeeding <code>main</code> block</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('subblck_start') is-invalid @enderror " name="subblck_start" value="{{ old('subblck_start', $settings->subblck_start) }}" id="subblck_start"/>
                                    @error('subblck_start') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('subblck_end') text-danger @enderror" for="subblck_end">End <code>main</code> block</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('subblck_end') is-invalid @enderror " name="subblck_end" value="{{ old('subblck_end', $settings->subblck_end) }}" id="subblck_end"/>
                                    @error('subblck_end') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('sublist_dflt') text-danger @enderror" for="sublist_dflt">Succeeding <code>list</code> block</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('sublist_dflt') is-invalid @enderror " name="sublist_dflt" value="{{ old('sublist_dflt', $settings->sublist_dflt) }}" id="sublist_dflt"/>
                                    @error('sublist_dflt') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('sublist_chld') text-danger @enderror" for="sublist_chld"><code>list</code> block w/ children</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('sublist_chld') is-invalid @enderror " name="sublist_chld" value="{{ old('sublist_chld', $settings->sublist_chld) }}" id="sublist_chld"/>
                                    @error('sublist_chld') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('sublist_end') text-danger @enderror" for="sublist_end">End <code>list</code> block</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('sublist_end') is-invalid @enderror " name="sublist_end" value="{{ old('sublist_end', $settings->sublist_end) }}" id="sublist_end"/>
                                    @error('sublist_end') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                            <div class="form-row">
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('subanch_dflt') text-danger @enderror" for="subanch_dflt">Succeeding <code>Anchor</code> class</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('subanch_dflt') is-invalid @enderror " name="subanch_dflt" value="{{ old('subanch_dflt', $settings->subanch_dflt) }}" id="subanch_dflt"/>
                                    @error('subanch_dflt') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div  class="form-group  col-sm-3">
                                    <label class="@error('subanch_chld') text-danger @enderror" for="subanch_chld"><code>Anchor</code> class w/ children</label>
                                    <input maxlength="50" type="text" class="form-control ae-input-field @error('subanch_chld') is-invalid @enderror " name="subanch_chld" value="{{ old('subanch_chld', $settings->subanch_chld) }}" id="subanch_chld"/>
                                    @error('subanch_chld') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @can('menus-edit')
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