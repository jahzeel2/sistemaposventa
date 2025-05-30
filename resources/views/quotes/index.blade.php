@extends('layouts.admin')
@section('contenido')
@include('quotes.header')
<section class="section margindivsection">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="quote_table" class="table table-bordered table-hover">
                    <thead>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Validez</th>
                        <th>Folio</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<section>
<!-- Modal show details qute-->
<div class="modal fade" id="ModalDetalleQoute" tabindex="-1" aria-labelledby="detalleQuoteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detalleQuoteModalLabel">Detalle de la cotizacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">     
            <div class="row">
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="cliente">Cliente</label>
                        <p id="detalle_cliente"></p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="tipo">Fecha </label>
                        <p id="detalle_fecha"></p>
                    </div>
                </div> 
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="folio">Folio cotizacion</label>
                        <p id="detalles_folio"></p>
                    </div>
                </div>  
            </div><!--fin del primer row-->
                <div id="" class="">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table id="detalles" class="table table-bordered ">
                                    <thead>
                                        <tr>
                                        <th>Articulo</th>
                                        <th>Cantidad</th>
                                        <th>Precio unitario</th>
                                        <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showDetailQuote">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td style="text-align:end"><strong>Total<strong></td>
                                            <td><strong id="detailTotal"></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            </div>   
                        </div>
                    </div>
                </div>
        </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn5" data-bs-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
</section>


@push('ScriptVentasIndex')
<script src="{{asset('js/funciones_quotes/quote_index.js')}}"></script> 
@endpush
@endsection