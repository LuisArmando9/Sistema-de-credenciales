@extends('dashboard')
@section('title', 'Consulta')
@section('viewName', "Tintura")
@section('viewMessage', 'Bienvenidos a la consulta de empleados de tintura')
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
        <form enctype="multipart/form-data" method="POST" action="tintura/upload">
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

 <worker-table denomination="TINTURA"></worker-table>
@endsection

@section("customScripts")
<script type="text/javascript" src="{{ asset('js/custom/alert.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom/upload.js') }}"></script>
@endsection