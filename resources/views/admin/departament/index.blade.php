@extends('dashboard')
@section('title', 'Consulta')
@section('viewName', "Departamento")
@section('viewMessage', 'Bienvenidos, consulta de departamento')
@section("importForm")
<div class="card">
    <div class="card-header">
        <h5>Importar</h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                    <li><i class="fa fa-window-maximize full-card"></i></li>
                    <li><i class="fa fa-minus minimize-card"></i></li>
                    <li><i class="fa fa-refresh reload-card"></i></li>
                    <li><i class="fa fa-trash close-card"></i></li>
                </ul>
            </div>
    </div>
    <div class="card-block">
        <form enctype="multipart/form-data" method="POST" action="departament/upload">
            @csrf
            <div id="main">
                <div class="upload-file">
                    <label class="btn waves-effect waves-light btn-primary  btn-outline-primary">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        Seleccionar Archivo
                        <input id="test" type="file"  name='cvs_file' style="display: none"  accept=".csv"/>
                    </label>
                    
                </div>
                <pre id="info" class="text-primary">
                    @error('cvs_file')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                    @enderror
                </pre>
            </div>
            <button style="display:none;" type="submit" id="btn-import" class="btn waves-effect waves-light btn-primary"><i class="icofont icofont-upload"></i>Importar</button>
        </form>
    </div>                                            
</div>
@endsection
@section('cardContent')
<div class="table-responsive">
   <div class="row container">
        <div class="col-3"> 
            <div class="mb-3">
            <a class="btn waves-effect waves-light btn-primary btn-outline-primary " href="{{ route('departament.create') }}"><i class="ti-plus"></i>Agregar</a>
            </div>
        </div>
        <div class="col-9">
            <form enctype="multipart/form-data" method="POST" >
                @csrf
            </form>
        </div>
   </div>
    <table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Acción</th>   
        </tr>
    </thead>
        <tbody>
            @foreach($departaments as $departament)
                <tr>
                    <th scope="row">{{$departament->id}}</th>
                    <td>{{$departament->departamentName}}</td>
                    <td>
                    <form  class="form-material form-delete"  action="{{ route('departament.destroy', $departament->id)}}", method="POST">
                            <a class="btn waves-effect waves-light btn-danger" href="{{ route('departament.edit', $departament->id)}}"><i class="icofont icofont-pencil-alt-1"></i></a>
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn waves-effect waves-light btn-success"><i class="icofont icofont-trash"></i></button>
                    </form>
                    
                    </td>
                </tr>  
            @endforeach 
        </tbody>
    </table>
</div>
{{-- Pagination --}}
<div class="d-flex justify-content-center">
    {!! $departaments->links() !!}
</div>
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
        showSuccessAlert("Importe", "Se ha importado correctamente");
    </script>
@elseif(session("INSERT") == "IS_OK")
    <script>
        showSuccessAlert("Creado", "se ha creado un nuevo registro");
    </script>
@endif
<script type="text/javascript" src="{{ asset('js/custom/upload.js') }}"></script>
@endsection

