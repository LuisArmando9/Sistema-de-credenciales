@extends('dashboard')
@section('title', 'Crear')
@section('viewName', "toallera")
@section('viewMessage', 'Crear nuevo empleado de toallera')
@section('cardContent')
<div  class="container">
    <form class="form-material" method="POST" action="{{ route('toallera.store') }}">
        @csrf
        <div class="form-group @error('id') form-danger @else form-primary @enderror">
            <input type="text" name="id" class="form-control" value="{{ old('id') }}"   required>
            <span class="form-bar"></span>
            <label class="float-label">Folio</label>
            @error('id')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="form-group @error('worker') form-danger @else form-primary @enderror">
            <input type="text" name="worker" class="form-control" value="{{ old('worker') }}"   required>
            <span class="form-bar"></span>
            <label class="float-label">Nombre del trabajador</label>
            @error('worker')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="form-group @error('curp') form-danger @else form-primary @enderror">
            <input type="text" name="curp" class="form-control" value="{{ old('curp') }}"   required>
            <span class="form-bar"></span>
            <label class="float-label">Curp</label>
            @error('curp')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Departamento</label>
            <div class="col-sm-8">
                <select name="departamentId" class="form-control">
                    <option value="opt1" disabled>Select One Value Only</option>
                    @foreach($departaments as $departament )
                        <option value="{{$departament->id}}">{{$departament->departamentName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Estatus</label>
            <div class="col-sm-8">
                <select name="active" class="form-control">
                    <option  disabled>Estatus</option>
                    <option value="1">{{('Activo')}}</option>
                    <option value="0" selected>{{('No activo')}}</option>
                </select>
            </div>
            @error('active')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="form-group @error('nss') form-danger @else form-primary @enderror">
            <input type="text" name="nss" class="form-control" value="{{ old('nss') }}"   required>
            <span class="form-bar"></span>
            <label class="float-label">Nss</label>
            @error('nss')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="form-group form-primary row">
            <label class="col-sm-4 col-form-label">Fecha de Ingreso</label>
            <div class="col-sm-8">
                <input type="date" class="form-control"  name="entry" required="">
                <span class="form-bar"></span>
            </div>
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Crear</button>
            </div>
        </div> 
    </form>
</div>
@endsection

