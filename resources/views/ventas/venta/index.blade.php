@extends('layouts.admin')
@section('contenido')
@include('ventas.venta.header')
<section class="section margindivsection">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="ventas_table" class="table table-bordered table-hover">
                    <thead>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Folio</th>
                        <th>Tipo</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>action</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<section>
@include('ventas.venta.reimpresion')
</section>
<!-- Modal show details sale-->
<div class="modal fade" id="ModalDetalleVenta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle de la venta</h5>
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
                        <label for="tipo">Tipo de comprobante</label>
                        <p id="detalle_tipo"></p>
                    </div>
                </div> 
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="folio">Folio de comprobante</label>
                        <p id="detalles_folio"></p>
                    </div>
                </div>  
            </div><!--fin del primer row-->
                <div id="" class="">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table id="detalles" class="table text-center">
                                    <thead>
                                        <tr>
                                        <th>Articulo</th>
                                        <th>Cantidad</th>
                                        <th>Precio venta</th>
                                        <th>Descuento</th>
                                        <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_details_sale">
                                    
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-3 offset-md-5 detalle_descripcion"><h6 class="float-right"><strong>Total : </strong></h6></div>
                                    <div class="col-md-3 offset-md-1 text-center detalle_descripcion"><h6><strong id="details_total_sale"></strong></h6></div>
                                </div>
                            </div>
                            </div>   
                        </div>
                    </div>
                </div>
        </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>

@push('ScriptVentasIndex')
<script src="{{asset('js/funciones_venta/ventas_index.js')}}"></script> 
@endpush
@endsection