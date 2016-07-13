<!--header-->
<div id="header">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a  href="{!! url('/' . getLang()) !!}"><img src="{!! $settings['file_name']?url($settings['path'].$settings['file_name']):url('frontend/images/logo.png')!!}" alt="logo"></a>
            </div>
            <div class="col-md-4">
                <ul class="language_bar_chooser">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li>
                            <a rel="alternate" hreflang="{!!$localeCode!!}" href="{!! LaravelLocalization::getLocalizedURL($localeCode) !!}">
                                {!! $properties['native'] !!}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                @include('frontend/elements/search')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="social_icons">
                    <ul class="social clearfix">
                        <li><a href="#" title="" data-original-title="Facebook" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" title="" data-original-title="Google Plus" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" title="" data-original-title="Twitter" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" title="" data-original-title="Youtube" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#" title="" data-original-title="Linkedin" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#" title="" data-original-title="Dribbble" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#" title="" data-original-title="Skype" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-skype"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
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
