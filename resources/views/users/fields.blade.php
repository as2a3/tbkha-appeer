<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Avatar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('avatar', 'Avatar:') !!}
    {!! Form::file('avatar') !!}
</div>
<div class="clearfix"></div>

<!-- Facebook Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('facebook_id', 'Facebook Id:') !!}
    {!! Form::number('facebook_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Facebook Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('facebook_token', 'Facebook Token:') !!}
    {!! Form::number('facebook_token', null, ['class' => 'form-control']) !!}
</div>

<!-- User Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_token', 'User Token:') !!}
    {!! Form::text('user_token', null, ['class' => 'form-control']) !!}
</div>

<!-- Fcm Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('FCM_token', 'Fcm Token:') !!}
    {!! Form::text('FCM_token', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>
