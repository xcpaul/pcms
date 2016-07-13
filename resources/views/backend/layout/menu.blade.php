<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{!! gravatarUrl(Sentinel::getUser()->email) !!}" class="img-circle" alt="User Image" />

            </div>
            <div class="pull-left info">
                <p>{{ Sentinel::getUser()->first_name . ' ' . Sentinel::getUser()->last_name }}</p>

                <a href="#"><i class="fa fa-circle text-success"></i>{{trans('backend.online')}}</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{trans('backend.search')}}"/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="{{ setActive('admin') }}"><a href="{{ url(getLang() . '/admin') }}"> <i class="fa fa-dashboard"></i> <span>{{trans('backend.dashboard')}}</span>
                </a></li>
            <li class="{{ setActive('admin/menu*') }}"><a href="{{ url(getLang() . '/admin/menu') }}"> <i class="fa fa-bars"></i> <span>{{trans('backend.menu')}}</span> </a>
            </li>
            <li class="treeview {{ setActive(['admin/news*']) }}"><a href="#"> <i class="fa fa-th"></i> <span>{{trans('backend.news')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/news') }}"><i class="fa fa-calendar"></i> {{trans('backend.all_news')}}</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/news/create') }}"><i class="fa fa-plus-square"></i> {{trans('backend.add_news')}}</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ setActive('admin/page*') }}"><a href="#"> <i class="fa fa-bookmark"></i> <span>{{trans('backend.pages')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/page') }}"><i class="fa fa-folder"></i>{{trans('backend.all_pages')}}</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/page/create') }}"><i class="fa fa-plus-square"></i>{{trans('backend.add_pages')}}</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ setActive(['admin/photo-gallery*', 'admin/video*']) }}"><a href="#"> <i class="fa fa-picture-o"></i> <span>{{trans('backend.galleries')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ url(getLang() . '/admin/photo-gallery') }}"><i class="fa fa-camera"></i>{{trans('backend.photo_galleries')}}</a>
                    </li>
                    <li>
                        <a href="{{ url(getLang() . '/admin/video') }}"><i class="fa fa-play-circle-o"></i>{{trans('backend.video_galleries')}}</a>
                    </li>

                </ul>
            </li>
            <li class="treeview {{ setActive(['admin/article*','admin/category*']) }}"><a href="#"> <i class="fa fa-book"></i> <span>{{trans('backend.articles')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/article') }}"><i class="fa fa-archive"></i>{{trans('backend.all_articles')}}</a>
                    </li>
                    <li>
                        <a href="{{ url(getLang() . '/admin/article/create') }}"><i class="fa fa-plus-square"></i>{{trans('backend.add_articles')}}</a>
                    </li>
                        <li><a href="{{ url(getLang() . '/admin/category') }}"><i class="fa fa-plus-square"></i> {{trans('backend.category')}}</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ setActive('admin/slider*') }}"><a href="#"> <i class="fa fa-tint"></i> <span>{{trans('backend.plugins')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/slider') }}"><i class="fa fa-toggle-up"></i>{{trans('backend.sliders')}}</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ setActive('admin/project*') }}"><a href="#"> <i class="fa fa-gears"></i> <span>{{trans('backend.projects')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/project') }}"><i class="fa fa-gear"></i>{{trans('backend.all_projects')}}</a>
                    </li>
                    <li>
                        <a href="{{ url(getLang() . '/admin/project/create') }}"><i class="fa fa-plus-square"></i>{{trans('backend.add_projects')}}</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ setActive('admin/faq*') }}"><a href="#"> <i class="fa fa-question"></i> <span>{{trans('backend.faqs')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/faq') }}"><i class="fa fa-question-circle"></i>{{trans('backend.all_faq')}}</a></li>
                    <li>
                        <a href="{{ url(getLang() . '/admin/faq/create') }}"><i class="fa fa-plus-square"></i>{{trans('backend.add_faq')}}</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ setActive(['admin/user*', 'admin/group*']) }}"><a href="#"> <i class="fa fa-user"></i> <span>{{trans('backend.users')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(getLang() . '/admin/user') }}"><i class="fa fa-user"></i>{{trans('backend.all_users')}}</a>
                    </li>
                    <li><a href="{{ url(getLang() . '/admin/role') }}"><i class="fa fa-group"></i>{{trans('backend.add_role')}}</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ setActive(['admin/logs*', 'admin/form-post']) }}"><a href="#"> <i class="fa fa-thumb-tack"></i> <span>{{trans('backend.records')}}</span>
                    <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a target="_blank" href="{{ url(getLang() . '/admin/logs') }}"><i class="fa fa-save"></i>{{trans('backend.log')}}</a></li>
                    <li>
                        <a href="{{ url(getLang() . '/admin/form-post') }}"><i class="fa fa-envelope"></i>{{trans('backend.form_post')}}</a>
                    </li>
                </ul>
            </li>
            <li class="{{ setActive('admin/settings*') }}">
                <a href="{{ url(getLang() . '/admin/settings') }}"> <i class="fa fa-gear"></i> <span>{{trans('backend.settings')}}</span> </a>
            </li>
            <li class="{{ setActive('admin/logout*') }}">
                <a href="{{ url('/admin/logout') }}"> <i class="fa fa-sign-out"></i> <span>{{trans('backend.logout')}}</span> </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>