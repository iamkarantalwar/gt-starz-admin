{!! Form::model($driver, ((!empty($driver)) ?
    ['method' => 'PATCH', 'route' => ['drivers.update', ['driver' => $driver]],
    'enctype' => 'multipart/form-data'] :
    ['method' => 'POST',
    'route' => ['drivers.store'],
    'enctype' => 'multipart/form-data'])) !!}
        <div class="form-group row">
            <label for="driverName" class="col-sm-2 col-form-label">Driver Name</label>
            <div class="col-sm-10">
                {{Form::text('name', null, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid':''),
                                            'id'=>'driverName', 'placeholder' => 'Driver Name.']) }}
                @if ($errors->has('name'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="driverName" class="col-sm-2 col-form-label">Driver Username</label>
            <div class="col-sm-10">
                {{Form::text('username', null, ['class' => 'form-control '.($errors->has('username') ? 'is-invalid':''),
                                            'id'=>'driverName', 'placeholder' => 'Driver Username.']) }}
                @if ($errors->has('username'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="driverEmail" class="col-sm-2 col-form-label">Driver Email</label>
            <div class="col-sm-10">
                {{Form::email('email', null, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid':''),
                                            'id'=>'driverEmail', 'placeholder' => 'Driver Email.']) }}
                @if ($errors->has('email'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="driverPassword" class="col-sm-2 col-form-label">Driver Password</label>
            <div class="col-sm-10">
                {{Form::password('password', ['id'=>'driverPassword',
                                             'class' => 'form-control '.($errors->has('password') ? 'is-invalid':''),
                                             'placeholder' => 'Driver Password.']) }}
                @if ($errors->has('password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="driverCPassword" class="col-sm-2 col-form-label">Confirm Password</label>
            <div class="col-sm-10">
                {{Form::password('confirm_password', ['class' => 'form-control '.($errors->has('confirm_password') ? 'is-invalid':''),
                                            'id'=>'driverCPassword', 'placeholder' => 'Confirm Password.']) }}
                @if ($errors->has('confirm_password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('confirm_password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="driverAddress" class="col-sm-2 col-form-label">Driver Address</label>
            <div class="col-sm-10">
                {{Form::textarea('address', null, ['id'=>'driverAddress',
                                                    'class' => 'form-control '.($errors->has('address') ? 'is-invalid':''),
                                                    'placeholder' => 'Driver Address.']) }}
                @if ($errors->has('address'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="driverAddress" class="col-sm-2 col-form-label">Driver Contact</label>
            <div class="col-sm-10">
                {{Form::text('phone_number', null, ['class' => 'form-control '.($errors->has('phone_number') ? 'is-invalid':''),
                                            'id'=>'driverAddress', 'placeholder' => 'Driver Phone Number.']) }}
                @if ($errors->has('phone_number'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="driverAddress" class="col-sm-2 col-form-label">Driver Status</label>
            <div class="col-sm-1">
                {{Form::radio('approved', "1", ['class' => 'form-control '.($errors->has('phone_number') ? 'is-invalid':''),
                                            'id'=>'driverAddress', 'placeholder' => 'Driver Phone Number.']) }}
                Approved
            </div>

            <div class="col-sm-3">
                {{Form::radio('approved', "0", ['class' => 'form-control '.($errors->has('phone_number') ? 'is-invalid':''),
                                            'id'=>'driverAddress', 'placeholder' => 'Driver Phone Number.']) }}
                Not Approved
            </div>
            @if ($errors->has('approved'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $errors->first('approved') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-primary">{{ isset($driver) ? 'Update' : 'Save'}} Driver</button>
            </div>
        </div>
{!! Form::close() !!}
