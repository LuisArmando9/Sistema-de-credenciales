@extends('dashboard')
@section('title', 'Actualizar')
@section('viewName', "Departamento")
@section('viewMessage', 'Bienvenidos a la actualización de un departamento')
@section('cardContent')
<div  class="container">
<div class="container">
    <form class="form-material" method="POST" action="{{route('departament.update', $departament->id)}}">
        @csrf
        @method("PUT")
        <div class="form-group @error('id') form-danger @else form-primary @enderror">
            <input type="number" name="id" class="form-control"  value="@error('id'){{old('id')}}@else{{$departament->id}}@enderror"     required>
            <span class="form-bar"></span>
            <label class="float-label">ID</label>
            @error('id')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="form-group @error('denominationName') form-danger @else form-primary @enderror">
            <input type="text" name="departamentName" class="form-control"  value=" @error('departamentName') {{ old('departamentName') }} @else {{$departament->departamentName}} @enderror"     required>
            <span class="form-bar"></span>
            <label class="float-label">Nombre del departamento</label>
            @error('departamentName')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
    
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Razón Social</label>
            <div class="col-sm-8">
                <select name="denominationId" class="form-control">
                    <option disabled>Selecciona una opción</option>
                    @foreach($denominations as $denomination)
                        <option value="{{$denomination->id}}">{{$denomination->denominationName}}</option>
                    @endforeach
                 
                </select>
            </div>
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Actualizar</button>
            </div>
        </div>  
    </form>
</div>
</div>
@endsection
