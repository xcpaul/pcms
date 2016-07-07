<!--header-->
<div id="header">
    <div class="container">
        <a  href="{!! url('/' . getLang()) !!}"><img src="{!! url('frontend/images/logo.png') !!}" alt="logo"></a>
    </div>
</div>
<!--/header-->
<!--menu-->
<div id="menu">
    <div class="container">
        <div class="menu-wrapper">
            {!! $menus !!}
        </div>
    </div>
</div>
<!--/menu-->
