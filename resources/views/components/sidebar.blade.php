<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">

                <div class="user-details">
                    <span id="more-details">{{ Auth::user()->name }}<i class="fa fa-caret-down"></i></span>
                </div>
            </div>

            <div class="main-menu-content">
                <ul>
                    <li class="more-details">

                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="ti-layout-sidebar-left"></i>
                            {{ __('Cerrar Sessión') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @role("ADMIN")
        <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Empleados</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{active('toallera') }}">
                <a href="{{ route('toallera.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-user"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Toallera</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ active('tintura') }}">
                <a href="{{ route('tintura.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-user"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Tintura</span>

                </a>

            </li>
        </ul>
        <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Departamentos</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ active('departament') }}">
                <a href="{{ route('departament.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-briefcase"></i><b>FC</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Departamento</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>


        </ul>
        <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Denominación</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ active('denomination') }}">
                <a href="{{ route('denomination.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-ticket"></i><b>FC</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Razón Social</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>

        <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Cuentas</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ active('user') }}">
                <a href="{{ route('useradmin.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-user"></i><b>FC</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Usuarios</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <ul class="pcoded-item pcoded-left-item">
            <li>
                <a href="#" class="waves-effect waves-dark">
                    <form method="POST" action="/resetall">
                        @csrf
                        <button type="submit"
                            class="btn waves-effect waves-light btn-primary btn-outline-primary ">RESETEAR
                            TABLAS</button>
                    </form>
                </a>
            </li>
        </ul>
        @else
        <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Datos</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="index.html" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-user"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Visualizar</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-pencil"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Modificar</span>
                </a>

            </li>
        </ul>
        @endrole
    </div>
</nav>