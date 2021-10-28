<div class="modal fade" id="credential-info" tabindex="-1" role="dialog" aria-labelledby="credential-info-label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="credential-info-label">INFORMACIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="md-float-material form-material" id="pdfForm" method="GET"
                    action="{{ route('credential.index') }}">
                    @csrf
                    <div class="text-center">
                        <h3>{{$credentialNumber}} <i class="fa fa-id-card-o" aria-hidden="true"></i> IMPRESAS</h3>
                    </div>
                    <div class="">
                        <div class="card-block">
                            <div class="row m-t-25 text-left">
                                <div class="container">
                                    <p>Puedes buscar cuantas credenciales se han impreso por trabajador</b></p>
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
                            <br><br>
                            <div class="row">
                                <div class="container">
                                </div>
                                <div class="col-sm-7">
                                    <div class="form-group form-primary">
                                        <input type="text" class="form-control" name="credential-search" value="{{old('search')}}"
                                            required >
                                        <span class="form-bar"></span>
                                        <label class="float-label">Nombre completo o folio</label>
                                    </div>
                                    @error("credential-search")
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror

                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group form-primary">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                          


                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>