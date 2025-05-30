import {SearchProducto} from "../export_funcion/export_function_entradas.js";
import {Search} from "../export_funcion/export_function search.js";
const mysearchp = document.querySelector("#BuscarEntradaProducto");
const ul_add_lip = document.querySelector("#autocompleteentrada");
const idlip = "prodentradap";
const myurlp ="/nombrearticuloentrada";
const searchproductenttrada = new SearchProducto(myurlp,mysearchp,ul_add_lip,idlip);
searchproductenttrada.InputSearchProduct();
const id_ulp = "#autocompleteentrada";
searchproductenttrada.InputKeydownEntradas(id_ulp);
/**AL RECARGAR LA PAGINA*/
window.onload = () => {
   mostrarproductostemp();
};
/**FUNCTION QUE PERMITE IR GUARDANDO LOS PRODUCTOS TEMPORALMENTE AGREGADOS EN LA TABLA ENTRADAS*/
const FormEnTemp = document.querySelector("#temp_datos_entradas");
//FormEnTemp.addEventListener("submit", (e) => {
const btnaddtempprodent = document.querySelector("#btn_addentradas");
btnaddtempprodent.addEventListener("click", (e) => {
    e.preventDefault();
    const idbuttontemp = document.querySelector("#btn_addentradas");
    idbuttontemp.innerHTML = "";
    idbuttontemp.disabled = true;
    idbuttontemp.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos...`;
    //alert("se ejecuto");
    // const idbtnentrada =
    const datosforment = new FormData(
        document.getElementById("temp_datos_entradas")
    );
    var url = "/temp_datos";
    fetch(url, {
        method: "post",
        body: datosforment
    })
    .then(data => data.json())
    .then(data => {
        //console.log("Success:", data);
        if (data.estado == 1) {
        /**se manda a llamar la function que pinta los productos obtenidos de la tabla temporal*/
        mysearchp.focus();
        FormEnTemp.reset();
        idbuttontemp.disabled = false;
        idbuttontemp.innerHTML = `<i class="fas fa-check-circle text-success"></i> Agregar`;
        pintar_productos_tabla(data);
        } else if (data.estado == 0) {
            //console.log(data.mensaje);
            mensaje_error_save_entrada_temp(data);
            idbuttontemp.disabled = false;
            idbuttontemp.innerHTML = `<i class="fas fa-check-circle text-success"></i> Agregar`;
            //toastr.error(data.mensaje);
        } else if (data.estado == "errorvalidacion") {
            mensaje_error_save_entrada_temp(data);
            idbuttontemp.disabled = false;
            idbuttontemp.innerHTML = `<i class="fas fa-check-circle text-success"></i> Agregar`;
        }
    })
    .catch(function(error) {
        console.error("Error:", error);
        idbuttontemp.disabled = false;
        idbuttontemp.innerHTML = `<i class="fas fa-check-circle text-success"></i> Agregar`;
    });
});
/**MENSAJES DE ERRROR */
var mensaje_error_save_entrada_temp = (data) => {
    var errores = document.querySelector(".print-save-error-msg");
    errores.innerHTML = "";
    errores.style.display = "block";
    const mensaje_validacion_entradas = data.mensaje;
    mensaje_validacion_entradas.forEach(element => {
        // console.log(element);
        errores.innerHTML += "<li>" + element + "</li>";
    });
    window.setTimeout(function() {
        $(".print-save-error-msg").slideUp(function() {});
    }, 3000);
};

/*ELIMINAR EL PRODUCTO DE LA TABLA TEMPORAL ENTRADAS*/
const delete_temp_prod_entrada = (id,idArticulo) => {
  //  alert(id);
  //Token de seguridad
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
  var id_user = document.getElementById("id_user").value;
  var url = "/deleteproduct";
  var datos = new FormData();
  datos.append('id_user',id_user);
  datos.append('idprod', id);
  datos.append('idArticulo', idArticulo);
  fetch(url, {
    headers: {
       'X-CSRF-TOKEN': CSRF_TOKEN// <--- aquí el token de seguridad.
    },
    method:'post',
    body:datos
  })
  .then(data => data.json())
  .then(data => {
    //console.log('Success:', data);
    if (data.estado == 1 ) {
        pintar_productos_tabla(data);
    }
  })
  .catch(function(error){
    console.error('Error:', error)
  });
}

/**FUNCTION QUE PERMITE CONSULTAR LOS PRODUCTOS AGREGADOS Y QUE NO SE HAN REGISTRADO EN LA TABLA ENTRADAS*/
var mostrarproductostemp = () => {
  //Token de seguridad
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
  var id_user = document.getElementById("id_user").value;
  var url = "/showproductostemp";
  var datos = new FormData();
  datos.append('id_user',id_user);
  fetch(url,{
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN// <--- aquí el token de seguridad.
    },
    method:'post',
    body:datos
  })
  .then(data => data.json())
  .then(data => {
    //console.log('Success:', data);
    if (data.estado == 1) {
        pintar_productos_tabla(data);
    }
  })
  .catch(function(error){
    console.error('Error:', error)
  });
}
/**FUNCTION QUE GUARDA LOS DATOS DE LA ENTRADA DE LOS PRODUCTOS*/
const formsaveproducto = document.querySelector("#save_producto_entradas");
formsaveproducto.addEventListener("submit", (e) => {
    e.preventDefault();
    const idbuttonsave = document.querySelector("#form_save_entradas");
    idbuttonsave.innerHTML = "";
    idbuttonsave.disabled = true;
    idbuttonsave.innerHTML += `<span class="spinner-border spinner-border-sm" 
    role="status" aria-hidden="true"></span> Enviando datos...`;
    //alert("se genero el formulario con exito");
    var saveprod = new FormData(document.getElementById('save_producto_entradas'));
    var url = "/saveproductoentrada";
    fetch(url,{
        method:'post',
        body:saveprod
    })
    .then(data => data.json())
    .then(data => {
        //console.log('Success:', data);
        //formsaveproducto.reset();
        if (data.estado == 1) {
            toastr.success(data.mensaje);
            formsaveproducto.reset(); 
            idbuttonsave.disabled = false;
            idbuttonsave.innerHTML = `<i class="fas fa-check-circle text-success"></i> Aceptar`;
            const tablesindatos = document.querySelector("#tabla_tmp_productos");
            document.querySelector("#folio").value = data.newfolio;
            tablesindatos.innerHTML = "";
        }else if (data.estado == 0) {
            mensaje_error_save_entrada_temp(data);
            idbuttonsave.disabled = false;
            idbuttonsave.innerHTML = `<i class="fas fa-check-circle text-success"></i> Aceptar`;
        } else if (data.estado == "errorvalidacion") {
            mensaje_error_save_entrada_temp(data);
            idbuttonsave.disabled = false;
            idbuttonsave.innerHTML = `<i class="fas fa-check-circle text-success"></i> Aceptar`;
        }
    })
    .catch(function(error){
        console.error('Error:', error)
        idbuttonsave.disabled = false;
        idbuttonsave.innerHTML = "Aceptar";
    });
    //var inputValue = saveprod.get("idarticulo[]");
    // for (var [key, value] of saveprod.entries()) { 
    //     console.log(key, value);
    // }
});

/*FUNCTION QUE PINTA LOS DATOS OBTENIDOS DE LA TABLA TEMPORAL DE LOS PRODUCTOS*/
var pintar_productos_tabla = (data) => {
    var productos_temp = data.productos;
    //console.log(productos_temp);
    var pintartabla = document.querySelector("#tabla_tmp_productos");
    pintartabla.innerHTML = "";
    var i = 0;
    for (var item of productos_temp) {
        i++;
        pintartabla.innerHTML += `
        <tr>
        <td>${i}</td>
        <td><input type="text" class="size_input" hidden="true" name="idarticulo[]" value="${item.idarticulo}">${item.codigo}</td>
        <td style="width: 30%;"><input type="text" name="nombre[]" style="width: 100%;border:0;" class="" value="${item.nombre}" readonly></td>
        <td style="width: 5%;"><input type="number" name="cantidad[]" class="size_input" step="any" value="${item.cantidad}" readonly></td>
        <td style="width: 5%;"><input type="number" name="pcompra[]" class="size_input" step="any" size="4" value="${item.pcompra}" readonly></td>
        <td style="width: 5%;"><input type="number" name="pventa[]" class="size_input" step="any" size="4" value="${item.pventa}" readonly></td>
        <td><input type="text" class="size_input" name="subtotalprod[]" value="${item.subtotal_format}" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm delete_btn_entra" name="${item.idtemp},${item.idarticulo}"><i class="fas fa-trash-alt"></i></button></td>
        </tr>
        `;
    }
    //onclick="delete(${item.idtemp});"
    /**SCROLL QUE PERMITE PONER EL SCROLL A LA TABLA SI PASA LOS 200PX */
    var divscroll = document.querySelector(".tableFixHead");
    divscroll.style.height="290px";
    var totalg = data.total;
    /**SE ENVIA EL TOTAL DE LA COMPRA QUE SE REALIZO AL PROVEEDOR A LOS INPUTS CORESPONDIENTES*/
    var inputtolal = document.querySelector("#total_general");
    inputtolal.value=totalg.total;
    //inputtolal.style.fontSize="25px";
    
    var total_input = document.querySelector("#total_input");
    total_input.value=totalg.total;
    // total_input.style.fontSize="25px";
    // input.style.fontSize = `${fontSize}px` 
    // document.getElementById("total_general").value=
    // console.log(totalg);
    /**FUNCTION THAT DELETE PRODUCT OF LIST */
    const btnent = document.querySelectorAll(".delete_btn_entra");
    btnent.forEach(btn=>{
        btn.addEventListener('click', (e) =>{
            e.preventDefault();
            const id = btn.getAttribute('name');
            let mySplit = id.split(",");
            delete_temp_prod_entrada(mySplit[0],mySplit[1]);
        })
    })
}

/**************************************************************************************/
/**SEARCH PROVEEDOR*/
const mysearch = document.querySelector("#myInput");
const ul_add_li = document.querySelector("#autocompleteli");

const idli = "proveedor";
const myurl = "/showproveedores";
const searchproveedor = new Search(myurl,mysearch,ul_add_li,idli);
searchproveedor.Inputsearch();
const id_ul = "#autocompleteli";
searchproveedor.InputKeydown(id_ul);

///////////////////////////////
/////////////////////////////////////////////