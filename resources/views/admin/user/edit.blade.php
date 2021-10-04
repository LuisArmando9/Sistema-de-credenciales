@extends('dashboard')
@section('title', 'Actualización')
@section('viewName', "Usuarios")
@section('viewMessage', 'Bienvenidos, actualización  de usuarios')
@section('cardContent')
<div  class="container">
    <form class="md-float-material form-material"  method="POST" action="{{ route('useradmin.update', $user->id) }}">
        @csrf
        @method("PUT")
        <div class="">
            <div class="card-block">
                <div class="row m-b-20">
                    <div class="col-md-12">
                        <h5 class="text-center txt-primary">Crear nuevo usuario</h5>
                    </div>
                </div>
                <div class="form-group form-primary">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="@error('name') {{ old('name') }} @else {{$user->name}} @enderror" required autocomplete="name" autofocus>
                        <span class="form-bar"></span>
                        <label class="float-label">Nombre</label>
                        @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                </div>
                <div class="form-group form-primary">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@error('email') {{ old('email') }} @else {{$user->email}} @enderror"  autocomplete="email">
                        <span class="form-bar"></span>
                        <label class="float-label">Correo electronico</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                </div>
                <div class="form-group form-primary">
                    <select name="typeUser" class="form-control">
                        <option  disabled selected>Tipo de usuario</option>
                        <option value="ADMIN">Administrador</option>
                        <option value="USER">Usuario</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                            <div class="form-group form-primary">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">
                                <span class="form-bar"></span>
                                <label class="float-label">Contraseña</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                            <div class="form-group form-primary">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                                <span class="form-bar"></span>
                                <label class="float-label">Confirmar contraseña</label>
                        </div>
                    </div>
                </div>
                <div class="row m-t-30">
                    <div class="col-md-12">
                        <button type="submit"  class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Registrar</button>
                    </div>
                </div>
                <hr/>     
            </div>
        </div>
    </form>
</div>
@endsection
