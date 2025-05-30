@extends('layouts.admin')
@section('contenido')
@include('almacen.articulo.header')
<section class="section margindivsection">
   <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" style="color:black" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Lista de articulos</button>
            <button class="nav-link" style="color:black" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Registrar nuevo producto</button>
            <button class="nav-link" style="color:black" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Subir por categoria</button>
        </div>
    </nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    @include('almacen.articulo.list_product')
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    @include('almacen.articulo.new_product')
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
    <div class="container">
      <div class="card">
        <div class="card-body text-center">
          @include('almacen.articulo.import_product')
        </div>
      </div>
    </div>
  </div>
</div>
</section>

@endsection
@section('scripts')
  <script src="{{asset('js/funciones_articulo/articulos.js')}}"></script> 
@endsection