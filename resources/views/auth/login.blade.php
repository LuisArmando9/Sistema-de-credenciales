@extends('layouts.app')
@section('title', "Login")
@section('theme', 'themebg-pattern=theme1')
@section('content')
<section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    
                        <form class="md-float-material form-material"  method="POST" action="{{ route('login') }}">
                           @csrf
                            <div class="text-center">
                                <h1 class="text-light"><i class="ti-world" > </i> SOLA</h1>
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Iniciar Sessión</h3>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        <span class="form-bar"></span>
                                        <label class="float-label">Correo electronico</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="password"  class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Contraseña</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row m-t-25 text-left">
                                        <div class="col-12">
                                            <div class="checkbox-fade fade-in-primary d-">
                                                <label>
                                                    <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span class="text-inverse">Recordarme</span>
                                                </label>
                                            </div>
                                            <div class="forgot-phone text-right f-right">
                                            @if (Route::has('password.request'))
                                                <a class="text-right f-w-600" href="{{ route('password.request') }}">
                                                    {{ __('¿Olvidate tu contraseña?') }}
                                                </a>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button  type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Iniciar sesión</button>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-10">
                                           <ins><h2> <a href="{{ route('register') }}">REGISTRO</a></h2></ins>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                        <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>

@endsection
