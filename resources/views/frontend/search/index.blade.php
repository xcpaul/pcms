@extends('frontend/layout/layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Search</h1>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            @foreach( array_slice($paginator->toArray()['data'], (($paginator->toArray()['current_page']-1) * $paginator->toArray()['per_page']), $paginator->toArray()['per_page']) as $v )
            <div class="row">
                <div class="col-sm-12">
                    <a href="{!! url(langURL($v['url'])) !!}">
                        <h4>{!! $v['title'] !!}</h4>
                    </a>
                    <hr>
                </div>
                <div class="col-sm-12">
                    <p>{!! mb_substr(strip_tags($v['content']),0,400) !!}</p>
                    <br>
                    <a href="{!! url(langURL($v['url'])) !!}">{!! url($v['url']) !!}</a>
                </div>
            </div>
            <hr>
            @endforeach
        </div>
    </div>
     <div class="pull-left">
        <ul class="pagination">
            {!! $paginator->appends(array('search' => $q))->render() !!}
        </ul>
    </div>
</div>
@stop

