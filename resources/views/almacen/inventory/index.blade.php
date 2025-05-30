@extends('layouts.admin')
@section('contenido')
@include('almacen.inventory.header')
{{-- <div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6 text-center">
            <div class="" id="message-success" role="alert"></div>
        </div>
          
    </div>
</div> --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section margindivsection">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="inventory_table" class="table table-bordered table-hover">
                    <thead>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Precio compra</th>
                        <th>Precio Venta</th>
                        <th scope="col"><i class="fa fa-cog" aria-hidden="true"></i></th>
                    </thead>
                    <tbody>
                        @foreach($productos as $prod)
                        <tr>
                            <td>{{ $prod->idarticulo}}</td>
                            <td>{{ $prod->codigo}}</td>
                            <td>{{ $prod->nombre }}</td>
                            <!--td><span class="badge badge-success">{{ $prod->stock}}</span></td>-->
                            <td><input type="number" id="stock{{$prod->idarticulo}}" min="0" step="0.00" value="{{$prod->stock}}" class="form-control" size="9" placeholder="0.00" onkeypress="return filterFloat(event,this);"></td>
                            <td>{{ $prod->pcompra}}</td>
                            <td>{{ $prod->pventa}}</td>
                            <td><button class="btn btn-primary btn-sm" id="btn{{$prod->idarticulo}}" dataId="{{$prod->idarticulo}}" name="btnAjustar">Ajustar</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="lg-12 col-md-12 col-sm-12 col-xs-12">
        <div>
             
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script src="{{asset('js/funciones_articulo/inventario.js')}}" type="module"></script>
@endsection