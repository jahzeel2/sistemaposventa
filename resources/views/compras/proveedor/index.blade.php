@extends('layouts.admin')
@section('contenido')
@include('compras.proveedor.header')
{{-- <div id="contenidoform"></div> --}}
<section class="margindivsection">
    <div class="card">
        <div class="card-header">
            Lista de proveedores
        </div>
        <div class="card-body">
            <div class="row">
                <div class="lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div>
                        <div class="table-responsive">
                            <table id="proveedor_table" class="table table-bordered table-hover">
                                <thead>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('ScriptProveedor')
<script src="{{asset('js/funciones_proveedor/proveedor.js')}}"></script> 
@endpush
@endsection