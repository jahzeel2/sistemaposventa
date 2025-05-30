<section class="content margindivsection">
    <div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center">
        <div>
          <a href="{{route('entradas.create')}}" class="btn btn6 btn-sm mr-3" id="btnshowmodalprovider">
            <i class="fa fa-archive"></i>
            <strong> Agregar nuevo proveedor</strong>
          </a>
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

<!-- MODAL PARA AGREGAR NUEVO PROVEEDOR -->
<div class="modal fade" id="ModalSaveProveedor" tabindex="-1" role="dialog" aria-labelledby="ModalSaveProveedorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="ModalSaveProveedorLabel">Agregar nuevo proveedor</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
            <form id="save_proveedor" autocomplete="off">
            @csrf
            <div class="form-group">
            <label>Nombre<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" name="nombre" placeholder="Ingresa el nombre">
            </div>
             <div class="form-group">
            <label>Direccion<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" name="direccion" placeholder="Ingresa la direccion">
            </div>
             <div class="form-group">
            <label>Telefono<i class="text-danger"><strong>*</strong></i></label>
                <input type="number" class="form-control style-input" name="telefono" placeholder="Ingresa el telofono">
            </div>
            <div class="form-group">
            <label>Email<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" name="email" placeholder="Ingresa el email">
            </div>
             @include('custom.validate_save_form_ajax')
      </div>
      <div class="modal-footer style-modal-form">
            <button type="button" class="btn btn5" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
            <button type="submit" class="btn btn6" id="btnsaveproveedor"><i class="fas fa-check-circle text-success mr-2"></i>Guardar</button>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL THAT UPDATE ONE PROVIDER-->
<div class="modal fade" id="ModalUpdateProvider" tabindex="-1" role="dialog" aria-labelledby="ModalSaveProveedorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="ModalSaveProveedorLabel">Agregar nuevo proveedor</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
            <form id="update_proveedor" autocomplete="off">
            @csrf
            <div class="form-group">
              <input type="text" name="upid" id="upid" hidden="true">
              <label>Nombre<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" id="upnombre" name="upnombre" placeholder="Ingresa el nombre">
            </div>
             <div class="form-group">
            <label>Direccion<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" id="updireccion" name="updireccion" placeholder="Ingresa la direccion">
            </div>
             <div class="form-group">
            <label>Telefono<i class="text-danger"><strong>*</strong></i></label>
                <input type="number" class="form-control style-input" id="uptelefono" name="uptelefono" placeholder="Ingresa el telofono"> 
            </div>
            <div class="form-group">
            <label>Email<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" class="form-control style-input" id="upemail" name="upemail" placeholder="Ingresa el email">
            </div>
             @include('custom.validate_update_form_ajax')
      </div>
      <div class="modal-footer style-modal-form">
            <button type="button" class="btn btn5" id="modal_update_proveedor" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 "></i>Cerrar</button>
            <button type="submit" class="btn btn6"><i class="fas fa-check-circle text-success mr-2"></i>Actualizar</button>
            </form>
      </div>
    </div>
  </div>
</div>