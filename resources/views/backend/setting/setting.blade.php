@extends('backend/layout/layout')
@section('content')
    {!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
    {!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);
    });
</script>
<section class="content-header">
    <h1> Settings
        <small> | Change Settings</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Change Settings</li>
    </ol>
</section>
<br>
<br>
<div class="col-lg-10">

    @include('flash::message')
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
        <li><a href="#info" data-toggle="tab">Info</a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="settings">
            <br>
            <h4><i class="glyphicon glyphicon-cog"></i> Settings</h4>

            <br>
            {!! Form::open(array('files'=>true)) !!}

            <!-- Title -->
            <div class="control-group {!! $errors->has('site_title') ? 'has-error' : '' !!}">
                <label class="control-label" for="title">Title</label>

                <div class="controls">
                    {!! Form::text('site_title', ($setting['site_title']) ?: null, array('class'=>'form-control', 'id' => 'site_title', 'placeholder'=>'Title', 'value'=>Input::old('site_title'))) !!}
                    @if ($errors->first('title'))
                    <span class="help-block">{!! $errors->first('site_title') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Google Analytics Code -->
            <div class="control-group {!! $errors->has('ga_code') ? 'has-error' : '' !!}">
                <label class="control-label" for="title"> Google Analytics Code</label>

                <div class="controls">
                    {!! Form::text('ga_code', ($setting['ga_code']) ?: null, array('class'=>'form-control', 'id' => 'ga_code', 'placeholder'=>' Google Analytics Code', 'value'=>Input::old('ga_code'))) !!}
                    @if ($errors->first('ga_code'))
                    <span class="help-block">{!! $errors->first('ga_code') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Meta Keywords -->
            <div class="control-group {!! $errors->has('meta_keywords') ? 'has-error' : '' !!}">
                <label class="control-label" for="title">Meta Keywords</label>

                <div class="controls">
                    {!! Form::text('meta_keywords', ($setting['meta_keywords']) ?: null, array('class'=>'form-control', 'id' => 'meta_keywords', 'placeholder'=>'Meta Keywords', 'value'=>Input::old('meta_keywords'))) !!}
                    @if ($errors->first('meta_keywords'))
                    <span class="help-block">{!! $errors->first('meta_keywords') !!}</span>
                    @endif
                </div>
            </div>
            <br>
            <!-- Image -->
            <div class="fileinput fileinput-new control-group {!! $errors->has('image') ? 'has-error' : '' !!}" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <img data-src="" {!! (($setting['path']) ? "src='".url($setting['path']).'/'.$setting['file_name']."'" : null) !!} alt="...">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                <div>
                    <div> <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                            {!! Form::file('image', null, array('class'=>'form-control', 'id' => 'image', 'placeholder'=>'Image', 'value'=>Input::old('image'))) !!}
                            @if ($errors->first('image')) <span class="help-block">{!! $errors->first('image') !!}</span> @endif </span> <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> </div>
                </div>
                <br>

            <!-- Meta Description -->
            <div class="control-group {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
                <label class="control-label" for="title">Meta Description</label>

                <div class="controls">
                    {!! Form::text('meta_description', ($setting['meta_description']) ?: null, array('class'=>'form-control', 'id' => 'meta_description', 'placeholder'=>'Meta Description', 'value'=>Input::old('meta_description'))) !!}
                    @if ($errors->first('meta_description'))
                    <span class="help-block">{!! $errors->first('meta_description') !!}</span>
                    @endif
                </div>
            </div>
            <br>
            {!! Form::submit('Save Changes', array('class' => 'btn btn-success')) !!}
            {!! Form::close() !!}
        </div>
        <div class="tab-pane" id="info">
            <br>
            <h4><i class="glyphicon glyphicon-info-sign"></i> Info</h4>
            <br>
            Lorem profile dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate.
            <p>Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero. Aenean sit amet felis
                dolor, in sagittis nisi. Sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan.
                Aliquam in felis sit amet augue.</p>
        </div>
    </div>
</div>
@stop