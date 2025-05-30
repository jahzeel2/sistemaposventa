@extends('layouts.admin')
@section('contenido')
@include('compras.ingreso.header')
<section class="content margindivsection">    
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table id="entradas_tabla" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Folio</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>        
                </table>
            </div>
        </div><!-- /.card-body -->
    </div>
</section>          
<!--MODAL THAT SHOW PRODUCTS THAT ENTER-->
<div class="modal fade" id="Modalentradasproductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Entradas de productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="cliente">Proveedor</label>
                        <p id="proveedor_entrada"></p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="tipo">Fecha</label>
                        <p id="fecha_entrada"></p>
                    </div>
                </div> 
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="folio">Folio</label>
                        <p id="folio_entrada"></p>
                    </div>
                </div>  
            </div><!--fin del primer row-->
            <div id="" class="">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="row">
                            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <table id="detalles" class="table table-sm table-bordered text-center">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Articulo</th>
                                        <th scope="col">Precio compra</th>
                                        <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_details_entradas">
                                    
                                    </tbody>
                                </table>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col">
                                        </div>
                                        <div class="col-md-2 text-center" >
                                            <h6 style="margin-top:5px;"><strong> Total : </strong></h6>
                                        </div>
                                        <div class="col col-md-2 text-center">
                                            $ <input type="text" name="" id="total_entrada" class="size_input lectura" value="200.00" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div><!--FIn del modal-->
<!--templates for javasacript that show list of products-->
<template id="template-prod">
    <tr>
        <td class="prod-consecutivo">${i}</td>
        <td class="prod-cantidad"><input type="text" name="" class="size_input_change lectura" value=`${item.cantidad}` onkeypress="return filterFloat(event,this);"></td>
        <td class="prod-nombre">${item.nombre}</td>
        <td class="prod-precio_compra"><input type="text" name="" class="size_input lectura" value=`${item.precio_compra}` readonly></td>
        <td class="prod-subtotal"><input type="text" name="" class="size_input lectura" value=`${item.subtotal}` readonly></td>
    </tr>
</template>
<!--STYLE MY VIEW-->
<style>
.head_css{
    margin-top: 10px;
}

</style>
@push('ScriptEntradasIndex')
<script src="{{asset('js/funciones_entradas/entradas_index.js')}}"></script> 
@endpush
@endsection