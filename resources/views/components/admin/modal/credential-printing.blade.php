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
                 
                    <br><br>
                    <div class="row">
                    <div class="container">
                        
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-primary">
                                <input  type="text" class="form-control" name="name" value="{{old('name')}}" required>
                                <span class="form-bar"></span>
                                <label class="float-label minRangeText">Nombre Completo</label>
                            </div>
                            @error("name")
                                <p  class="text-danger">
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