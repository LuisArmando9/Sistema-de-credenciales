@extends('dashboard')
@section('title', 'Consulta')
@section('viewName', "Toallera")
@section('viewMessage', 'Bienvenidos a la consulta de empleados de toallera')
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
        <form enctype="multipart/form-data" method="POST" action="toallera/upload">
            @csrf
            <div id="main">
                <div class="upload-file">
                    <label class="btn waves-effect waves-light btn-primary  btn-outline-primary">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        Seleccionar Archivo
                        <input id="test" type="file" name='cvs_file' style="display: none" accept=".csv" />
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
            <button style="display:none;" type="submit" id="btn-import"
                class="btn waves-effect waves-light btn-primary"><i class="icofont icofont-upload"></i>Importar</button>
        </form>
    </div>
</div>
@endsection
@section('cardContent')
<div class="table-responsive">
    <div class="container row">
        <div class="col-3">
            <div class="mb-3">
                <a class="btn waves-effect waves-light btn-primary btn-outline-primary "
                    href="{{ route('toallera.create') }}"><i class="ti-plus"></i>Agregar</a>
            </div>
        </div>
        <div class="col-9">
            <div class="row container">
                <div class="col-10">
                    <form method="GET" action="{{route('toallera.index')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" placeholder="Folio o Nombre"
                                        required>
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
                <div class="col-2">
                    <form method="POST" action="/resettoallera">
                        @csrf
                        <button type="submit"
                            class="btn waves-effect waves-light btn-primary btn-outline-primary ">RESETEAR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($workers->count() <= 0 ) @if(!$containsPaginate) <p>{{('No se encontró resultado.')}}</p>
        @endif
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tabajador</th>
                    <th>Estatus</th>
                    <th>NSS</th>
                    <th>credencial</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workers as $worker)
                <tr>
                    <th scope="row">{{$worker->id}}</th>
                    <td>{{$worker->worker}}</td>
                    @if($worker->active)
                    <td><span class="bg-info text-white p-2">{{('Activo')}}</span></td>
                    @else
                    <td><span class="bg-danger text-white p-2">{{('No activo')}}</span></td>
                    @endif
                    <td>{{$worker->nss}}</td>
                    <td>
                        <form class="form-material" action="{{ route('Pdf.store')}}" , method="POST">
                            @csrf
                            <input type="hidden" name="denomination" value="TOALLERA" />
                            <input type="hidden" name="name" value="{{$worker->id}}" />

                            <button type="submit" class="btn waves-effect waves-light btn-success"><i
                                    class="fa fa-credit-card-alt" aria-hidden="true"></i></button>
                        </form>
                    </td>
                    <td>
                        <form class="form-material form-delete" action="{{ route('toallera.destroy', $worker->id)}}" ,
                            method="POST">
                            <a class="btn waves-effect waves-light btn-danger"
                                href="{{ route('toallera.edit', $worker->id)}}"><i
                                    class="icofont icofont-pencil-alt-1"></i></a>
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn waves-effect waves-light btn-success"><i
                                    class="icofont icofont-trash"></i></button>
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
    {!! $workers->links() !!}
</div>
@endif
@endsection
@section("customScripts")
<script type="text/javascript" src="{{ asset('js/custom/alert.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom/upload.js') }}"></script>
@endsection