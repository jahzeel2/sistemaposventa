@extends ('layouts.admin')
@section('title')
  Realizar una venta    
@endsection
@section('styles')
  <link rel="stylesheet" href="{{asset('css/venta/create_venta.css')}}">
@endsection
@section ('contenido')
<div class="margincss">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<!--<h3>Nueva venta</h3>-->
		@if (count($errors)>0)
		    <div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
		@endif
    </div>
</div>
<!--if that displays the view if the condition is me-->
<!--$folio != 0 && $apertura != 0-->
@if($estatus === "Abierta")
  <!-- Main content -->
  <section class="content" id="main_content_sale">
        <div class="row">
          <div class="col-md-9 " style="" >
            <div class="card card-primary card-outline div_radius">
              <div class="card-header">
                {!!Form::open(['id'=>'save_producto_venta'])!!}
                  <div class="row">
                      <!--Input que tiene el id del usuario identificado-->
                      <input type="text" size="4"  id="id_user" name="id_user" value="{{Auth::user()->id}}" hidden="true">

                      <div class="col-md-9">
                        <div class="form-group">
                          <div class="input-group mb-3 ">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info" id="basic-addon1"><i class="fa fa-search" aria-hidden="true"></i></span>
                            </div>
                              <input  type="text" id="BuscarVentaProducto" name="BuscarVentaProducto" class="form-control input-search" placeholder="Buscar por el nombre" autocomplete="off">
                              <ul id="autocompleteventa" tabindex='1' class="list-group"></ul>
                              <!--NOMBRE DEL ARTICULO-->
                              <input type="text" placeholder="nombre articulo" id="NombreArticulo" name="NombreArticulo" size="4" hidden="true">
                              <!--EL ID DEL PRODUCTO-->
                              <input type="text" name="idarticulo" placeholder="id producro" id="idarticulo" size="4" hidden="true">
                              <!--EL CODIGO DEL ARTICULO -->
                              <input type="text" name="CodigoArticulo" placeholder="codigo producto" id="CodigoArticulo" size="4" hidden="true">
                              <!--EL INPUT DEL IVA -->
                              <input type="text" name="iva" placeholder="iva" id="iva"  size="4" hidden="true">
                              <!--EL NPUT DEL CODIGO-->
                              <input type="text" name="cod_user" id="cod_user" value="{{Auth::user()->id}}" placeholder="codigo del usuario"  hidden="true">
                              
                          </div>
                        </div>                        
                      </div>
                      <div class="col-md-3 text-center" >
                        <div class="form-group py-2">
                          <div class="form-check form-switch">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="barcodeChecked" >
                              <label class="form-check-label" for="barcodeChecked">Codigo de barras</label>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>    
                  <div class="row">
                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="">Cantidad</label>
                              <input type="number" class="form-control input-sm" id="pcantidad" name="pvcantidad" min="0" step="0.00" placeholder="0.00" onkeypress="return filterFloat(event,this);">
                              <!-- <input type="text" name="moneda nac" id="moneda_nac" value="10" onkeypress="return filterFloat(event,this);"/> -->
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="">Stock</label>
                              <input type="number" class="form-control input-sm" id="pvstock" name="pvstock" min="0" readonly step="0.00" placeholder="0.00">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="">P. venta</label>
                              <input type="number" class="form-control input-sm" id="pvprecio_venta" name="pvprecio_venta" readonly min="0" step="0.04" placeholder="0.00">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="">Descuento</label>
                              <input type="number" class="form-control input-sm" id="pvdescuento" name="pvdescuento" min="0" step="0.00" placeholder="0.00" readonly onkeypress="return filterFloatdecimal2(event,this);">
                          </div>
                      </div>
                  </div>
                  <button type="button" class="btn btn-default btn1" id="btn_add_prod_tem_vent">
                    <i class="fas fa-check-circle text-success"></i>
                    Agregar
                  </button>
                  @include('custom.validate_save_form_ajax')
                {!!Form::close()!!}
              </div>
              <div class="card-body" style="margin-top: -18px;">
                <!-- <h5 class="card-title">Special title treatment</h5> -->
                {!!Form::open(['id'=>'save_venta_total'])!!}
                <div class="tableFixHead">
                  <!--ID USER PARA LAVENTA-->
                  <input type="text" size="4"  id="id_user_vent" name="id_user_vent" value="{{Auth::user()->id}}" hidden="true">
                  <!--EL ID DE LA CAJA QUE EL CAJERO TIENE ACCESO-->
                  <input type="number" name="inicioapertura" value="{{$apertura}}" id="inicioapertura" hidden="true">
                  <table id="detalles" style="width:100%" class="table table-bordered table-sm table-hover text-center">
                      <thead>
                          <tr>
                            <th>Num</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>
                            <th>P. venta</th>
                            <th>Descuento</th>
                            <th>Subtotal</th>
                            <th scope="col"><i class="fas fa-trash-alt"></i></th>
                          </tr>
                      </thead>
                      <tbody id="tabla_venta_productos_temp">
                      </tbody>
                  </table>
                  <!-- /.table -->
                </div>
                <!--TERMINACION DEL DIV DEL SCROLL DE LA TABLA-->
                <!--INICIO DEL DIV DONDE SE PRESENTAN LOS TOTALES GLOBALES-->
                  <div class="container" style="border:1px solid #A9A9A9;">
                    <div class="row">
                      <div class="col-md-3" style="">
                        <div class="btn-group" role="group" style="width:100%;height:100%;margin-left: -7px;">
                          <button type="button" id="cancelventaproducto" class="btn btn-danger btn-block btn-flat">
                            Cancelar venta
                          </button>
                        </div>
                      </div>
                      <div class="col-md-3" style=""></div>
                      <div class="col-md-3  text-right" style="">
                        <h5 class="" style="margin-top:8px;"><strong>Total $</strong></h5>
                      </div>
                      <div class="col-md-3">
                        
                          <input type="text" name="" id="inputventatotal" class="form-control input_style_total" placeholder="00.00" readonly>
                        
                      </div>
                    </div>
                  </div>
              </div>
            </div> 
          </div>
          <!-- /.col -->
          <div class="col-md-3 ">
            <!-- /.card-body -->
            <div class="card div_radius">
              <div class="card-header">
                <h3 class="card-title">Datos de la venta</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="container">
                  <div class="mb-3">
                    <label for="nombre">Cliente</label>
                    <div class="input-group">
                      <input type="text" class="form-control" value="{{$nomcliente}}" id="nomcliente" placeholder="Nombre del cliente" autocomplete="off" readonly>
                      <input type="hidden" name="ventidcliente" value="{{$clienteid}}" id="ventidcliente" size="3" placeholder="id del cliente" autocomplete="off">
                      <button type="button" class="btn btn6" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-users"></i></button>
                    </div>
                  </div>
                  <div class="mb-2">
                    <div class="row">
                      <div class="col">
                        <div class="group">
                          <label for="">Comprobante</label>
                          <select name="venttipo_comprobante" class="form-control" id="">
                            <option value="Ticket">Ticket</option>
                            <option value="Factura">Factura</option>
                          </select>
                        </div>
                      </div>
                      <div class="col">
                        <div class="group">
                            <label for="">Folio</label>
                            <input type="text" name="ventfolio" id="ventfonio" value="{{$folio}}" class="form-control" placeholder="num de folio" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               
              </div>
              <!-- /.card-body -->
              <br>
            </div>
            <!-- /.card -->
            <div class="card div_radius">
              <div class="card-header">
                <h3 class="card-title">Realizar venta</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="container">
                  <div class="mb-3">
                    <div class="form-group">
                      <input type="text" name="venttotal_venta" class="form-control text-center input_style_total" id="venttotal_venta" placeholder="00.00" readonly>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="">Cantidad</label>
                          <input type="text" id="ventdinero" name="ventdinero" class="form-control input_style" placeholder="$ 0.00" onkeypress="return filterFloatdecimal2(event,this);" autocomplete="off">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                        <label for="">Cambio</label>
                        <input type="text" id="ventsuelto" name="ventsuelto" class="form-control input_style" readonly placeholder="$ 0.00"> 
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="form-group">
                      <button type="submit" id="venta_productos_realizada" class="btn btn-default btn-block btn1">
                        <i class="fas fa-check-circle text-success"></i>
                        Aceptar
                      </button>
                    </div>
                  </div>
                </div>
                <!--<ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <div class="form-group">
                      <input type="text" name="venttotal_venta" class="form-control text-center input_style_total" id="venttotal_venta" placeholder="00.00" readonly>
                    </div>
                  </li>
                  <li class="nav-item">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="">Cantidad</label>
                          <input type="text" id="ventdinero" name="ventdinero" class="form-control input_style" placeholder="$ 0.00" onkeypress="return filterFloatdecimal2(event,this);" autocomplete="off">
                        </div>
                      </div>
                      <div class="col">
                        <di class="form-group">
                        <label for="">Cambio</label>
                        <input type="text" id="ventsuelto" name="ventsuelto" class="form-control input_style" readonly placeholder="$ 0.00"> 
                        </di>
                      </div>
                    </div>
                  </li>
                  <li class="nav-item">
                    <br>
                    <button type="submit" id="venta_productos_realizada" class="btn btn-default btn-block btn1">
                      <i class="fas fa-check-circle text-success"></i>
                      Aceptar
                    </button>
                  </li>
                </ul>-->
              </div> <!-- /.fin  de card-body -->
            </div> <!-- /.fin card -->
            {!!Form::close()!!}
          </div><!-- /.fin del col-md-3 -->
        </div><!-- /. fin del row -->
  </section><!-- /.fin de la seccion -->
  <!--Modal customers-->
  @include('ventas.venta.modal-customers')
  <!--template-->
  <template id="template-show-temp_prod">
    <tr>
      <td class="count-prod-temp"></td>
      <td ><input type="hidden" class="art-prod-temp" name="idarticulo[]" value=""><p class="nom-prod-temp"></p></td>
      <td><input type="number" class="size_input cant-prod-temp" readonly name="cantidad[]" value=""></td>
      <td><input type="number" class="size_input precio-prod-temp" readonly name="precio_venta[]" value=""></td>
      <td><input type="number" class="size_input desc-prod-temp" readonly name="descuento[]" value=""></td>
      <td><input type="text" class="size_input subt-prod-temp" readonly name="subtotal[]" value=""></td>
      <td><button type="button" class="btn btn-danger btn-sm delete_btn_prod_venta" name=""><i class="fas fa-trash-alt"></i></button></td>
    </tr>
  </template>
  @include('ventas.venta.impresion')
@else
  <!--show the error to open the box-->
  <div class="card">
    <div class="card-header">
      <h5 class="fw-normal">Ocurrio un error</h5> 
    </div>
    <div class="card-body bg-danger">
      <div class="container">
      <h5>1. No tienes una caja abierta</h5>
      <h5>2. Necesitas ir al modulo de caja en la seccion apertura de caja.</h5>
      <i class="fas fa-exclamation-circle"></i>
      </div>
    </div>
  </div>
@endif    
@endsection
@if ($estatus === "Abierta")
<!--Script de la funciones venta-->
@section('scripts')
  <script src="{{asset('js/funciones_venta/venta.js')}}" type="module"></script>
@endsection
@endif
