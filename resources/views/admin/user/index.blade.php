@extends('dashboard')
@section('title', 'Consulta')
@section('viewName', "Usuarios")
@section('viewMessage', 'Bienvenidos, consulta de usuarios')
@section('cardContent')
<div class="table-responsive">
    <div class="container row">
        <div class="col-3"> 
            <div class="mb-3">
            <a class="btn waves-effect waves-light btn-primary btn-outline-primary " href="{{ route('useradmin.create') }}"><i class="ti-plus"></i>Agregar</a>
            </div>
        </div>
        <div class="col-9">
            <form   method="GET" action="{{route('useradmin.index')}}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" name="search" class="form-control"    placeholder="Folio" required>
                            @error('search')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
   </div>
   @if($users->count() <= 0 )
        @if(!$containsPaginate)
            <p >{{('No se encontró resultado.')}}</p>
        @endif
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <form  class="form-material form-delete"  action="{{ route('useradmin.destroy', $user->id)}}", method="POST">
                                <a class="btn waves-effect waves-light btn-danger" href="{{ route('useradmin.edit', $user->id)}}"><i class="icofont icofont-pencil-alt-1"></i></a>
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn waves-effect waves-light btn-success"><i class="icofont icofont-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
{{-- Pagination --}}
@if($containsPaginate)
    <div class="d-flex justify-content-center">
    {!! $users->links() !!}
    </div>
@endif
@endsection

@section("customScripts")
<script type="text/javascript" src="{{ asset('js/custom/alert.js') }}"></script>
@if(session("DELETE") == "IS_OK")
    <script>
        showSuccessAlert("Eliminado", "se ha eliminado el registro");
    </script>
@elseif(session("DELETE_ERROR") == "IS_OK")
    <script>
      showSuccessAlert("Error", "No se puede eliminar <b>{{session('Name')}}</b>, debe eliminar las asociaciones.", "warning");
    </script>
@elseif(session("UPDATE") == "IS_OK")
    <script>
        showSuccessAlert("Actualizado", "se ha actualizado el registro");
    </script>
@elseif(session("UPLOAD_ERROR") == "IS_OK")
    <script>
        showSuccessAlert("Error", "{{session('message')}}", "warning");
    </script>
@elseif(session("UPLOAD_SUCCESS") == "IS_OK")
    <script>
        showSuccessAlert("Actualizado", "Se ha exportado correctamente");
    </script>
@elseif(session("INSERT") == "IS_OK")
    <script>
        showSuccessAlert("Creado", "se ha creado un nuevo registro");
    </script>
@endif
<script type="text/javascript" src="{{ asset('js/custom/upload.js') }}"></script>
@endsection


