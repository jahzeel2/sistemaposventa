import {SeachCustomer} from "../export_funcion/export_function_customers.js";
import {Search} from "../export_funcion/export_function search.js";
const mysearch = document.querySelector("#BuscarVentaProducto");
const ul_add_li = document.querySelector("#autocompleteventa");
const inputventa = document.querySelector("#pcantidad");
const div_error_modal = document.querySelector(".show_alert_modal");
let div_show_email = document.querySelector("#show_input_email");
//const btnprintpdf = document.querySelector("#btnPrintPdf");
const ventaId = document.querySelector("#idventa");//.value = data.sale_now.sale.idventa;        
const idli = "prodventa";
const myurl ="/findproducto";

const searchprodventa = new Search(myurl,mysearch,ul_add_li,idli);
searchprodventa.Inputsearch();
const id_ul = "#autocompleteventa";
searchprodventa.InputKeydown(id_ul);

/**INPUT SEARCH DATA FROM CUSTOMERS*/
const inputSearchCustomer = document.querySelector("#customers-searchs");
const searchcustomer = new SeachCustomer(inputSearchCustomer);
searchcustomer.InputSearchCustomer();

/*AL REARGAR LA PAGINA SE EJECUTA LA CONSULTA QUE MUESTRA LA TABLA SI TIENE DATOS TEMPORALES*/
window.onload = ()  =>{
    mostrarventaproductostemp();
}
/**FUNCTIONN QUE PERMITE CONSULTARLOS PRODUCTOS AGREGADOS TEMPORALMENTE Y NO SE HAN VENDIDO*/
const mostrarventaproductostemp = () => {
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
  var id_user = document.getElementById("id_user").value;
  var url = "/showproductosventatemp";
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
     //   console.log('Success:', data);
        if (data.estado == 1) {
            pintar_tabla_venta(data);
        }else if (data.estado == 0) {
            mensaje_error_save_venta_temp(data);
        }
    })
    .catch(function(error){
        console.error('Error:', error)
    });

}

/*FUNCTION QUE PERMITE GUARDAR LOS PRDUCTOS EN LA TABLA TEMPORAL*/
const FormSaveProducto = document.querySelector("#save_producto_venta");
const btnaddtempprod = document.querySelector("#btn_add_prod_tem_vent");
btnaddtempprod.addEventListener("click", (e) => { 
    e.preventDefault();
        let prodcantidad = document.querySelector("#pcantidad");
        let prodstock = document.querySelector("#pvstock");
        let numCantidad = Number(prodcantidad.value);
        let numStock = Number(prodstock.value);
        if (numCantidad > numStock) {
            Swal.fire(
            'Error!',
            'La cantidad es mayor al stock!',
            'error'
            )
            return false;
        }
        const btnsavetempventprod = document.querySelector("#btn_add_prod_tem_vent");
        btnsavetempventprod.innerHTML = "";
        btnsavetempventprod.disabled = true;
        btnsavetempventprod.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos...`;
        const datosprodvent = new FormData(document.getElementById("save_producto_venta"));
        var url = "/saveprodtempvent";
        fetch(url,{
            method: "post",
            body:datosprodvent
        })
        .then(data => data.json())
        .then(data => {
            //console.log("Success:", data);
            if (data.estado == 1) {
                mysearch.focus();
                pintar_tabla_venta(data);
                FormSaveProducto.reset();
                btnsavetempventprod.disabled = false;
                        
                btnsavetempventprod.innerHTML = `<i class="fas fa-check-circle text-success"></i> Agregar`;

            }else if (data.estado == 0) {
            mensaje_error_save_venta_temp(data);
                btnsavetempventprod.disabled = false;
                btnsavetempventprod.innerHTML = '<i class="fas fa-check-circle text-success"></i> Agregar';

            }else if (data.estado == "errorvalidacion") {
            mensaje_error_save_venta_temp(data);
                btnsavetempventprod.disabled = false;
                btnsavetempventprod.innerHTML = '<i class="fas fa-check-circle text-success"></i> Agregar';
            }
        })
        .catch(function(error) {
            console.error("Error:", error);

        });

})
/**MENSAJES DE ERRROR */
var mensaje_error_save_venta_temp = (data) => {
    var errores = document.querySelector(".print-save-error-msg");
    errores.innerHTML = "";
    errores.style.display = "block";
    const mensaje_validacion_ventas= data.mensaje;
    mensaje_validacion_ventas.forEach(element => {
        // console.log(element);
        errores.innerHTML += "<li>" + element + "</li>";
    });
    window.setTimeout(function() {
      const diverror =  document.querySelector(".print-save-error-msg");
      diverror.style.display="none";
    }, 3000);
};

/*FUNCTION QUE PINTA LOS DATOS OBTENIDOS DE LA TABLA TEMPORAL DE LAS VENTAS DE LOS PRODUCTOS*/
const pintar_tabla_venta = (data) => {
    const productos_venta_temp = data.productos;
    //console.log(productos_venta_temp)
    const pintar_tabla_producto_temp = document.querySelector("#tabla_venta_productos_temp");
    pintar_tabla_producto_temp.innerHTML = "";
    let count = 0; 
    for (let item of productos_venta_temp ) {
        count++;
        pintar_tabla_producto_temp.innerHTML +=`
        <tr>
        <td>${count}</td>
        <td><input type="hidden" name="idarticulo[]" value="${item.id_articulo}">${item.nombre}</td>
        <td><input type="number" class="size_input" readonly name="cantidad[]" value="${item.cantidad}"></td>
        <td><input type="number" class="size_input" readonly name="precio_venta[]" value="${item.precio}"></td>
        <td><input type="number" class="size_input" readonly name="descuento[]" value="${item.descuento}"></td>
        <td><input type="text" class="size_input" readonly name="subtotal[]" value="${item.total_format}"></td>
        <td><button type="button" class="btn btn-danger btn-sm delete_btn_prod_venta" name="${item.idart},${item.id_articulo}"><i class="fas fa-trash-alt"></i></button></td>
        </tr>
        `; 
    }
    /**SCROLL QUE PERMITE PONER EL SCROLL A LA TABLA SI PASA LOS 200PX */
    var divscroll = document.querySelector(".tableFixHead");
    divscroll.style.height="268px";
    /**SE ENVIA EL TOTAL DE LA VENTA A LOS INPUTS CORESPONDIENTES*/
    const inputventotal =  document.querySelector("#inputventatotal");
    inputventotal.value = data.totales.total;
    //inputventotal.style.fontSize="15px";

    const inputtotalv = document.querySelector("#venttotal_venta");
    inputtotalv.value = data.totales.total;
    //inputtotalv.style.fontSize="15px";
    /**FUNCTION THAT DELETE PRODUCT SALE*/
    const btnventadelete =  document.querySelectorAll(".delete_btn_prod_venta");
    btnventadelete.forEach(btn=>{
        btn.addEventListener("click", (e) =>{
            e.preventDefault();
            const id = btn.getAttribute('name');
            let mySplit = id.split(",");
            delete_venta_product_temp(mySplit[0],mySplit[1]);
        });
    });

}
/**FUNCTION QUE ME PERMITE ELEMINAR UN PRODUCTO DE LA TABLA DE LOS PRODUCTOS */
const delete_venta_product_temp = (id,idArticulo) => {
    //Token de seguridad
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var id_user = document.getElementById("id_user").value;
    var url = "/deleteventaproducto";
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
            pintar_tabla_venta (data);
        }else if(data.estado == 0){
            mensaje_error_save_venta_temp(data);
        }else if(data.estado == "sinproductos"){
            const sin_producto = document.querySelector("#tabla_venta_productos_temp");
            sin_producto.innerHTML = ""
        }
    })
    .catch(function(error){
        console.error('Error:', error)
    });

}
/**FUNCTION QUE ME PERMITE REALIZAR EL CALCULO DEL CAMBIO DE LA CANTIDAD QUE SE ENTRGO*/
const pcantidadv = document.querySelector("#ventdinero");
pcantidadv.addEventListener("keyup", event =>{
    //console.log("exit");
    //pcantidadv.style.fontSize="23px";
    const  vcambio = document.querySelector("#ventsuelto");
    const  ventventa = document.querySelector("#venttotal_venta");
    const vcantidad = Number(pcantidadv.value);
    const totalreplace = ventventa.value.replace(/\s+/g, '');
    const vtotal = Number.parseFloat(totalreplace);
    const tt = ventventa.value;
    //console.log(tt)
    if ( tt === '0.00') {
        //console.log("no se genero con exito");
        return false;
    }
    //console.log("se formateo "+tt);
    //console.log('cantidad :'+ vcantidad+ 'total : '+vtotal);
    if(vcantidad < vtotal){
        //console.log("la cantidad es menor");
        vcambio.value="";
    }else if(vcantidad >= vtotal){
        const ventacambio = vcantidad - vtotal;
        //vcambio.style.fontSize="23px";
        let mycamb = truncateDecimals(ventacambio,2);
        //vcambio.value=ventacambio;
        ////console.log("EL CAMBIO :"+ ventacambio);
        vcambio.value = mycamb;
        //console.log("EL CAMBIO :"+ mycamb);
    }
});
/**fUNCION QUE PARSEA EL CAMBIO A 2 DECIMALES */
function truncateDecimals (num, digits) 
{
       var numS = num.toString();
       var decPos = numS.indexOf('.');
       var substrLength = decPos == -1 ? numS.length : 1 + decPos + digits;
       var trimmedResult = numS.substr(0, substrLength);
       var finalResult = isNaN(trimmedResult) ? 0 : trimmedResult;

       // adds leading zeros to the right
       if (decPos != -1){
           var s = trimmedResult+"";
           decPos = s.indexOf('.');
           var decLength = s.length - decPos;

               while (decLength <= digits){
                   s = s + "0";
                   decPos = s.indexOf('.');
                   decLength = s.length - decPos;
                   substrLength = decPos == -1 ? s.length : 1 + decPos + digits;
               };
           finalResult = s;
       }
       return finalResult;
};

/**FUNCTION THAT SAVE THE SALE*/
const save_guardar_venta = document.querySelector("#save_venta_total");
save_guardar_venta.addEventListener('submit', (e) =>{
    e.preventDefault();
    const btnsaveprodventa = document.querySelector("#venta_productos_realizada");
    btnsaveprodventa.innerHTML = "";
    btnsaveprodventa.disabled = true;
    btnsaveprodventa.innerHTML += `<span class="spinner-border spinner-border-sm" 
    role="status" aria-hidden="true"></span> Enviando datos...`;
    //alert("se ejecuto");
    const formdatosventa = new FormData(save_guardar_venta);
    //console.log(formdatosventa);
    var url ="/saveformventa";
    fetch(url,{
        method:'post',
        body:formdatosventa
    })
    .then(data => data.json())
    .then(data =>{
        //console.log("Success:", data);
        div_show_email.style.display = "none";
        if(data.estado == 1){
            //toastr.success(data.mensaje);
            const email = document.querySelector("#ventidcliente");
            //let get_text = email_cliente.options[email_cliente.selectedIndex].text;
            const email_cliente = document.querySelector("#nomcliente");
            let get_text = email_cliente.value;
            if (get_text != "Publico en general") {
                let getemail = email.getAttribute("class");
                document.querySelector("#nowemail").value = getemail;
            }

            const send_cambio_modal = document.querySelector("#ventsuelto").value;
            document.querySelector("#suelt_vent").value = send_cambio_modal;

            save_guardar_venta.reset();
            document.querySelector("#ventfonio").value = data.folio;
            
            btnsaveprodventa.disabled = false;
            btnsaveprodventa.innerHTML = `<i class="fas fa-check-circle text-success"></i> Aceptar`;
            const tablaventasindatos = document.querySelector("#tabla_venta_productos_temp");
            tablaventasindatos.innerHTML = ""
            document.querySelector("#customers-searchs").value = "";
            document.querySelector("#show-customers").innerHTML = "";
            print_ticket(data);
            var myModal = new bootstrap.Modal(document.getElementById('printModal'));
            myModal.show();
            
        }else if(data.estado == 0){
            mensaje_error_save_venta_temp(data);            
            btnsaveprodventa.disabled = false;
            btnsaveprodventa.innerHTML = `<i class="fas fa-check-circle text-success"></i> Aceptar`;

        }else if (data.estado == "errorvalidacion") {
            mensaje_error_save_venta_temp(data); 
            btnsaveprodventa.disabled = false;
            btnsaveprodventa.innerHTML = `<i class="fas fa-check-circle text-success"></i> Aceptar`;

        }
    })
    .catch(function(error){
        console.error("Error:", error);
            btnsaveprodventa.disabled = false;
            btnsaveprodventa.innerHTML = `<i class="fas fa-check-circle text-success"></i> Aceptar`;

    });

});
/**FUNCTION THAT PRINT THE TICKET*/
const print_ticket = (data) => {
    //console.log(data);
    /**the add properties the modal messsage cambio and success sale*/
    document.querySelector("#messsageModalLabelSuccess").textContent = data.mensaje;
    document.querySelector("#cambio_sale").textContent = data.suelto;
    /**The add properties the ticket for print*/
    let settings = data.settings;
    document.querySelector("#telefono").textContent = `Telefono ${settings.phone}`;
    document.querySelector("#adress").textContent = `${settings.adress}`;
    let detail =  data.sale_now.detail;
    //console.log(detail);
    const bodytabledetails = document.querySelector("#tbody_details");
    bodytabledetails.innerHTML = "";
    const template_details = document.querySelector("#template_details").content;
    const fragmetdetail = document.createDocumentFragment();
    document.querySelector("#sale_cliente").textContent = `Cliente ${data.sale_now.sale.nombre}`;
    document.querySelector("#sale_date").textContent =  `Fecha ${data.sale_now.sale.fecha_hora}`;        
    document.querySelector("#sale_folio").textContent = `Folio ${data.sale_now.sale.num_folio}`;        
    document.querySelector("#sale_total").textContent = data.sale_now.sale.total_venta;        
    document.querySelector("#sale_cambio").textContent = data.suelto;        
    document.querySelector("#cajero").textContent = `Cajero ${data.user[0].name}`;        
    document.querySelector("#sale_efectivo").textContent = data.efectivo;        
    
    document.querySelector("#cons_send_email").value = data.sale_now.sale.idventa;        

    detail.forEach(element => {
        //console.log(element);
        template_details.querySelector(".detail_cantidd").textContent=element.cantidad;
        template_details.querySelector(".detail_nombre").textContent=element.articulo;
        template_details.querySelector(".detail_venta").textContent=element.precio_venta;
        //template_details.querySelector(".detail_descuento").textContent=element.descuento;
        template_details.querySelector(".detail_subtotal").textContent=element.subtotal;
        const clonedetail = template_details.cloneNode(true);
        fragmetdetail.appendChild(clonedetail);

    });
    bodytabledetails.appendChild(fragmetdetail);
    /**********************NEW*****************************************/
    let dataSale = {
        "idventa":data.sale_now.sale.idventa,
        "suelto":data.suelto,
        "efectivo":data.efectivo,
    }
    ventaId.value = "";
    ventaId.value = JSON.stringify(dataSale); 

}

/**FUNCTION THAT PRINT THE TICKET FROM SALE*/
const now_print = document.querySelector("#print_now_ticket");
now_print.addEventListener("click", (e) =>{
    e.preventDefault();
    printPdf();
    let myModal = new bootstrap.Modal(document.getElementById('generatePdfModal'));
    myModal.show();
   /*let printContents = document.querySelector("#ticket").innerHTML;
    let iFrame = document.getElementById('print-iframe');
    iFrame.contentDocument.body.innerHTML = printContents;
    iFrame.focus();
    iFrame.contentWindow.print();*/
});


/**FUNCTION QUE PERMITE CANCELAR LA VENTA POR COMPLETO*/
const cancelventaprod = document.querySelector("#cancelventaproducto");
cancelventaprod.addEventListener('click', (e) =>{ 
    cancelventaprod.innerHTML = "";
    cancelventaprod.disabled = true;
    cancelventaprod.innerHTML += `<span class="spinner-border spinner-border-sm" 
    role="status" aria-hidden="true"></span> Enviando datos...`;
     //Token de seguridad
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var id_user_eliminar = document.getElementById("id_user").value;
    var url = "/deleteventa";
    var datoselim = new FormData();
    datoselim.append('id_user',id_user_eliminar);
    fetch(url,{
        headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN// <--- aquí el token de seguridad.
        },
        method:'post',
        body:datoselim
    })
    .then(data=> data.json())
    .then(data =>{
        //console.log('success',data);
        if(data.estado == 1){
            toastr.success(data.mensaje); 
            /**se reinicia el formulario de la venta mediante el id del form*/
            save_guardar_venta.reset();
            /**aqui termina */
            cancelventaprod.disabled = false;
            cancelventaprod.innerHTML = `<i class="far fa-window-close mr-2"></i> Cancelar la venta`;
            const limpiar_tabla = document.querySelector("#tabla_venta_productos_temp");
            limpiar_tabla.innerHTML = ""
        }else if (data.estado == 0) {
            mensaje_error_save_venta_temp(data);
            cancelventaprod.disabled = false;
            cancelventaprod.innerHTML = "Aceptar";   
        }
    })
    .catch(function(error){
        console.error('error',error);
        cancelventaprod.disabled = false;
        cancelventaprod.innerHTML = "Aceptar";
    });
   
});
/******************************************************** */
class acciones{

    startLoadIcon(button){
        button.innerHTML = "";
        button.disabled = true;
        button.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ...`;
    }

    endLoadIcon(endbutton,message_end){
        endbutton.disabled = false;
        endbutton.innerHTML = message_end;
        
    }
}

/**function for email */
let btn_email = document.querySelector("#btn-show-email");
btn_email.addEventListener("click", (e) => {
    e.preventDefault();
    div_show_email.style.display="block";
});

let form_date = document.querySelector("#send-email-now");
let send_email = document.querySelector("#btn-send-ticket-email");
send_email.addEventListener('click', (e) =>{
    e.preventDefault();
    let url = "/contact";

    const send = new acciones();
    send.startLoadIcon(send_email);
    setTimeout(() => {
        send_email_backend(url,form_date);

        let message_end = "Aceptar";
        send.endLoadIcon(send_email,message_end);
    }, 2000);
});

const send_email_backend = async (url,form) =>{
    try {
        let seend = await fetch(url, {
            method: "post",
            body: new FormData(form),
        });

        let data = await seend.json();
        //console.log(data);
        let msg = data.mensaje;
        let status = data.estatus;
        switch (status) {
            case 1:
                document.querySelector("#btn-close-modal").click();
                form_date.reset();
                div_show_email.style.display = "none";
                toastr.success(data.mensaje); 
            break;
            case "errorvalidacion":
                msg_error(msg,div_error_modal)
            break;
            
            default:
                break;
        }

    } catch (error) {
        console.log(error);
    }
};

const msg_error = (msg,div_error) =>{
    //console.log(msg)
    div_error.innerHTML = "";
    div_error.style.display = "block";
    div_error.style.marginTop += "10px";
    msg.forEach(element =>{
        div_error.innerHTML += `<li>${element}</li>`;
    });

    setTimeout(() => {
        div_error.style.display = "none";
    }, 3000);
}

/*btnprintpdf.addEventListener('click', () => {
    printPdf();
})*/

const printPdf =  async () => {
    /******************** */
    console.log(JSON.parse(ventaId.value));
    let getDataSale = ventaId.value;
    fetch('/ventas/print/'+getDataSale)
    .then(response => response.json())
    .then(data => {
        console.log(data);
        let pdfContent = atob(data.pdf); // Decode base64
        document.getElementById('pdf-iframe').src = "data:application/pdf;base64," + btoa(pdfContent);
    });
};