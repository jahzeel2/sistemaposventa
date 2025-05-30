@extends('layouts.admin')
@section('contenido')
<!--section><br>
    <div class="card">
        <div class="card-header">
            Caja
        </div>
        <div class="card-body">
            <button class="btncolor" id="btncorte">Corte de caja</button>
        </div>
    </div>
</section-->
<br> 
<section id="datos_apertura">
  <div class="card card-custom card-stretch gutter-b">
    <div class="card-header">
      Apertuta de cajas del dia 
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="table_corte_dia" class="table table-bordered table-hover">
          <thead class="">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Usuario</th>
              <th scope="col">cantidad</th>
              <th scope="col">fecha apertura</th>
              <th scope="col">estatus</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</section>
<!--Show modal corte de caja-->
<!-- Modal -->
<div class="modal fade" id="ModalCorte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <div class="text-center" style="width: 20rem;">
          <h5><strong>Realizar corte de caja</strong></h5> 
        </div>
      </div>
      <div class="modal-body">
        {!!Form::open(['id'=>'save_form_corte_caja'])!!}
        <input type="number" name="numapertura" id="numapertura" min="0" step="0.00" onkeypress="return filterFloatdecimal2(event,this);" hidden="true">
        <div class="input-group input-group-lg">
          <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fas fa-dollar-sign"></i></span>
          <input type="number" name="cash" class="form-control" aria-label="Sizing example input" placeholder="0.00" min="0" step="0.00" aria-describedby="inputGroup-sizing-lg" onkeypress="return filterFloatdecimal2(event,this);">
        </div>
      </div>
      <div id="messageform"></div>
      <div class="modal-footer">
        <div class="container">
          <div class="row">
              <div class="col-md-6 text-center">
                  <button type="button" class="btn btn-secondary text-left" id="close_box_curt" data-bs-dismiss="modal">Cerrar</button>
                  <!--button id="tick">Aceptar</button-->
              </div>
              <div class="col-md-6 text-center">
                  <button type="button"  id="btn_save_box_curt" class="btn btn-primary">Aceptar</button>
              </div>
          </div>
        {!!Form::close()!!}
        </div>
        <!--div class="top-left">
        </div-->
      </div>
    </div>
  </div>
</div>

<!--Show modal caja-->
<div class="modal fade" id="detalle-corte-Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="exampleModalLabel">Detalle del corte del cajero</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-sm table-bordered">
          <tbody>
            <tr class="text-center">
              <td colspan="2"><strong id="name_empresa">{{$name}}</strong></td>
            </tr>
            <tr >
              <td>Fecha de operacion</td>
              <td id="date_operation" class="text-right">2021-08-29 16:12:49</td>
            </tr>
            <tr>
              <td>Nombre del cajero</td>
              <td id="name_cajero" class="text-right">roger code</td>
            </tr>
            <tr class="text-center">
              <td colspan="2"><strong>Movimientos</strong></td>
            </tr>
            <tr>
              <td>Fondo de caja</td>
              <td id="fondo_caja" class="text-right">100.00</td>
            </tr>
            <tr>
              <td>Efectivo en caja</td>
              <td id="efectivo_caja" class="text-right">100.00</td>
            </tr>
            <tr>
              <td>Ventas en efectivo</td>
              <td id="sale_efectivo" class="text-right">150.00</td>
            </tr>
            <tr>
              <td>Faltante</td>
              <td id="faltante_caja" class="text-right">150.00</td>
            </tr>
            <tr>
              <td>Sobrante</td>
              <td id="sobrante_caja" class="text-right">190.00</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <form method="get" action="/ticketcorte">
          <input type="number" name="idaper" id="idaper" value="" hidden="true"/>
          <button type="submit" id="btn-download-corte-caja" class="btn btn-primary">Imprimir</button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('ScriptcorteCaja')
<script src="{{asset('js/funciones_caja/corte_caja.js')}}"></script> 
@endpush
@endsection
