<div class="modal fade" id="print-credentials" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Credenciales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <div class="col-lg-12 col-xl-12">
                        <div class="sub-title">Modos para impresion de credenciales</div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#home3" role="tab"
                                    aria-expanded="false">RANGOS</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#profile3" role="tab"
                                    aria-expanded="true">TODOS</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#messages3" role="tab"
                                    aria-expanded="false">POR DEPARTAMENTO</a>
                                <div class="slide"></div>
                            </li>

                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content card-block mt-2">
                            <div class="tab-pane" id="home3" role="tabpanel" aria-expanded="false">
                                <!------------------form by ranges------------------->
                                <form class="md-float-material form-material" id="pdfForm" method="POST"
                                    action="{{ route('Pdf.store') }}">
                                    @csrf
                                    <div class="text-center">
                                        <h1 class="text-primary"><i class="fa fa-print"> </i></h1>
                                    </div>
                                    <div class="">
                                        <div class="card-block">
                                            <div class="row m-b-20">
                                                <div class="col-md-12">

                                                </div>
                                            </div>
                                            <div class="row m-t-25 text-left">
                                                <div class="container">
                                                    <p>Tipo de impresiónes personalizadas(Ej. 513 - 530).</b></p>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                                <div class="container">
                                                    <p>
                                                        El rango máximo de credenciales son <b>50</b>.
                                                    </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-primary">
                                                        <input type="number" class="form-control" name="minRange"
                                                            value="{{old('minRange')}}" required>
                                                        <span class="form-bar"></span>
                                                        <label class="float-label minRangeText">Minimo</label>
                                                    </div>
                                                    @error("minRange")
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror

                                                </div>
                                                <div class="col-sm-6" id="maxRange">
                                                    <div class="form-group form-primary">
                                                        <input type="number" class="form-control" name="maxRange"
                                                            value="{{old('maxRange')}}" required>
                                                        <span class="form-bar"></span>
                                                        <label class="float-label">Máximo</label>
                                                    </div>
                                                    @error("maxRange")
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="row m-t-25 text-left">
                                                <div class="col-md-12">
                                                    <select name="denomination" class="form-control" required>
                                                        <option disabled selected>Razón Social</option>
                                                        <option value="TINTURA">Tintura</option>
                                                        <option value="TOALLERA">Toallera</option>
                                                    </select>
                                                </div>
                                                <div class="container">
                                                    @error("denomination")
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="row m-t-30">
                                                <div class="col-md-12">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Imprimir</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!------------------end------------------->
                            </div>
                            <div class="tab-pane active" id="profile3" role="tabpanel" aria-expanded="true">
                                <!------------------form by all------------------->
                                <form class="md-float-material form-material" id="pdfForm" method="POST"
                                    action="{{ route('Pdf.store') }}">
                                    @csrf
                                    <div class="text-center">
                                        <h1 class="text-primary"><i class="fa fa-print"> </i></h1>
                                    </div>
                                    <div class="">
                                        <div class="card-block">
                                            <div class="row m-b-20">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="type" value="ALL">
                                                </div>
                                            </div>
                                            <div class="row m-t-25 text-left">
                                                <div class="container">
                                                    <p>Elige cualquier de las razones sociales para imprimir todos</b>
                                                    </p>
                                                </div>
                                            </div>
                                            <br><br>

                                            <div class="row m-t-25 text-left">
                                                <div class="col-md-12">
                                                    <select name="denomination" class="form-control" required>
                                                        <option disabled selected>Razón Social</option>
                                                        <option value="TINTURA">Tintura</option>
                                                        <option value="TOALLERA">Toallera</option>
                                                    </select>
                                                </div>
                                                <div class="container">
                                                    @error("denomination")
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="row m-t-30">
                                                <div class="col-md-12">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Imprimir</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                 <!------------------end------------------->
                            </div>
                            <div class="tab-pane" id="messages3" role="tabpanel" aria-expanded="false">
                                <!------------------form by departament------------------->
                                <form class="md-float-material form-material" id="pdfForm" method="POST"
                                    action="{{ route('Pdf.store') }}">
                                    @csrf
                                    <div class="text-center">
                                        <h1 class="text-primary"><i class="fa fa-print"> </i></h1>
                                    </div>
                                    <div class="">
                                        <div class="card-block">
                                            <div class="row m-b-20">
                                                <div class="col-md-12">

                                                </div>
                                            </div>
                                            <div class="row m-t-25 text-left">
                                                <div class="container">
                                                    <p>Elige cualquier  razon social y departamento para imprimir</b>
                                                    </p>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row m-t-25 text-left">
                                                <div class="col-md-12">
                                                    <select name="departament" class="form-control" required>
                                                        <option disabled selected>Departamento</option>
                                                        @foreach($departaments as $departament)
                                                            <option value="{{$departament->id}}">{{$departament->departamentName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="container">
                                                    @error("departament")
                                                    <p class="text-danger">
                                                        El departamento ingresado esta vació
                                                    </p>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="row m-t-25 text-left">
                                                <div class="col-md-12">
                                                    <select name="denomination" class="form-control" required>
                                                        <option disabled selected>Razón Social</option>
                                                        <option value="TINTURA">Tintura</option>
                                                        <option value="TOALLERA">Toallera</option>
                                                    </select>
                                                </div>
                                                <div class="container">
                                                    @error("denomination")
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="row m-t-30">
                                                <div class="col-md-12">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Imprimir</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!------------------end------------------->
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
</div>
</div>