<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $user->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $user->email !!}</p>
</div>

<!-- Avatar Field -->
<div class="form-group">
    {!! Form::label('avatar', 'Avatar:') !!}
    <p>{!! $user->avatar !!}</p>
</div>

<!-- Facebook Id Field -->
<div class="form-group">
    {!! Form::label('facebook_id', 'Facebook Id:') !!}
    <p>{!! $user->facebook_id !!}</p>
</div>

<!-- Facebook Token Field -->
<div class="form-group">
    {!! Form::label('facebook_token', 'Facebook Token:') !!}
    <p>{!! $user->facebook_token !!}</p>
</div>

<!-- User Token Field -->
<div class="form-group">
    {!! Form::label('user_token', 'User Token:') !!}
    <p>{!! $user->user_token !!}</p>
</div>

<!-- Fcm Token Field -->
<div class="form-group">
    {!! Form::label('FCM_token', 'Fcm Token:') !!}
    <p>{!! $user->FCM_token !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $user->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $user->updated_at !!}</p>
</div>

