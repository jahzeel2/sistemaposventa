<meta name="csrf-token" content="{{ csrf_token() }}">
<!--MODAL PARA ACTUALIZAR EL PRODUCTO-->
<div class="modal fade" id="ModalUpdateProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title" id="ModalUpdateP">Actualizar el producto</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body style-modal-form">
        <form id="update_one_product" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
          <input type="text" name="idprod" id="idprod" hidden="true">
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="nombre">Nombre<i class="text-danger"><strong>*</strong></i></label>
                <input type="text" name="upnombre" id="upnombre" class="form-control style-input" placeholder="Nombre...">
            </div>
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="">Categoria<i class="text-danger"><strong>*</strong></i></label>
              <select name="upidcategoria" id="upidcategoria" class="form-control style-input">
                <option value="">Seleciona una opción</option>
                @foreach ($categoria as $cat)
                <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                  @endforeach
              </select>
            </div>
          </div> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="codigo">Codigo<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" name="upcodigo" id="upcodigo" class="form-control style-input" placeholder="Codigo del articulo" required>
            </div>
          </div>      
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="stock">Stock del articulo<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" name="upstock" id="upstock" class="form-control style-input" placeholder="stock del articulo" required readonly>
            </div>
          </div> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="stock">p. compra<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" name="uppcompra" id="uppcompra" class="form-control style-input" placeholder="0.00" onkeypress="return filterFloatdecimal2(event,this);">
            </div>
          </div> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="stock">p. venta<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" name="uppventa" id="uppventa" class="form-control style-input" placeholder="0.00" onkeypress="return filterFloatdecimal2(event,this);"> 
            </div>
          </div> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="nombre">Descripcion<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" name="updescripcion" id="updescripcion" class="form-control style-input" placeholder="descripcion del articulo" value="{{old('descripcion')}}">
            </div>
          </div>
          <!--div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="">Lleva iva (%)</label><br>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="upiva1" name="upiva" value="1.16" class="custom-control-input">
                <label class="custom-control-label" for="upiva1">Si</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="upiva2" name="upiva" value="0.00" class="custom-control-input">
                <label class="custom-control-label" for="upiva2">No</label>
              </div>
            </div>
          </div-->
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" >
            <div class="form-group">
              <label for="">Descuento $<i class="text-danger"><strong>*</strong></i></label>
              <input type="text" name="uparticulo_des" id="uparticulo_des" value="0.00" class="form-control style-input" placeholder="Ingresa el descuento en $" onkeypress="return filterFloatdecimal2(event,this);">
            </div>
          </div> 
          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" id="imgactual" style="height:100px;">
            <!--Here is the image references articulo-->
          </div>
        </div>
      </div>
      <div class="style-modal-form">
      @include('message.show_error_modal_form')
      </div>
      <div class="modal-footer style-modal-form" style="">
        <button type="button" class="btn btn5" data-bs-dismiss="modal"><i class="fas fa-window-close mr-2 " id="btn-close-form-modal-product"></i>Cerrar</button>
        <button type="button" id="btn_update_prod" class="btn btn6"><i class="fas fa-check-circle text-success mr-2"></i>Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>