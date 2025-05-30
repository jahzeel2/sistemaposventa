@extends ('layouts.admin')
@section('title')
  Realizar una cotizacion    
@endsection
@section('styles')
  <!--link rel="stylesheet" href="{{asset('css/venta/create_venta.css')}}">-->
  <link rel="stylesheet" href="{{asset('css/quote/create_quote.css')}}">
@endsection
@section ('contenido')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
<section class="content" id="main_content_sale">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary card-outline div_radius">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa fa-search" aria-hidden="true"></i></span>
                                    </div>
                                    <input  type="text" id="buscarQuoteProducto" name="buscarQuoteProducto" class="form-control input-search" placeholder="Buscar por el nombre" autocomplete="off">
                                    <ul id="autocomplequote" tabindex='1' class="list-group"></ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
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

                </div>
                <div class="card-body">
                    <div class="tableFixHead" style="height:310px;">
                        <table id="detalles" class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Producto</th>
                                <th scope="col" class="th-table">Cantidad</th>
                                <th scope="col" class="th-table">Precio unitario</th>
                                <th scope="col" class="th-table">Subtotal</th>
                                <th scope="col" ><i class="fas fa-trash-alt"></i></th>
                                </tr>
                            </thead>
                            <tbody id="tbodyProd">
                                @foreach ($carrito as $index => $row)
                                <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$row->nombre}}</td>
                                <td><input type="text" value="{{$row->cantidad}}" id="cantidad{{$row->id}}" onkeydown="fnInputEnter(event,'{{$row->id}}','cantidad');" class=" input-table form-control form-control-sm" placeholder="1.00"></td>
                                <td><input type="text" value="{{$row->precio}}" id="precio{{$row->id}}" class=" input-table form-control form-control-sm" placeholder="0.00" readonly></td>
                                <td><input type="text" value="{{$row->total}}" class=" input-table form-control form-control-sm" placeholder="0.00" readonly></td>
                                <td class="text-center"><button type="button" onclick="downProd('{{$row->id}}');" class="btn btn-danger btn-sm delete_btn_prod_venta"><i class="fas fa-trash-alt"></i></button></td>
                                </tr>
                                <tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end mt-3">
                            <button class="btn btn-danger btn-sm" id="cancelQuote">Cancelar cotizacion</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <form id="form-quote">
                <div class="card div_radius">
                    <div class="card-header">
                        <h3 class="card-title">Datos de la cotizacion</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="container">
                            <div class="mb-3 mt-3">
                                <label for="nombre">Cliente</label>
                                <div class="input-group">
                                <input type="text" class="form-control" value="" id="nomcliente" placeholder="Nombre del cliente" autocomplete="off" readonly required>
                                <input type="hidden" name="clienteId" value="" id="clienteId" size="3" placeholder="id del cliente" autocomplete="off" required>
                                <button type="button" class="btn btn6" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-users"></i></button>
                                </div>
                            </div>
                            <div class="mb-2 mt-2">
                                <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" readonly placeholder="" required>
                                    </div>
                                </div>
                                <!--div class="col">
                                    <div class="form-group">
                                    <label for="">Telefono</label>
                                    <input type="text" id="ventsuelto" name="ventsuelto" class="form-control" readonly placeholder=""> 
                                    </div>
                                </div>-->
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                <label for="">Validez</label>
                                    <select class="form-select" name="validez" required>
                                    <option selected value="">Seleccionar</option>
                                    <option value="5 dias">5 dias</option>
                                    <option value="10 dias">10 dias</option>
                                    <option value="15 dias">15 dias</option>
                                    <option value="20 dias">20 dias</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 text-center">
                                <div class="form-group">
                                <label for="">Total</label>
                                <input type="text" name="total_quote" value="{{$total}}" class="form-control text-center input_style_total" id="total_quote" placeholder="0.00" readonly required>
                                </div>
                            </div>
                            <div class="mb-3 mt-4">
                                <div class="form-group">
                                <button type="button" id="btn-save-quotation" class="btn btn-default btn-block btn1">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Aceptar
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<section>
  <!--Modal customers-->
  @include('ventas.venta.modal-customers')
  @include('quotes.modal-exit-quote')
</section>
@endsection
@section('scripts')
  <script src="{{asset('js/funciones_quotes/quote.js')}}"></script>
  <script src="{{asset('js/funciones_quotes/create_quote.js')}}" type="module"></script>
@endsection