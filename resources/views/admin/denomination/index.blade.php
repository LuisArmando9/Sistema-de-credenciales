@extends('dashboard')
@section('title', 'Consulta')
@section('viewName', "Razon Social")
@section('viewMessage', 'Bienvenidos a la consulta de RZ')

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
        <form enctype="multipart/form-data" method="POST" action="denomination/upload">
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
  
   <div class="container row">
        <div class="col-2"> 
            <div class="mb-3">
            <a class="btn waves-effect waves-light btn-primary btn-outline-primary " href="{{ route('denomination.create') }}"><i class="ti-plus"></i>Agregar</a>
            </div>
        </div>
        <div class="col-9">
            <form method="POST" action="/resetdenomination" >
                @csrf
                <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary ">RESETEAR</button>
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
                @foreach($denominations as $denomination)
                    <tr>
                        <th scope="row">{{$denomination->id}}</th>
                        <td>{{$denomination->denominationName}}</td>
                        <td>
                           <form  class="form-material form-delete"  action="{{ route('denomination.destroy', $denomination->id)}}", method="POST">
                                <a class="btn waves-effect waves-light btn-danger" href="{{ route('denomination.edit', $denomination->id)}}"><i class="icofont icofont-pencil-alt-1"></i></a>
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
@endsection
@section("customScripts")
<script type="text/javascript" src="{{ asset('js/custom/alert.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/custom/upload.js') }}"></script>
@endsection

