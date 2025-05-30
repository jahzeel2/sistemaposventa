<div class="card">
    <div class="card-body">
        <form id="form-add-excel">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <select class="form-select" id="category_excel" name="category_excel" aria-label="Default select example">
                    <option value="">Seleciona una categoria</option>
                    @foreach ($categoria as $cate)
                    <option value="{{$cate->idcategoria}}">{{$cate->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <div>
                    <input class="form-control" type="file" id="file_excel_articulos" name="file_excel_articulos">
                </div>
            </div>
            <div class="col-md-2 text-center">
                <div>
                    <button class="btn btn6" id="btnaddfileexcel"><i class="fas fa-file-excel text-success mr-2"></i>Cargar archivo</button>
                </div>
            </div>
        </div>
        </form>
        <div class="container">
            <div class="row">
                <div class="col-md-5 offset-md-3">
                    <div class="alert alert-danger error-form-upload_file" style="display:none;margin-top:10px;">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<section id="section-table-data-products" style="display: none;">
    <div class="card">
        <div class="card-body">
            <form id="form-save-products">
            @csrf
            <div class="table-responsive">
                <table id="" class="table table-bordered table-hover">
                    <thead>
                        <th>#</th>
                        <th style="width:15%">Codigo</th>
                        <th>Nombre</th>
                        <th style="width:10%">stock</th>
                        <th style="width:10%">P. compra</th>
                        <th style="width:10%">P. venta</th>
                        <th>Descripcion</th>
                        <th style="width:10%">Descuento</th>
                        <th class="text-center"><i class="fas fa-trash-alt"></i></th>
                    </thead>
                    <tbody id="body_show_data_articulos">
                    </tbody>
                </table>
            </div>
            </form>
            <div class="text-left">
                <button class="btn btn10" id="btn-save-products">
                    <i class="fas fa-upload text-success mr-2"></i>Importar
                </button>
            </div>
        </div>
    </div>
    
</section>
<template id="template_data_articulos"> 
    <tr>
        <td ><input type="text" name="upload_category[]" class="input_categoria" value="" hidden="true"><span class="auto"></span></td>
        <td><input type="text" name="upload_codigo[]" class="input_codigo form-control" value=""></td>
        <td><input type="text" name="upload_name[]" class="input_name form-control" value=""></td>
        <td><input type="text" name="upload_stock[]" class=" input_stock form-control" value="" onkeypress="return filterFloat(event,this);"></td>
        <td><input type="text" name="upload_compra[]" class=" input_compra form-control" value="" onkeypress="return filterFloatdecimal2(event,this);"></td>
        <td><input type="text" name="upload_venta[]" class="input_venta form-control" value="" onkeypress="return filterFloatdecimal2(event,this);"></td>
        <td><input type="text" name="upload_description[]" class="input_description form-control" value=""></td>
        <td><input type="text" name="upload_descuento[]" class="input_descuento form-control" value="" onkeypress="return filterFloatdecimal2(event,this);"></td>
        <td class="text-center">
            <button type="button"  class="btn btn-danger btn-sm btn-delete-producto"><i class="fas fa-trash-alt"></i></button>
        </td>
    </tr>
</template>
