@extends('dashboard')
@section('title', 'Actualización')
@section('viewName', "Tintura")
@section('viewMessage', 'Bienvenido, actualización  del empleado de la tintura')
@section('cardContent')
<div  class="container">
    <form class="form-material" method="POST" action="{{ route('tintura.update', $worker->id) }}">
        @csrf
        @method("PUT")
        <div class="form-group @error('id') form-danger @else form-primary @enderror">
            <input type="text" name="id" class="form-control" value=" @error('id') {{ old('id') }} @else {{$worker->id}} @enderror"   required>
            <span class="form-bar"></span>
            <label class="float-label">Folio</label>
            @error('id')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="form-group @error('worker') form-danger @else form-primary @enderror">
            <input type="text" name="worker" class="form-control" value=" @error('worker') {{ old('worker') }} @else {{$worker->worker}} @enderror"   required>
            <span class="form-bar"></span>
            <label class="float-label">Nombre del trabajador</label>
            @error('worker')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="form-group @error('curp') form-danger @else form-primary @enderror">
            <input type="text" name="curp" class="form-control" value="@error('curp')  {{ old('curp') }} @else {{$worker->curp}} @enderror"   required>
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
                       @if($worker->departamentId == $departament->id)
                            <option value="{{$departament->id}}" selected>{{$departament->departamentName}}</option>
                       @else
                            <option value="{{$departament->id}}">{{$departament->departamentName}}</option>
                       @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Estatus</label>
            <div class="col-sm-8">
                <select name="active" class="form-control">
                    <option  disabled>Estatus</option>
                    @if($worker->active)
                        <option value="1" selected>{{('Activo')}}</option>
                        <option value="0" >{{('No activo')}}</option>
                    @else
                        <option value="1">{{('Activo')}}</option>
                        <option value="0" selected>{{('No activo')}}</option>
                    @endif

                </select>
            </div>
            @error('active')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="form-group @error('nss') form-danger @else form-primary @enderror">
            <input type="text" name="nss" class="form-control" value="@error('nss') {{old('nss')}} @else {{ trim($worker->nss)}}@enderror"   required>
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
                <input type="date" class="form-control"  name="entry" required=""  value="@error('entry'){{old('entry')}}@else{{$worker->entry}}@enderror" >  
                <span class="form-bar"></span>
            </div>
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Actualizar</button>
            </div>
        </div> 
    </form>
</div>
@endsection

