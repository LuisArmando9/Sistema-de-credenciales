@extends('dashboard')
@section('title', 'Actualización')
@section('viewName', "Razon Social")
@section('viewMessage', 'Bienvenidos a la actualización de RZ')
@section('cardContent')
<div  class="container">
    
    <form class="form-material" method="POST" action="/denomination/{{$denomination->id}}">
        @csrf
        @method("PUT")
        <div class="form-group @error('denominationName') form-danger @else form-primary @enderror ">
        <input type="text" name="denominationName" class="form-control" value=" @error('denominationName') {{ old('denominationName') }} @else {{$denomination->denominationName}} @enderror"    required >
            <span class="form-bar"></span>
            <label class="float-label">Razón social</label>
            @error('denominationName')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="subtmit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Actualizar</button>
            </div>
        </div>
    </form>
</div>
@endsection

