
$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
    $('#producto_table').DataTable({
           "autoWidth": false,
           processing: true,
           serverSide: true,
           ajax: {
             url:'/showproducto',
            type: 'GET',
           },
           columns: [
                   { data: 'idarticulo', name: 'idarticulo'},
                   { data:'codigo', name: 'codigo'},
                   { data: 'nombre', name: 'nombre' },
                   { data: 'stock', name: 'stock' },
                   {data: 'action', name:'action'}
                 ],
          order: [[0, 'desc']]
        });
    });
});

/**FUNCTION QUE GUARDA EL PRODUCTO */
$(document).ready(function () {
    const idmodalsave = document.querySelector("#ModalSaveProduct");
    const myModalsaveProd = new bootstrap.Modal(idmodalsave);
    const showmodalsaveprod = document.querySelector("#showmodalsaveproduct");
    showmodalsaveprod.addEventListener('click', (e) =>{
        e.preventDefault();
        myModalsaveProd.show();
    });

   $("#save_producto").on('submit', function (e) {
       e.preventDefault();
       //alert("jajaja");
       //var datos = new FormData(this);
       $("#btnsaveproducto").prop("disabled", true);
       $("#btnsaveproducto").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos...`);
        // $("#load_span").addClass('spinner-border');
       //alert(datos);
       //console.log(datos);
        $.ajax({ 
            data: new FormData(this),
            url: "/savearticulo",
            type: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                //console.log(data);
                //console.log(data.mensaje);
                if (data.estado == 1) {
                    $("#btnsaveproducto").html('Guardar');
                    $("#btnsaveproducto").prop("disabled", false);
                    toastr.success(data.mensaje);
                    $('#save_producto').trigger("reset");
                    //$('.ModalSaveProduct').modal('hide');
                    myModalsaveProd.hide();
                    refresh_table_product();
                }else if (data.estado == 0) {
                    toastr.error(data.mensaje);
                    $("#btnsaveproducto").html('Guardar');
                    $("#btnsaveproducto").prop("disabled", false);
                }else if (data.estado == 'errorvalidacion') {
                    //$("#message").css('display','block');
                    //$("#message").html(data.message);
                    message_error_save(data);
                    $("#btnsaveproducto").html('Guardar');
                    $("#btnsaveproducto").prop("disabled", false);
                }
                
            },
            error: function (data) {
                $("#btnsaveproducto").html('Guardar');
                $("#btnsaveproducto").prop("disabled", false);
                console.log('Error:', data);
                toastr.error("Error: Ocurrio un error inesperado, revisa el codigo");                
            }    
        });
   });
});

/**FUNCTION THAT REFRESH A TABLE AFTER OF AN ACTION*/
const refresh_table_product = () =>{
    var TableRefreshProduct = $('#producto_table').dataTable(); 
    TableRefreshProduct.fnDraw(false);
}

/**FUNCTION THAT DISPLAYS PRODUCT ERRORS*/
var message_error_save = (data) =>{
    var errores = document.querySelector(".print-save-error-msg");
    errores.innerHTML = "";
    errores.style.display = "block";
    const mensaje_validacion_prod= data.mensaje;
    mensaje_validacion_prod.forEach(element => {
        errores.innerHTML += "<li>" + element + "</li>";
    });
    window.setTimeout(function() {
      const diverror =  document.querySelector(".print-save-error-msg");
      diverror.style.display="none";
    }, 3000);
    
}

/**FUNCTION QUE ME PERMITE OBTENER LA INFORMACION A EDITAR*/
const idmodalupdate = document.querySelector("#ModalUpdateProduct");
const myModalUpdateProd = new bootstrap.Modal(idmodalupdate);
const edit_product = (id) =>{
    get_data_product()
    async function get_data_product(){
        try {

           let response = await fetch('/product-list/'+id)
           let json = await response.json()
           //console.log(json) 
           document.querySelector("#idprod").value = json.idarticulo;
           document.querySelector('#upnombre').value = json.nombre;
           document.querySelector('#upidcategoria').value = json.categoria_id;
           document.querySelector('#upcodigo').value = json.codigo;
           document.querySelector('#upstock').value = json.stock;
           document.querySelector('#uppcompra').value = json.pcompra;
           document.querySelector('#uppventa').value = json.pventa;
           document.querySelector('#updescripcion').value = json.descripcion;
           let img_actual = json.imagen;
           let imgactual = document.querySelector('#imgactual');
           imgactual.innerHTML="";
           imgactual.innerHTML=`
           <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="nombre">Cambiar imagen</label>
                    <input type="file" name="upimagen" id="upimagen" onchange="getnameimage();" class="form-control style-input" accept="image/*">
                    <p class="text-center nomimg"><strong>Sin imagen</strong></p>
                </div>
            </div>
            <div class="col text-center">
                <div class="form-group">
                    <label>Imagen actual</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="../imagenes/articulos/${img_actual}" height="100px" width="100px" class="img-thumbnail">
                </div>
            </div>
           </div>
          `;
           document.querySelector('#uparticulo_des').value = json.descuento;
           myModalUpdateProd.show()

        } catch (error) {
            console.error("error ====>", error);
        }
    }
   
}

/*FUNCTION THAT ALLOWS PRODUCT UPDATE */
const UpdateProductOne = document.querySelector("#update_one_product");
UpdateProductOne.addEventListener('submit', (e) =>{
    e.preventDefault(e);
    const btnupprod = document.querySelector("#btn_update_prod");
    btnupprod.innerHTML = "";
    btnupprod.disabled = true;
    btnupprod.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos...`;
    //console.log("se ejecuto con exito")
    const updatesdata = new FormData(UpdateProductOne);
    //console.log(updatesdata)
    var url = "/updateproduct"
    fetch(url, {
        method:'post',
        body:updatesdata
    })
    .then(data =>data.json())
    .then(data =>{
        //console.log("Success :"+ data);
        if (data.estado == 1){
           toastr.success(data.mensaje);
           btnupprod.disabled = false;
           btnupprod.innerHTML = "Actualizar";
           refresh_table_product();
           myModalUpdateProd.hide();
        }else if (data.estado == 0) {
           message_error_update_product(data);
           btnupprod.disabled = false;
           btnupprod.innerHTML = "Actualizar";
           console.log(data.mensaje);

        }else if(data.estado == "errorvalidacion") {
           message_error_update_product(data);
           btnupprod.disabled = false;
           btnupprod.innerHTML = "Actualizar";

        }

    })
    .catch(function(error){
        console.error("Error", error);
        btnupprod.disabled = false;
        btnupprod.innerHTML = "Actualizar";


    })

});

/**MESSAGES OF ERRORS WHEN UPDATING*/
var message_error_update_product = (data) => {
    var errores = document.querySelector(".print-update-error-msg");
    errores.innerHTML = "";
    errores.style.display = "block";
    const mensaje_validacion_product= data.mensaje;
    mensaje_validacion_product.forEach(element => {
        // console.log(element);
        errores.innerHTML += "<li>" + element + "</li>";
    });
    window.setTimeout(function() {
      const diverror =  document.querySelector(".print-update-error-msg");
      diverror.style.display="none";
    }, 3000);
};
/**FUNCTION THAT GET THE NAME OF INPUT UPIMAGEN*/
const getnameimage = () =>{
    const imgd= document.querySelector("#upimagen");
    var imgname = imgd.files[0].name;
    if(imgname == "" || imgname == "undefined"){
        console.log("no tiene nombre");
    }else{
        document.querySelector(".nomimg").innerHTML = imgname;
    }
    //console.log('el CRS de la imagen es'+ imgname);
}


async function delete_product(id){
    if(confirm('Estas seguro de eliminar el producto')){
        try {
            let response = await fetch('/delete-category/'+id);
            let json = await response.json();
            //console.log(json);
            if (json.estado == 1) {
                refresh_table_product();
                toastr.success(json.mensaje);
            }else if (json.estado == 0) {
                toastr.error(json.mensaje);
            }
        } catch (error) {
            console.error(error);
            toastr.error(error);
        }
    }
}



 