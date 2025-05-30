@extends('layouts.admin')
@section('contenido')
@include('ventas.cliente.header')
<section class="margindivsection">
    <div class="card">
        <h5 class="card-header">Lista de usuarios</h5>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_customers" class="table  table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>nombre</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@push('ScriptCliente')
<script src="{{asset('js/funciones_cliente/cliente.js')}}"></script> 
@endpush
@endsection