@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Recipe
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                  {!! Form::open(array('route' => 'recipes.store' , 'method'=>'POST', 'files'=>true)) !!}
                  <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">
                        @include('recipes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
