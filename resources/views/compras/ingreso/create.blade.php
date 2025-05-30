@extends('layouts.admin')
@section('contenido')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--section-->
  <!--ol class="breadcrumb" style="border:1px solid #CDC7C7;background:white;margin-bottom:1px;margin-top:3px;padding: 5px 0px 0px 6px !important;">
    <!--a href="#"><li class="breadcrumb-item btn btn-info btn-sm">Lista de entradas de productos</li></a-->
    <!--a href="{{url('compras/entradas')}}"><h5><span class="badge bg-secondary">Lista de entrada de productos</span></h5></!--a>
    <!--li class="breadcrumb-item"><a href="#">Menu 1</a></li>
    <li class="breadcrumb-item"><a href="#">Menu 2</a></li>
    <li-- class="breadcrumb-item"><a href="#">Menu 3</a></li-->
  <!--/ol>
</section-->
<!-- Main content -->
<section class="content margincss">
      <div class="row">
        <div class="col-md-9">
          <div class="card card-primary card-outline div_radius">
            <div class="card-header">
                <!--FORMULARIO QUE GUARDA EL PRODUCTO TEMPORALMENTE-->
                {!! Form::open(['id'=>'temp_datos_entradas'])!!}
                    <div class="row">
                        <!--Input que tiene el id del usuario identificado-->
                        <input type="text" size="4"  id="id_user" name="id_user" value="{{Auth::user()->id}}" hidden="true">
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="background:white;" class="input-group-text" id="basic-addon1"><i class="fa fa-search" aria-hidden="true"></i></span>
                                    </div>
                                    <!--input id="IngresoNombreArticulo" type="text" class="form-control" placeholder="Nombre"-->

                                    <input  type="text" id="BuscarEntradaProducto" name="BuscarVentaProducto" class="form-control input-search" placeholder="Buscar por el nombre" autocomplete="off">
                                    <ul id="autocompleteentrada" tabindex='1' class="list-group"></ul>

                                    <!--Input que tiene el id del articulo-->
                                    <input type="text" name="idarticulo" id="idarticulo" size="4" hidden="true">
                                    <!---->
                                    <!--Input que tiene el codigo del articulo-->
                                    <input type="text" name="IngresoCodigoArticulo" id="IngresoCodigoArticulo" size="4" hidden="true">
                                    <!---->
                                    <!--Input que tiene el nombre del articulo-->
                                    <input type="text" id="pnombrearticulo" name="pnombrearticulo" size="4" hidden="true"> 
                                    <!--Input-->
                                </div>
                            </div>                        
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group py-2">
                                <div class="form-check form-switch">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="barcodeChecked" checked>
                                        <label class="form-check-label" for="barcodeChecked">Codigo de barras</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--fin del row codigo y nombre-->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Cantidad</label>
                                <input type="number" step="any" class="form-control" id="pcantidad" name="pcantidad" min="0" placeholder="0.00" onkeypress="return filterFloat(event,this);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">P. compra</label>
                                <input type="number" step="any" class="form-control" id="pprecio_compra" name="pprecio_compra" min="0" placeholder="0.00" onkeypress="return filterFloatdecimal2(event,this);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">P. venta</label>
                                <input type="number" step="any" class="form-control" id="pprecio_venta" name="pprecio_venta" min="0" placeholder="0.00" onkeypress="return filterFloatdecimal2(event,this);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group btn_css">
                                <button type="button" id="btn_addentradas" class="btn btn-default btn1">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                    @include('custom.validate_save_form_ajax')
                {!!Form::close()!!}    
            </div>
            <!--FORMULARIO QUE GUARDA LA ENTRADA DE LOS PRODUCTOS-->
            {!!Form::open(['id'=>'save_producto_entradas'])!!}
            <div class="card-body">
                <!-- <h5 class="card-title">Special title treatment</h5> -->
                <Input type="text" name="user_id" hidden="true" value="{{Auth::user()->id}}" id="user_id"> 
                <div class="table-responsive-sm tableFixHead">
                    <table id="detalles" style="width: 100%;" class="table table-sm table-bordered table-hover text-center">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Articulo</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio compra</th>
                            <th scope="col">Precio venta</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col"><i class="fas fa-trash-alt"></i></th>
                            </tr>
                        </thead>
                        <tbody id="tabla_tmp_productos">

                        </tbody>     
                    </table>
                </div>
                <!--terminacion del div del scroll de la tabla-->
                <div class="container" style="border:1px solid #A9A9A9;">
                    <div class="row">
                        <div class="col-md-10 text-right">
                            <h5 class="input_all_total"><strong>Total $</strong></h5>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="total_general" id="total_general" class="form-control" placeholder="00.00" readonly>
                        </div>
                    </div>
                </div>
            </div>
          </div> 
        </div>
        <!-- /.col -->
        <div class="col-md-3">
            <!--a href="#" class="btn btn-primary btn-block mb-3">Entrada de productos</a>-->
            <div class="card div_radius">
                <div class="card-header">
                    <h3 class="card-title">Datos</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="container">
                        <div class="mb-3" style="margin-top: 8px;">
                            <div class="form-group">
                                <label for="">Buscar el proveedor</label>
                                <div class="autocomplete" >
                                    <input id="myInput" type="text" placeholder="Escribir para empezar buscar" class="form-control" autocomplete="off">
                                </div>
                                <ul id="autocompleteli" tabindex='1' class="list-group"></ul>
                                <input type="text" name="idproveedor" id="idproveedor" autocomplete="off" hidden="true">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="">Folio</label>
                                <input type="text" class="form-control" value="{{$folio}}" name="folio" id="folio" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="">Total $</label>
                                <input type="text" class="form-control" name="total_input" id="total_input" placeholder="00.00" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <button type="submit" id="form_save_entradas" class="btn btn-default btn-block btn1">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Aceptar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div> 
            {!!Form::close()!!} 
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<!-- /.content -->

<!-- STYLE OF MY VIEW -->
<style>
.btn_css{
    margin-top: 32px;
}
/*****************************************************************/
/*the container must be positioned relative:*/
#autocompleteli{
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  background:red;
  /*position the autocomplete items to be the same width as the container:*/
  /*top: 100%;
  /*left: 0;
  right: 0;*/
}
#autocompleteli li{
  padding: 10px;
  cursor: pointer;
  border-bottom: 1px solid #d4d4d4;
  width: 100%;
}
.selected {
    color: white;
    background: #7f8c8d;
    /*background: #343A64;*/
}
/*****************/
/*the container must be positioned relative search prduct entrada:*/
#autocompleteentrada{
  margin-top:40px;
  background-color: #7f7f9f;
  position: absolute;
  box-shadow: 0 1px 3px 0px;
  border-radius: 3px;
  border: 1px solid #FAFAFA;
  z-index: 100;
  overflow-y: auto;
  margin-left: 40px;
  background:red;

  font-size: 15px;
  font-family: 'PT Sans', sans-serif;
  font-weight: bold;
}
</style>
@push('ScriptEntradaProductos')
<script src="{{asset('js/funciones_entradas/entradas.js')}}" type="module"></script> 
@endpush
@endsection