@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Category Create') }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group pull-right">
                    <a class="btn btn-primary m-b-md" href="{{route('product.index')}}"> Back</a>
                </div>
            </div>
        </div>
        {!! Form::model($product, array('route' => 'product.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group {{ $errors->has('category_id') ? ' has-error' : ''}}">
                    <label>Category:</label>
                    {!! Form::select('category_id', $category, null, array('class' => 'form-control')) !!}
                    {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : ''}}">
                    <label>Name *:</label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group {{ $errors->has('description') ? ' has-error' : ''}}">
                    <label>Description:</label>
                    {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group {{ $errors->has('status') ? ' has-error' : ''}}">
                    <label>status:</label>
                    {!! Form::select('status', ['ACTIVE'=>'ACTIVE', 'INACTIVE'=>'INACTIVE'], null, array('class' => 'form-control')) !!}
                    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-lg-12 text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
