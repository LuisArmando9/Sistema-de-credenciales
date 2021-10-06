@extends('layouts.app')
@section('content')
<div id="pcoded" class="pcoded">
      <div class="pcoded-overlay-box"></div>
      <div class="pcoded-container navbar-wrapper">
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
                        <i class="ti-world" > </i> SOLA
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
                                <a href="#exampleModal" data-toggle="modal" data-target="#exampleModal"  class="waves-effect waves-light">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                </a>
                            </li>
        
                        @else
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>
 .
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
                                      <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
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
         

          <div class="pcoded-main-container">
              <div class="pcoded-wrapper">
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
                             
                                      <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
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
                                            <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Tintura</span>
                                            
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
                                    <li >
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-pencil"></i></span>
                                            <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Modificar</span>  
                                        </a>
                                        
                                    </li>
                                </ul>
                          @endrole

                          
                      </div>
                  </nav>
                  <div class="pcoded-content">
                      <!-- Page-header start -->
                      <div class="page-header">
                          <div class="page-block">
                              <div class="row align-items-center">
                                  <div class="col-md-8">
                                      <div class="page-header-title">
                                          <h5 class="m-b-10">@yield('viewName')</h5>
                                          <p class="m-b-0">@yield('viewMessage')</p>
                                      </div>
                                  </div>
                                  
                                  <div class="col-md-4">
                                      <ul class="breadcrumb-title">
                                          <li class="breadcrumb-item">
                                              <a href="index.html"> <i class="fa fa-home"></i> </a>
                                          </li>
                                          <li class="breadcrumb-item"><a href="#!">@yield('viewName')</a>
                                          </li>
                                          

                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <!-- Basic table card start -->
                                        @role("ADMIN")
                                            @yield("importForm")
                                        @endrole
                                        <!-- Basic table card end -->
                                         <!-- Basic table card start -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>@yield('viewName')</h5>
                                                <div class="card-header-right">
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                   
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-block">
                                                @yield("cardContent")
                                                <br></br>    
                                            </div>
                                        </div>
                                        <!-- Basic table card end -->
                                        
                                       
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
</form>
@role("ADMIN")
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Credenciales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="md-float-material form-material" id="pdfForm"  method="POST" action="{{ route('Pdf.store') }}">
            @csrf
            <div class="text-center">
                <h1 class="text-primary"><i class="fa fa-print" > </i></h1>
            </div>
            <div class="">
                <div class="card-block">
                    <div class="row m-b-20">
                        <div class="col-md-12">
                            
                        </div>
                    </div>
                    <div class="row m-t-25 text-left">
                        <div class="container">
                            <p>Tipo de impresión de los credencialas: <b>uno o personalizado(Ej. 513 - 530).</b></p>
                        </div>
                        <div class="col-md-12">
                      
                            <select name="typePage" id="typePage" class="form-control" required>
                                
                                <option  value="ONE" selected>Uno</option>
                                <option   value="CUSTOM">Personalizados</option>
                            </select>
                        </div>
                        @error("typePage")
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <br><br>
                    <div class="row">
                    <div class="container">
                        <p>
                            Los rangos para imprimir las credenciales, mediante los folios: <b>Minimo: 10 y Máximo: 50</b>.   
                        </p>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-primary">
                                <input  type="number" class="form-control" name="minRange" value="{{old('minRange')}}" required>
                                <span class="form-bar"></span>
                                <label class="float-label minRangeText">Número de folio</label>
                            </div>
                            @error("minRange")
                                <p  class="text-danger">
                                   {{ $message }}
                                </p>
                            @enderror
                         
                        </div>
                        <div class="col-sm-6" id="maxRange" style="display: none;">
                            <div class="form-group form-primary">
                                <input  type="number" class="form-control" name="maxRange" value="{{old('maxRange')}}" required>
                                <span class="form-bar"></span>
                                <label class="float-label">Máximo</label>
                            </div>
                            @error("maxRange")
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                            
                        </div>
                    </div>
                    <div class="row m-t-25 text-left">
                        <div class="col-md-12">
                            <select name="denomination" class="form-control" required>
                                <option  disabled selected>Razón Social</option>
                                <option  value="TINTURA">Tintura</option>
                                <option   value="TOALLERA">Toallera</option>
                            </select>
                        </div>
                       <div class="container">
                            @error("denomination")
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror

                       </div>
                    </div>
                   
                    <div class="row m-t-30">
                        <div class="col-md-12">
                            <button type="submit"  class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Imprimir</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">   
      </div>
    </div>
  </div>
</div>
@endrole

@endsection

@section("viewModalScript")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="{{ asset('js/custom/credential.js') }}" ></script>
    @error("error_input")
        <script>
            $("#exampleModal").modal("show")
        </script>
    @enderror
    @if(session("PRINT_FAIL") == "IS_OK")
      <script>alert("Solo se pueden imprimir 50 credenciales por pdf")</script>
    @endif
@endsection


