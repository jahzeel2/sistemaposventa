<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="margindivsection">
  <!--https://preview.keenthemes.com/keen/demo1/index.html-->
	<div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
		<div class="d-flex align-items-center">
      <div>
	      <button type="button" class="btn btn6 btn-sm mr-3" id="btnshowmodalcategory">
          <i class="fa fa-archive mr-2"></i>
          <strong> Agregar nueva categoria</strong>
        </button>
      </div>
			<!--div>
				<button type="button" class="btn btn-info btn-sm mr-3">
          <i class="fa fa-archive"></i>
          <strong>Agregar nueva categoria</strong>
        </button>
			</div>
			<div>
				<button type="button" class="btn btn-info btn-sm mr-3">
          <i class="fa fa-archive"></i>
          <strong>Agregar nueva categoria</strong>
        </button>
			</div-->
		</div>
	</div>
</section>

<!--MODAL PARA AGREGAR LA NUEVA CATEGORIA-->
<div class="modal fade" id="ModalCategoria" tabindex="-1" role="dialog" aria-labelledby="ModalCategoriaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="CategoriaLabel">Agregar nueva categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
      {!! Form::open(['id'=>'save_categorie', 'autocomplete'=>'off'])!!}
            <div class="input-group mb-3">
              <div class="input-group-append">
                  <div class="input-group-text style-icon-fas">
                      <i class="fas fa-box-open"></i>
                  </div>
              </div>
            	<input type="text" id="nombre" name="nombre" class="form-control style-input" placeholder="Nombre">
            </div>
            <div class="input-group mb-3">
            	<input type="text" id="descripcion" name="descripcion" class="form-control style-input" placeholder="Descripción">
              <div class="input-group-append">
                  <div class="input-group-text style-icon-fas">
                      <i class="fas fa-file-signature"></i>
                  </div>
              </div>
            </div>
             @include('custom.validate_save_form_ajax')
      </div>
      <div class="modal-footer style-modal-form">
        <button type="button" class="btn btn5" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
         <button type="submit" class="btn btn6" id="btnsavecategoria"><i class="fas fa-check-circle text-success mr-2"></i>Guardar</button>
      </div>
      {!!Form::close()!!}
    </div>
  </div>
</div>

<!--MODAL PARA ACTUALIZAR LA CATEGORIA-->
<div class="modal fade" id="ModalCategoriaUpdate" tabindex="-1" role="dialog" aria-labelledby="ModalCategoriaUpdateLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="CategoriaLabel">Actualizar datos de la categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
      {!! Form::open(['id'=>'update_categorie','autocomplete'=>'off'])!!}
            <input type="text" id="upid" name=upid hidden="true">
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" id="upnombre" name="upnombre" class="form-control style-input" placeholder="Nombre...">
            </div>
            <div class="form-group">
            	<label for="descripcion">Descripción</label>
            	<input type="text" id="updescripcion" name="updescripcion" class="form-control style-input" placeholder="Descripción...">
            </div>
            @include('custom.validate_update_form_ajax')
      </div>
      <div class="modal-footer style-modal-form">
        <button type="button" class="btn btn5" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
        <button type="submit" class="btn btn6" id="btnupdatecategoria"><i class="fas fa-check-circle text-success mr-2"></i>Actualizar</button>
      </div>
      {!!Form::close()!!}
    </div>
  </div>
</div>
