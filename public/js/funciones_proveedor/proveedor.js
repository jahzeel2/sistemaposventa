$(document).ready(function () {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(function() {
  $('#proveedor_table').DataTable({
       "autoWidth": false,
       processing: true,
       serverSide: true,
       ajax: {
         url:'/showproveedor',
        type: 'GET',
       },
       columns: [
               { data: 'idproveedor', name: 'idproveedor'},
               { data:'nombre', name: 'nombre'},
               { data: 'direccion', name: 'direccion' },
               { data: 'telefono', name: 'telefono' },
               { data: 'email', name: 'email'},
               {data: 'action', name:'action'}
             ],
      order: [[0, 'desc']]
    });
  });
});
/**FUNCTION THAT SAVE THE PROVIDER*/
const formularioP = document.querySelector("#save_proveedor");
formularioP.addEventListener('submit', (e) => {
  e.preventDefault();
  const idbuttonproveedor = document.querySelector("#btnsaveproveedor");
  idbuttonproveedor.innerHTML = "";
  idbuttonproveedor.disabled = true;
  idbuttonproveedor.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos...`;
  const datos = new FormData(document.getElementById('save_proveedor'));
    // var inputValue = datos.get("nombre");
    // console.log(inputValue);
  var url =  "/saveproveedor";
  fetch(url, {
  method: 'post',
  body: datos
  })
  .then(data => data.json())
  .then(data =>{
    //console.log('Success:', data);
    if (data.estado == 1) {
      //toastr.success(data.mensaje);
      msgSuccess(data.mensaje);
      document.getElementById('save_proveedor').reset();
      myModalsaveprovider.hide();
      idbuttonproveedor.disabled = false;
      idbuttonproveedor.innerHTML = "Guardar";
      refresh_table_provider();    
    }else if (data.estado == 0) {
      toastr.error(data.mensaje);
      idbuttonproveedor.disabled = false;
      idbuttonproveedor.innerHTML = "Guardar";
    }else if (data.estado == "errorvalidacion") {
        //console.log(data);
        mensaje_error_save_proveedor(data);
        idbuttonproveedor.disabled = false;
        idbuttonproveedor.innerHTML = "Guardar";
    }
    // var contenido = document.querySelector("#contenidoform");
    // contenido.innerHTML = `${data}`;
  })
  .catch(function(error){
    console.error('Error:', error)
    idbuttonproveedor.disabled = false;
    idbuttonproveedor.innerHTML = "Guardar";

  });
   
});

/**FUNCTION DISPLAYED BY THE MODAL WINDOW*/
const idmodalsaveprovider = document.querySelector("#ModalSaveProveedor");
const myModalsaveprovider = new bootstrap.Modal(idmodalsaveprovider);
const btnshowmodalp = document.querySelector("#btnshowmodalprovider");
btnshowmodalp.addEventListener('click', (e) =>{
  e.preventDefault();
  myModalsaveprovider.show();
});


/**FUNCTION THAT DISPLAY ERRORS */
const mensaje_error_save_proveedor = data => {
    var errores = document.querySelector(".print-save-error-msg");
    errores.innerHTML = "";
    errores.style.display = "block";
    const mensaje_validacion_provider = data.mensaje;
    mensaje_validacion_provider.forEach(element => {
        errores.innerHTML += "<li>" + element + "</li>";
    });
    window.setTimeout(function() {
        const diverror = document.querySelector(".print-save-error-msg");
        diverror.style.display = "none";
    }, 3000);
};

/**FUNCTION THAT  OBTAINS THE DATA FROM THE PROVIDER*/
async function edit_provider(id){
  try {
    let response = await fetch('/provider-list/'+id);
    let json = await response.json();
    //console.log(json)
    const idmodalupdateprovider = document.querySelector("#ModalUpdateProvider")
    const myModalUpdateProvider = new bootstrap.Modal(idmodalupdateprovider);

    document.querySelector('#upid').value = json.idproveedor;
    document.querySelector("#upnombre").value = json.nombre;
    document.querySelector('#updireccion').value = json.direccion;
    document.querySelector('#uptelefono').value = json.telefono;
    document.querySelector('#upemail').value = json.email;
           
    myModalUpdateProvider.show()
  } catch (error) {
    alert("OCURRIO UN ERROR. VUELVE A INTENTARLO");   
  }

}

/**FUNCTION THAT UPDATE THE PROVIDER */
const formupdateprovider = document.querySelector("#update_proveedor");
formupdateprovider.addEventListener('submit', (e) =>{
  e.preventDefault();
  const dataupdate = new FormData(formupdateprovider);
    var url = "/updateprovider";
    fetch(url, {
        method:'post',
        body:dataupdate
    })
    .then(data =>data.json())
    .then(data =>{
      //console.log("success :",data);
      if(data.estado == 1) {
        document.querySelector("#modal_update_proveedor").click();
        //toastr.success(data.mensaje);
        msgSuccess(data.mensaje);
        refresh_table_provider(); 
      }else if(data.estado == 0) {
        message_error_update_provider(data);
      }else if (data.estado == "errorvalidacion") {
        message_error_update_provider(data);
      } 
    })
    .catch(function(error){
        console.error("Error", error);
        /*btnupprod.disabled = false;
        btnupprod.innerHTML = "Agregar";*/
    });

});

/**MESSAGES OF ERRORS WHEN UPDATING*/
var message_error_update_provider = (data) => {
    var errores = document.querySelector(".print-update-error-msg");
    errores.innerHTML = "";
    errores.style.display = "block";
    const mensaje_validacion_proveedor= data.mensaje;
    mensaje_validacion_proveedor.forEach(element => {
        // console.log(element);
        errores.innerHTML += "<li>" + element + "</li>";
    });
    window.setTimeout(function() {
      const diverror =  document.querySelector(".print-update-error-msg");
      diverror.style.display="none";
    }, 3000);
};
/**FUNCTION THAT REFRESH TABLE PROVIDER*/
const refresh_table_provider = () =>{
    var TableRefresh = $('#proveedor_table').dataTable(); 
    TableRefresh.fnDraw(false);
}

/*async function delete_provider(id){
  if (confirm('Estas seguro de eliminar el proveedor')) {
    try {
      let response = await fetch('/delete-provider/'+id);
      let json = await response.json();
      if (json.estado == 1) {
        refresh_table_provider();
        toastr.success(json.mensaje);
      }else if(json.estado == 0){
        toastr.error(json.mensaje);
      }
    } catch (error) {
      console.error(error);
      toastr.error(error);

    }
  }
}*/

/**function succes sweetalert2*/
function msgSuccess(msg){
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
    })
    Toast.fire({
    type: 'success',
    title: msg
  });

}
/**class main of providers*/
class proveedor{
  constructor(){}



}

class acciones_proveedor extends proveedor{
  downProvider = async (id) => {
    try {
      let response = await fetch('/delete-provider/'+id);
      let json = await response.json();
      if (json.estado == 1) {
        refresh_table_provider();
        msgSuccess(json.mensaje);
        //toastr.success(json.mensaje);
      }else if(json.estado == 0){
        toastr.error(json.mensaje);
      }
    } catch (error) {
      console.error(error);
      toastr.error(error);

    }
  }
}

const delete_provider = (id) =>{
  Swal.fire({
    title: 'Estas seguro de dar de baja el proveedor?',
    text: "El proveedor no aparecera en el sistema!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      //alert(id);
      const deleteProveedor = new acciones_proveedor();
      deleteProveedor.downProvider(id);
    }

  });
}


/**FUNCTION SIN USAR */
// window.onload = () => {
//   traerdatosproveedor();
  
// }
//https://medium.com/bomb-code-snippets/post-ajax-method-for-laravel-with-fetch-api-vanilla-js-d9fd4742810e

// var traerdatosproveedor = () => {
//     var urlp = "/showproveedor";
//     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//     fetch(urlp, {
//       headers: {
//         // "Content-Type": "application/json",
//         // "Accept": "application/json, text-plain, */*",
//         // "X-Requested-With": "XMLHttpRequest",
//         "X-CSRF-TOKEN": CSRF_TOKEN
//       },
//       method: 'post',
//       // body: CSRF_TOKEN
//     })
//     .then(data => data.json())
//     .then(data =>{
//       console.log('Success:', data);
      
//     })
//     .catch(function(error){
//       console.error('Error:', error)
  
//     });
// }

