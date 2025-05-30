@extends('layouts.admin')
@section('contenido')
@include('almacen.categoria.header')
{{-- <div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6 text-center">
            <div class="" id="message-success" role="alert"></div>
        </div>
          
    </div>
</div> --}}
<section class="section margindivsection">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="categoria_table" class="table table-bordered table-hover">
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </thead>
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

@push('ScriptCategoria')
<script src="{{asset('js/funciones_categoria/categoria.js')}}"></script>    
@endpush
@endsection