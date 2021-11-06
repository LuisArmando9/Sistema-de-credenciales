@extends('dashboard')
@section('title', 'Consulta')
@section('viewName', $worker)
@section("importForm")
@endsection
@section('cardContent')
<div class="table-responsive">

    <div class="container row">
        @if($credentialIsFinded)
            <h5 class="text-center">NÚMERO DE CREDENCIALES IMPRESAS SON:  {{count($credentials)}} </h5>
            <br>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre del archivo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($credentials as $credential)
                        <tr>
                            <th scope="row">{{$credential->pdfName}}</th>
                            <td>{{$credential->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No se ha impreso, ninguna credencial de <b>{{$worker}}</b></p>
        @endif

    </div>
</div>

@endsection

@section("customScripts")
@error("credentialInfo")
<script>
$("#credential-info").modal("show")
</script>
@endif
@endsection
