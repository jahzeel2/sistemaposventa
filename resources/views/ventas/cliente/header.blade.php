<section class="content margindivsection">
	<div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
		<div class="d-flex align-items-center">
      <div>
	      <!--a href="{{route('venta.create')}}" class="btn btn-secondary btn-sm mr-3">
          <i class="fa fa-archive"></i>
          <strong> Realizar una venta</strong>
        </a-->
        <button type="button" class="btn btn6 btn-sm mr-3" data-toggle="modal" data-target="#ModalSaveCliente">
        <i class="fa fa-archive mr-2"></i>
          <strong>Registrar nuevo cliente</strong> 
        </button>
      </div>
		</div>
	</div>
</section>

<!-- MODAL PARA AGREGAR NUEVO CLIENTE-->
<div class="modal fade" id="ModalSaveCliente" tabindex="-1" role="dialog" aria-labelledby="ModalSaveClienteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="ModalSaveClienteLabel">Agregar nuevo cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
            <form id="save_cliente" autocomplete="off">
            @csrf
            <div class="form-group mb-3">
            <label>Nombre<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" name="nombre" required placeholder="Ingresa el nombre del cliente">
            </div>
             <div class="form-group">
            <label>Direccion<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" name="direccion" required placeholder="Ingresa la direccion del cliente">
            </div>
             <div class="form-group">
            <label>Telefono<i class="text-danger"><strong>*</strong></i></label>
                <input type="number" class="form-control style-input" name="telefono" required placeholder="Ingresa el telefono del cliente">
            </div>
            <div class="form-group">
            <label>Email<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" name="email" required placeholder="Ingresa el email del cliente">
            </div>
             @include('custom.validate_save_form_ajax')
      </div>
      <div class="modal-footer style-modal-form">
            <button type="button" class="btn btn5" id="btn_hide_save_modal" data-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
            <button type="button" class="btn btn6" id="btnsavecliente"><i class="fas fa-check-circle text-success mr-2"></i>Guardar</button>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA ACTUALIZAR NUEVO CLIENTE-->
<div class="modal fade" id="ModalUpdateCliente" tabindex="-1" role="dialog" aria-labelledby="ModalSaveClienteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="">Actualizar cliente</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
        <form id="update_cliente" autocomplete="off">
          @csrf
          <input type="text" id="clienteupdate" name="clienteupdate" hidden="true">
          <div class="form-group">
          <label>Nombre<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" class="form-control style-input" name="updnombre" id="updnombre" required placeholder="Ingresa el nombre del cliente">
          </div>
            <div class="form-group">
          <label>Direccion<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" class="form-control style-input" name="upddireccion" id="upddireccion" required placeholder="Ingresa la direccion del cliente">
          </div>
            <div class="form-group">
          <label>Telefono<i class="text-danger"><strong>*</strong></i></label>
              <input type="number" class="form-control style-input" name="updtelefono" id="updtelefono" required placeholder="Ingresa el telefono del cliente">
          </div>
          <div class="form-group">
          <label>Email<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" class="form-control style-input" name="updemail" id="updemail" required placeholder="Ingresa el email del cliente">
          </div>
          @include('custom.validate_update_form_ajax')
        </form>
      </div>
      <div class="modal-footer style-modal-form">
            <button type="button" class="btn btn5" id="hide_update_modal" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
            <button type="button" class="btn btn6" id="btnupdatecliente"><i class="fas fa-check-circle text-success mr-2"></i>Actualizar cliente</button>
      </div>
    </div>
  </div>
</div>
