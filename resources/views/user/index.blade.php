@extends('dashboard')
@section('title', 'Consulta')
@section('viewName', $user->name)
@section('viewMessage', 'Bienvenidos, consulta de tus datos')
@section('cardContent')
<div class="table-responsive">
    <p>
        <b>Correo:</b> {{ $user->email}}
    </p>
    <p>
        <b>Nombre:</b> {{$user->name}}
    </p>
  
</div>
@endsection

