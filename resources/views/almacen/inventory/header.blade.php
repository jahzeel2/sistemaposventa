<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="margindivsection">
  <!--https://preview.keenthemes.com/keen/demo1/index.html-->
	<div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
		<div class="d-flex align-items-center">
      <div>
        <form method="get" action="/pdfinventario">
          <button type="submit" class="btn btn6 btn-sm mr-3" id="">
            <i class="fas fa-file-pdf mr-2"></i>
            <strong>Generar inventario</strong>
          </button>
        </form>
      </div>
      <div>
        <form method="get" action="/excelarticulo">
        <button type="submit" class="btn btn9 btn-sm mr-3" id="">
          <i class="fa fa-file-excel mr-2"></i>
          <strong>Exportar a excel</strong>
        </button>
        </form>
      </div>
		</div>
	</div>
</section>
