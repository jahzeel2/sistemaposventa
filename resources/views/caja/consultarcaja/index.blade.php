@extends('layouts.admin')
@section('contenido')
<br> 
<meta name="csrf-token" content="{{ csrf_token() }}">
<section id="datos_apertura">
  <div class="card">
    <div class="card-header">
      <h5>Consultar el historico de cajas</h5>
    </div>
    <div class="card-body">
      <form id="getdate" >
      <div class="container">
        <div class="row g-3">
          <div class="col-sm-5">
            <label for="dateOne" class="form-label">Fecha inicio</label>
            <input type="date" class="form-control" id="dateOne" name="dateOne" >
          </div>
          <div class="col-sm-5">
            <label for="dateTwo" class="form-label">Fecha final</label>
            <input type="date" class="form-control" id="dateTwo" name="dateTwo" >
          </div>
          <div class="col-sm-2 text-center">
            <div class="d-grid gap-2" style="margin-top:30px;">
              <button id="btnSendData" class="btn btn-primary" type="button">
                Consultar
              </button>
              <!--button id="btnSendData" class="btn btn-primary" type="button">Consultar</button>-->
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
  <div class="card card-custom card-stretch gutter-b">
    <div class="card-header">
      <h5>Listado de cajas</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive" id="table-content">
      </div>
    </div>
  </div>
</section>
<!--Show modal detail caja-->
<div class="modal fade" id="detailCajaModal" tabindex="-1" aria-labelledby="detailCajaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="detailCajaModalLabel">Detalle del corte del cajero</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-sm table-bordered">
          <tbody>
            <tr class="text-center">
              <td colspan="2"><strong id="name_empresa"></strong></td>
            </tr>
            <tr >
              <td>Fecha de operacion</td>
              <td id="date_operation" class="text-right"></td>
            </tr>
            <tr>
              <td>Nombre del cajero</td>
              <td id="name_cajero" class="text-right"></td>
            </tr>
            <tr class="text-center">
              <td colspan="2"><strong>Movimientos</strong></td>
            </tr>
            <tr>
              <td>Fondo de caja</td>
              <td id="fondo_caja" class="text-right"></td>
            </tr>
            <tr>
              <td>Efectivo en caja</td>
              <td id="efectivo_caja" class="text-right"></td>
            </tr>
            <tr>
              <td>Ventas en efectivo</td>
              <td id="sale_efectivo" class="text-right"></td>
            </tr>
            <tr>
              <td>Faltante</td>
              <td id="faltante_caja" class="text-right"></td>
            </tr>
            <tr>
              <td>Sobrante</td>
              <td id="sobrante_caja" class="text-right"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/funciones_caja/rogercode-historico-caja.js')}}" type="module"></script>
@endsection