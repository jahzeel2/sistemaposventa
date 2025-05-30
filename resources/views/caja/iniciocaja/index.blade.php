@extends('layouts.admin')
@section('contenido')
<section><br>
    <div class="card">
        <div class="card-header">
            Caja
        </div>
        <div class="card-body">
            <button class="btn btn6" id="btnshowmodalapertura">
              <i class="fas fa-plus-circle text-success mr-2"></i>
              Abrir nueva caja
            </button>
        </div>
    </div>
</section>
<section id="datos_apertura">
  <div class="card card-custom card-stretch gutter-b">
    <div class="card-header">
      Registro
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <div class="group">
            <label for="">Nombre</label>
            <h5>{{$name_user}}</h5>
          </div>
        </div>
        <div class="col-md-4">
          <div class="group">
            <label for="">Hora</label>
            <h5>{{$fecha}}</h5>
          </div>  
        </div>
        <div class="col-md-4">
          <div class="group">
            <label for="">Cantidad inicial</label>
            <h5>{{$cantidad}}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--MODAL FOR OPENING THE BOX-->
<div class="modal fade" id="saveModalcaja" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="exampleModalLabel">Registrar la cantidad inicial</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
        <form id="form_save_apertura">
          <div class="container">
            <div class="group">
              <label for="">Nombre del usuario</label>
              <input type="text" name="idnom" value="{{$id}}" id="idnom" class="form-control input-lg" hidden="true">
              <h5>{{$name_user}}</h5>
            </div>
            <div class="group  input-group-lg">
              <label for="">Cantidad inicial ($)</label>
              <input type="number" class="form-control style-input" id="cantapertura" name="cantapertura" min="0" step="0.00" placeholder="0.00" onkeypress="return filterFloatdecimal2(event,this);">
            </div><br>
            <div class="group">
              <div id="messageform"></div>
            </div>
          </div>
        </form>  
      </div>
      <div class="modal-footer style-modal-form">
        <button type="button" class="btn btn5" id="closemodalapertura" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
        <button type="button" class="btn btn6" id="btnsaveapertura"><i class="fas fa-check-circle text-success mr-2"></i>Guardar</button>
      </div>
    </div>
  </div>
</div>
@push('ScriptcajaApertura')
<script src="{{asset('js/funciones_caja/apertura_caja.js')}}"></script> 
@endpush
@endsection
<!--https://bsalehelp.zendesk.com/hc/es/articles/115007714508--C%C3%B3mo-abrir-o-Cerrar-Caja--->
