@extends('layouts.admin')
@section('contenido')
<section class="section margindivsection">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 text-center">
          <div class="form-check">
            <input class="form-check-input" type="radio" value="mes" name="graphdate" id="graph_mes" >
            <label class="form-check-label" >
              <b>Generar grafica por mes</b> 
            </label>
          </div>
        </div>
        <div class="col-md-6 text-center">
          <div class="form-check">
            <input class="form-check-input" type="radio" value="dia" name="graphdate" id="graph_dia" >
            <label class="form-check-label">
               <b>Generar grafica por dias</b>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section style="display:none;margin-top:-7px;" class="section-dias">
    <form id="get-date-form">
       @csrf
       <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                 <b>Fecha de inicio</b>
              </div>
              <div class="card-body">
              <div class="group">
                <input type="date" name="date_start" class="form-control">
              </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <b>Fecha Final</b>
              </div>
              <div class="card-body">
              <div class="group">
                <input type="date" name="date_end" class="form-control">
              </div>
            </div>
            </div>	
          </div>
          <div class="col-md-4">
              <div class="card">
                <div class="card-header text-center">
                  <b>Mostrar grafica</b>
                </div>
                <div class="card-body text-center">
                  <div class="group">
                    <button  type="button" class="btn btn-info" id="btn-send-date">
                    <i class="fas fa-check-square me-2"></i>Aceptar
                    </button>
                  </div>
                </div>
              </div>
          </div>
       </div>
    </form>
</section>
<section style="display:none;margin-top:-7px;" class="section-mes">
    <form id="get-mes-form">
       @csrf
       <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                 <b>Mes de inicio</b>
              </div>
              <div class="card-body">
              <div class="group">
                <input type="month" name="mes_start" class="form-control">
              </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <b>Mes Final</b>
              </div>
              <div class="card-body">
              <div class="group">
                <input type="month" name="mes_end" class="form-control">
              </div>
            </div>
            </div>	
          </div>
          <div class="col-md-4">
              <div class="card">
                <div class="card-header text-center">
                  <b>Mostrar grafica</b>
                </div>
                <div class="card-body text-center">
                  <div class="group">
                    <button  type="button" class="btn btn-info" id="btn-send-mes">
                    <i class="fas fa-check-square me-2"></i>Aceptar
                    </button>
                  </div>
                </div>
              </div>
          </div>
       </div>
    </form>
</section>
<section class="section-graph" style="display:none;margin-top:-7px;">
   <div class="card">
     <div class="card-header">
        <span class="show-sale-general badge text-sm badge-secondary"></span > <span class="badge badge-primary text-sm"> Venta general en el periodo</span>
      <div class="card-tools">
        <h3 class="card-title">Grafica de las ventas</h3>
      </div>
     </div>
     <div class="card-body">
	  <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="">
              <div class="card-body">
                <!-- /.d-flex -->

                <div class="position-relative  div-content-graph mb-4">
                  <canvas id="search-sales-chart" height="200"></canvas>
                </div>

              </div>
            </div>
            <!-- /.card -->
     </div>
   </div>
</section>
@endsection
@section('scripts')
    <script src="{{asset('js/funciones_graphcs/report_graphcs.js')}}" type="module"></script>
@endsection