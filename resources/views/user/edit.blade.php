@extends('dashboard')
@section('title', 'Actualización')
@section('viewName', "Usuarios")
@section('viewMessage', 'Bienvenidos, actualización  de usuarios')
@section('cardContent')
<div  class="container">
    <form class="form-material">
        <div class="form-group form-primary">
            <input type="text" name="footer-email" class="form-control" required="">
            <span class="form-bar"></span>
            <label class="float-label">Nombre completo</label>
        </div>
        <div class="form-group form-primary">
            <input type="email" name="footer-email" class="form-control" required="">
            <span class="form-bar"></span>
            <label class="float-label">Correo</label>
        </div>
        <div class="form-group form-primary">
            <input type="password" name="footer-email" class="form-control" required="">
            <span class="form-bar"></span>
            <label class="float-label">Contraseña</label>
        </div>
        <div class="form-group form-primary">
            <input type="password" name="footer-email" class="form-control" required="">
            <span class="form-bar"></span>
            <label class="float-label">Confirmar contraseña</label>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Tipo de Usuario</label>
            <div class="col-sm-8">
                <select name="select" class="form-control">
                    <option value="opt1">Administrador</option>
                    <option value="opt2">Estandar</option>
                </select>
            </div>
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Crear</button>
            </div>
        </div>   
    </form>
</div>
@endsection
