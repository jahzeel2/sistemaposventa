@extends('layouts.admin')
@section('contenido')
<br>
<section id="datos_apertura">
  <div class="card card-custom card-stretch gutter-b">
    <div class="card-header">
      Corte parcial para el cajero en turno
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="parcial_table" class="table table-bordered table-hover">
          <thead class="">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Usuario</th>
              <th scope="col">cantidad acomulada en caja</th>
              <th scope="col">fecha apertura</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</section>
<!--Modal para el corte parcial-->
<div class="modal fade" id="ModalCorteParcial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <div class="text-center" style="width: 20rem;">
          <h5><strong>Realizar corte de caja parcial</strong></h5> 
        </div>
      </div>
      <div class="modal-body">
        {!!Form::open(['id'=>'save_form_parcial'])!!}
        <input type="number" name="numparcial" id="numparcial" min="0" step="0.00" onkeypress="return filterFloatdecimal2(event,this);" hidden="true">
        <div class="input-group input-group-lg">
          <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fas fa-dollar-sign"></i></span>
          <input type="number" name="cashcorte" id="cashcorte" class="form-control" aria-label="Sizing example input" placeholder="0.00" min="0" step="0.00" aria-describedby="inputGroup-sizing-lg" onkeypress="return filterFloatdecimal2(event,this);">
        </div>
      </div>
      <div id="messageformparcial"></div>
      <div class="modal-footer">
        <div class="container">
          <div class="row">
              <div class="col-md-6 text-center">
                  <button type="button" class="btn btn-secondary text-left" id="closemodalparcial" data-bs-dismiss="modal">Cerrar</button>
              </div>
              <div class="col-md-6 text-center">
                  <button type="button"  id="btn_save_parcial" class="btn btn-primary">Aceptar</button>
              </div>
          </div>
        {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
</div>

@push('ScriptCortteParcialCajero')
<script src="{{asset('js/funciones_caja/corte_parcial_cajero.js')}}"></script>
@endpush
@endsection