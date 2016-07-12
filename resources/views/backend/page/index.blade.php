@extends('backend/layout/layout')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#notification').show().delay(4000).fadeOut(700);

            // publish settings
            $(".publish").bind("click", function (e) {
                var id = $(this).attr('id');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{!! url(getLang() . '/admin/page/" + id + "/toggle-publish/') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    success: function (response) {
                        if (response['result'] == 'success') {
                            var imagePath = (response['changed'] == 1) ? "{!!url('/')!!}/assets/images/publish.png" : "{!!url('/')!!}/assets/images/not_publish.png";
                            $("#publish-image-" + id).attr('src', imagePath);
                        }
                    },
                    error: function () {
                        alert("error");
                    }
                })
            });
        });
    </script>
    <section class="content-header">
        <h1> Page
            <small> | Control Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! URL::route('admin.dashboard') !!}">Dashboard</a></li>
            <li class="active">Page</li>
        </ol>
    </section>
    <br>
    <br>
    <div class="container">
        <div class="col-lg-10">
            @include('flash::message')
            <br>

            <div class="pull-left">
                <div class="btn-toolbar"><a href="{!! langRoute('admin.page.create') !!}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add Page </a></div>
            </div>
            <br> <br> <br>
            @if($pages->count())
                <div class="">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                            <th>Action</th>
                            <th>Settings</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $pages as $page )
                            <tr>
                                <td> {!! link_to_route(getLang(). '.admin.page.show', $page->title, $page->id, array(
                                    'class' => 'btn btn-link btn-xs' )) !!}
                                </td>
                                <td>{!! $page->created_at->format('d/m/Y') !!}</td>
                                <td>{!! $page->updated_at->format('d/m/Y') !!}</td>
                                <td>
                                        <a href="{!! langRoute('admin.page.show', array($page->id)) !!}">
                                            <span class="glyphicon glyphicon-eye-close"></span>
                                        </a>

                                        <a href="{!! langRoute('admin.page.edit', array($page->id)) !!}">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        @if($page->LanguageData->permanent===0)
                                            <a href="{!! URL::route('admin.page.delete', array($page->id)) !!}">
                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </a>
                                        @endif
                                        <a target="_blank" href="{!! URL::route('dashboard.page.show', ['id' => $page->id]) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </a>
                                </td>
                                <td>
                                    <a href="#" id="{!! $page->id !!}" class="publish"><img id="publish-image-{!! $page->id !!}" src="{!!url('/')!!}/assets/images/{!! ($page->is_published) ? 'publish.png' : 'not_publish.png'  !!}"/></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-danger">No results found</div>
            @endif
        </div>
        <div class="pull-left">
            <ul class="pagination">
                {!! $pages->render() !!}
            </ul>
        </div>
    </div>
@stop