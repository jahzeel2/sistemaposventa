<section class="content margindivsection">
    <div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center">
        <div>
          <button type="button" class="btn btn-secondary btn-sm mr-3" id="showmodalsaveproduct">
            <i class="fa fa-archive"></i>
            <strong> Agregar nuevo producto</strong>
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

<!--MODAL PARA AGREGAR NUEVO PRODUCTO-->
<div class="modal fade" id="ModalSaveProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-secondary">
            <h5 class="modal-title" id="exampleModalLongTitle">Registro de un nuevo articulo</h5>
            <button type="button" class="close" datas-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="save_producto" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre..." value="{{old('nombre')}}">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="">Categoria</label>
                        <select name="idcategoria" class="form-control">
                            <option value="">Seleciona una opción</option>
                            @foreach ($categoria as $cat)
                            <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="codigo">Codigo</label>
                        <input type="text" name="codigo" class="form-control" placeholder="Codigo del articulo" value="{{old('codigo')}}">
                    </div>
                </div> 
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="stock">stock</label>
                        <input type="text" name="stock" class="form-control" placeholder="stock del articulo" required value="0" >
                    </div>
                </div> 
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="stock">p. compra</label>
                        <input type="text" name="pcompra" class="form-control" placeholder="00.00" value="0" onkeypress="return filterFloatdecimal2(event,this);">
                    </div>
                </div> 
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="stock">p. venta</label>
                        <input type="text" name="pventa" class="form-control" placeholder="00.00"  value="0"  onkeypress="return filterFloatdecimal2(event,this);"> 
                    </div>
                </div> 
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="nombre">Descripcion</label>
                        <input type="text" name="descripcion" class="form-control" placeholder="descripcion del articulo" value="{{old('descripcion')}}">
                    </div>
                </div> 
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="nombre">Imagen del articulo</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                    </div>
                </div>
                <!--div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="">Lleva iva (%)</label><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="iva1" name="iva" value="1.16" class="custom-control-input">
                            <label class="custom-control-label" for="iva1">Si</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="iva2" name="iva" value="0.00" class="custom-control-input">
                            <label class="custom-control-label" for="iva2">No</label>
                        </div>
                    </div>
                </div-->
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" >
                    <div class="form-group">
                        <label for="">Descuento $</label>
                        <input type="text" name="articulo_des" id="articulo_des" value="0" class="form-control" placeholder="Ingresa el descuento $" onkeypress="return filterFloatdecimal2(event,this);">
                    </div>
                </div>
                  
            </div>
            @include('custom.validate_save_form_ajax')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button class="btn btn-primary text-nowrap" id="btnsaveproducto" type="submit">
            Guardar
            </button>
            </form>
        </div>
    </div>
  </div>
</div>

<!--MODAL PARA ACTUALIZAR EL PRODUCTO-->
<div class="modal fade" id="ModalUpdateProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="ModalUpdateP">Actualizar el producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_one_product" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
          <input type="text" name="idprod" id="idprod" hidden="true">
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="nombre">Nombre</label>
                <input type="text" name="upnombre" id="upnombre" class="form-control" placeholder="Nombre...">
            </div>
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="">Categoria</label>
              <select name="upidcategoria" id="upidcategoria" class="form-control">
                <option value="">Seleciona una opción</option>
                @foreach ($categoria as $cat)
                <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                  @endforeach
              </select>
            </div>
          </div> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="codigo">Codigo</label>
              <input type="text" name="upcodigo" id="upcodigo" class="form-control" placeholder="Codigo del articulo" value="{{old('codigo')}}">
            </div>
          </div>      
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="stock">stock</label>
              <input type="text" name="upstock" id="upstock" class="form-control" placeholder="stock del articulo" required value="0" readonly>
            </div>
          </div> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="stock">p. compra</label>
              <input type="text" name="uppcompra" id="uppcompra" class="form-control" placeholder="00.00" value="0" onkeypress="return filterFloatdecimal2(event,this);">
            </div>
          </div> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="stock">p. venta</label>
              <input type="text" name="uppventa" id="uppventa" class="form-control" placeholder="00.00"  value="0"  onkeypress="return filterFloatdecimal2(event,this);"> 
            </div>
          </div> 
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
              <label for="nombre">Descripcion</label>
              <input type="text" name="updescripcion" id="updescripcion" class="form-control" placeholder="descripcion del articulo" value="{{old('descripcion')}}">
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
              <label for="">Descuento $</label>
              <input type="text" name="uparticulo_des" id="uparticulo_des" value="0" class="form-control" placeholder="Ingresa el descuento $" onkeypress="return filterFloatdecimal2(event,this);">
            </div>
          </div> 
          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" id="imgactual">
            <!--Here is the image references articulo-->
          </div>
        </div>
        @include('custom.validate_update_form_ajax')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btn_update_prod" class="btn btn-primary">Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>
