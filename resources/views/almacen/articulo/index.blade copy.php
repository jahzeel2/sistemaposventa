@extends('layouts.admin')
@section('contenido')
@include('almacen.articulo.header')
<section class="section margindivsection">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="producto_table" class="table table-bordered table-hover">
                    <thead>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>stock</th>
                        <th>Acciones</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

@push('ScriptProducto')
<script src="{{asset('js/funciones_articulo/articulo.js')}}"></script> 
@endpush
@endsection