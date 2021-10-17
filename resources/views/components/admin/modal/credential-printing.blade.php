<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Credenciales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="md-float-material form-material" id="pdfForm"  method="POST" action="{{ route('Pdf.store') }}">
            @csrf
            <div class="text-center">
                <h1 class="text-primary"><i class="fa fa-print" > </i></h1>
            </div>
            <div class="">
                <div class="card-block">
                    <div class="row m-b-20">
                        <div class="col-md-12">
                            
                        </div>
                    </div>
                    <div class="row m-t-25 text-left">
                        <div class="container">
                            <p>Tipo de impresión de los credencialas: <b>uno o personalizado(Ej. 513 - 530).</b></p>
                        </div>
                        <div class="col-md-12">
                      
                            <select name="typePage" id="typePage" class="form-control" required>
                                
                                <option  value="ONE" selected>Uno</option>
                                <option   value="CUSTOM">Personalizados</option>
                            </select>
                        </div>
                        @error("typePage")
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <br><br>
                    <div class="row">
                    <div class="container">
                        <p>
                            Los rangos para imprimir las credenciales, mediante los folios: <b>Minimo: 10 y Máximo: 50</b>.   
                        </p>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-primary">
                                <input  type="number" class="form-control" name="minRange" value="{{old('minRange')}}" required>
                                <span class="form-bar"></span>
                                <label class="float-label minRangeText">Número de folio</label>
                            </div>
                            @error("minRange")
                                <p  class="text-danger">
                                   {{ $message }}
                                </p>
                            @enderror
                         
                        </div>
                        <div class="col-sm-6" id="maxRange" style="display: none;">
                            <div class="form-group form-primary">
                                <input  type="number" class="form-control" name="maxRange" value="{{old('maxRange')}}" required>
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
                                <option  disabled selected>Razón Social</option>
                                <option  value="TINTURA">Tintura</option>
                                <option   value="TOALLERA">Toallera</option>
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
                            <button type="submit"  class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Imprimir</button>
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