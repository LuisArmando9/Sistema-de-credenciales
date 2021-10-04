@extends('dashboard')
@section('title', 'Error')
@section('viewName', "Registros vacios")
@section('viewMessage', 'Error, no contienes registros')
@section('cardContent')
<div class="table-responsive">
   <p >{{$MessageOfEmptyTable}}</p>
</div>
@endsection
