@extends ('layouts.admin')
@section ('contenido')
    <div class="row" style="margin-top: 10px;">
        <div class="col-12 col-md-6 col-xl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4 text-center">
                    <div class="float-right text-success">
                      <i class="fas fa-wallet"></i>
                    </div>
                    <h5 class="mb-3"><strong>Ventas del dia</strong></h5>
                    <div class="">
                       <h4><span class="badge bg-secondary"><strong>{{$ventas}}</strong></span</h4>
                    </div>
                    <!--div>
                    </div-->
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4 text-center">
                    <div class="float-right text-info">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h5 class="mb-3"><strong>Total de articulos</strong></h5>
                    <div class="">
                       <h4><span class="badge bg-secondary"><strong>{{$productos}}</strong></span</h4>
                    </div>
                    <!--div>
                        volumen: 2,692.47 btc
                    </div-->
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4 text-center">
                    <div class="float-right text-warning">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h5 class="mb-3"><strong>Compras el dia</strong></h5>
                    <div class="">
                       <h4><span class="badge bg-secondary"><strong>{{$entradas}}</strong></span</h4>
                    </div>
                    <!--div>
                        volumen: 2,692.47 btc
                    </div-->
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4 text-center">
                    <div class="float-right text-primary">
                        <i class="fas fa-archive"></i>                       
                    </div>
                    <h5 class="mb-3"><strong>Cajas abiertas</strong></h5>
                    <div class="">
                       <h4><span class="badge bg-secondary"><strong>{{$cajas}}</strong></span</h4>
                    </div>
                    <!--div>
                        volumen: 2,692.47 btc
                    </div-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Ventas</h3>
                  <h3 class="card-title">Vista de informe</h3>
                  <!--a href="javascript:void(0);"> Vista de informe</a-->
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg show_total_today"></span>
                    <span>Ventas a lo largo del dia</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-chart-bar text-lg"></i>
                    </span>
                    <span class="text-muted">Las ventas</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <!--div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-success"></i> Hoy
                  </span>
                </div-->
              </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Ventas entre ayer y hoy</h3>
                  <h3 class="card-title">Vista de informe</h3>
                  <!--a href="javascript:void(0);"> Vista de informe</a-->
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-success text-lg"><i class="fas fa-chart-bar"></i></span>
                    <span>Comparativo</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span id="span_estatus" >
                      <i id="fas_estatus" ></i> <span id="up_down"></span>
                    </span>
                    <span class="text-muted">Ventas</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4" >
                  <canvas id="sales-chart-comparation" height="200" ></canvas>
                </div>

                <!--div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-success"></i> Hoy
                  </span>
                </div-->
              </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/functions_dashboard/admin.js')}}" type="module"></script>
@endsection