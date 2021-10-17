<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <div class="mobile-search waves-effect waves-light">
                <div class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                            <input type="text" class="form-control" placeholder="Enter Keyword">
                            <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="text-light">
                <i class="ti-world"> </i> SOLA
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="ti-more"></i>
            </a>

        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                @role('ADMIN')
                <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                </li>
                <li class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                        </div>
                    </div>
                </li>

                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
                <li>
                    <a href="#exampleModal" data-toggle="modal" data-target="#exampleModal"
                        class="waves-effect waves-light">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </a>
                </li>
                <li>
                    <a href="#credential-info" data-toggle="modal" data-target="#credential-info"
                        class="waves-effect waves-light">
                        <i class="fa fa-id-card-o" aria-hidden="true"></i>
                    </a>
                </li>
                @else
                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
                @endrole
            </ul>
            <ul class="nav-right">

                <li class="user-profile header-notification">
                    <a href="#!" class="waves-effect waves-light">
                        <!--<img src="{{ asset('images/avatar-4.jpg')}}" class="img-radius" alt="User-Profile-Image">-->
                        <span>{{ Auth::user()->name }}</span>
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                        <li class="waves-effect waves-light">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="ti-layout-sidebar-left"></i>
                                {{ __('Cerrar Sessión') }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>