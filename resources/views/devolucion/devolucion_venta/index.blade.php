@extends('layouts.admin')
@section('contenido')
<!--@include('devolucion.devolucion_venta.header')-->
<section class="margindivsection">
    <div class="card">
        <div class="card-header border">
            <h4>Devolucion de la venta</h4>
        </div>
        <div class="card-body border">
            <div id="messagedevoluciones"></div>
            <div class="row">
                <div class="col-md-4">
                    <label for="inputState" class="form-label">Selecciona la caja</label>
                    <select class="form-select" id="nomcaja" aria-label="Default select example">
                        <option value="">Nombre del usuario con caja abierta</option>
                        @foreach($cajas as $caj)
                        <option value="{{$caj->idapertura}}|||{{$caj->user}}">{{$caj->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Escribe el folio de la venta</label>
                    <input type="text" id="foliosaledev"  class="form-control" placeholder="ingresa el folio de la venta">
                </div>
                <div class="col-md-4" style="margin-top: 31px;">
                    <div class="">
                        <button class="btn btn-secondary" id="searchsaledev"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>
            </div>
            <br>
            <!--div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="" class="col-form-label">Folio</label>
                </div>
                <div class="col-auto">
                    <input type="text" id="foliosaledev"  class="form-control" placeholder="ingresa el folio de la venta">
                </div>
                <div class="col-auto">
                    <span id="" class="form-button">
                    <button class="btn btn-secondary" id="searchsaledev"><i class="fas fa-search"></i> Buscar</button>
                    </span>
                </div>
            </div><br-->
            <form id="save_producto_devolucion">
            @csrf
            <div class="row">
                <input type="number" name="idventades" id="idventades" hidden>
                <input type="number" name="nowcaja" id="nowcaja" hidden>
                <div class="table-responsive col-md-12" style="">
                    <table id="" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                            <th hidden>#</th>
                            <th >Articulo</th>
                            <th style="width:10%">Cantidad</th>
                            <th style="width:10%">P venta</th>
                            <th style="width:10%">Descuento</th>
                            <th style="width:10%">Subtotal</th>
                            <th >Devolucion</th>
                            </tr>
                        </thead>
                        <tbody id="tbodydevoluciones">
                           
                        </tbody>
                    </table>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-12">
                  <button type="button" class="btn btn-info" id="save_devolucion" >Realizar devolución</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>
@push('ScriptDevolucionVenta')
<script src="{{asset('js/funciones_devolucion/devolucion_venta.js')}}"></script> 
@endpush
@endsection