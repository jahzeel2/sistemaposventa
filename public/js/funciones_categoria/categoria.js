$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
    $('#categoria_table').DataTable({
           "autoWidth": false,
           processing: true,
           serverSide: true,
           ajax: {
             url:'/showcategoria',
            type: 'GET',
           },
           columns: [
                   { data: 'idcategoria', name: 'idcategoria'},
                   { data: 'nombre', name: 'nombre' },
                   { data: 'descripcion', name: 'descripcion' },
                   {data: 'action', name:'action'}
                 ],
          order: [[0, 'desc']]
        });
    });
});

$(document).ready(function(){
    const idmodalsavecategory = document.querySelector("#ModalCategoria");
    const myModalsavecategory = new bootstrap.Modal(idmodalsavecategory);
    const btnshowmodalsavecategory = document.querySelector("#btnshowmodalcategory");
    btnshowmodalsavecategory.addEventListener('click', (e) =>{
        e.preventDefault();
        myModalsavecategory.show();
    })
    /**GUARDAR LOS DATOS DE LA CATEGORIA*/
    $("#save_categorie").on('submit',function(e){
        e.preventDefault(e);
        var datos = $(this).serialize();
        //alert(datos);
        $("#btnsavecategoria").html('Enviando datos ...')
        url_ingreso = "/savecategoria";
        $.post(url_ingreso,datos,function (result) {
            // var mensaje = result.exito;
            // console.log(mensaje);
            if($.isEmptyObject(result.error)){
                //alert("jajaj"+ data.success);
            }else{
                 /**LLAMA LA FUNCTION Y PINTA LOS ERRORES POSIBLES QUE SE GENEREN EN LA VALIDACION DE EL FORMULARIO */
                 saveprintErrorMsg(result.error);
                 $('#btnsavecategoria').html('Guardar');
                 window.setTimeout(function() { 
                     $(".print-save-error-msg").slideUp(function() { 
                     });
                 },  5000);
            }

            if (result.estado == 1) {
                $('#save_categorie').trigger("reset");
                myModalsavecategory.hide();
                //console.log(result.mensaje);
                var TableRefresh = $('#categoria_table').dataTable(); 
                TableRefresh.fnDraw(false);
                $('#btnsavecategoria').html('Guardar');

            }else if (result.estado == 0) {
                console.log(result.mensaje);
                $('#btnsavecategoria').html('Guardar');
                toastr.error(data.mensaje);
            }
            
        }).fail(function (error) {           
            console.log(error);
            $('#btnsavecategoria').html('Guardar');
            toastr.error("Error: Ocurrio un error inesperado, revisa el codigo");
        });
        
    });

    /**FUNCTION QUE PERMITE ACTUALIZAR LA INFORMACION DE LA CATEGORIA*/
    $("#update_categorie").on('submit', function (e) {
       e.preventDefault(e);
       var updatedatos = $(this).serialize();
        //var uno = document.getElementById('').innerHTML="jajaja";
       $('#btnupdatecategoria').html('Enviando datos ...');
       //alert(updatedatos);
       $.ajax({
            data: updatedatos,
            url: "/categoriaupdate",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                //console.log(data) 
                // document.getElementById('messages-ajax').value = data.error[0];
                // $("#messages-ajax").val(data);
                if($.isEmptyObject(data.error)){
                   //alert("jajaj"+ data.success);
                }else{
                    /**LLAMA LA FUNCTION Y PINTA LOS ERRORES POSIBLES QUE SE GENEREN EN LA VALIDACION DE EL FORMULARIO */
                    updateprintErrorMsg(data.error);
                    $('#btnupdatecategoria').html('Actualizar');
                    window.setTimeout(function() { 
                        $(".print-update-error-msg").slideUp(function() { 
                        });
                    },  5000);
                }
                if (data.estado == 1) {
                    toastr.success(data.mensaje);
                    // var elemento = document.getElementById("message-success");
                    // elemento.className += "alert alert-success";
                    $('#update_categorie').trigger("reset");
                    $('#ModalCategoriaUpdate').modal('hide');
                    var TableRefresh = $('#categoria_table').dataTable();
                    TableRefresh.fnDraw(false);
                    $('#btnupdatecategoria').html('Actualizar'); 
                   
                }else if (data.estado == 0) {
                    toastr.error(data.mensaje);
                    $('#btnupdatecategoria').html('Actualizar');
                }
            },
            error: function (data) {
                $('#btnupdatecategoria').html('Actualizar');
                console.log('Error:', data);
                toastr.error("Error: Ocurrio un error inesperado, revisa el codigo");
                
            }    
       });
       
    });
   
});
/********************************** */
class categoria{
    constructor(){}

    refresh_table_category(){
        var TableRefresh = $('#categoria_table').dataTable(); 
        TableRefresh.fnDraw(false);
    }
}

class acciones_categoria extends categoria{
    delete_categoria = async (url,form) => {
        try {
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let response = await fetch(url, {
            headers: {
                'X-CSRF-TOKEN': token
            },
            method: 'POST',
            body: form
            });
            let data = await response.json();
            //console.log(data);
            let resp = data.estado;
            switch (resp) {
                case 1:
                    Swal.fire(
                        'Exito!',
                        data.mensaje,
                        'success'
                    )
                    super.refresh_table_category();
                    break;
                case 0:
                    alert(data.mensaje);
                    break;
                default:
                    break;
            }
        } catch (error) {
           console.log(error); 
        }
    }
}
/**FUNCTION PARA ELIMINAR LA CATEGORIA*/
const delete_categoria = (id) => {
  Swal.fire({
    title: 'Estas seguro de eliminar la categoria?',
    text: "La categoria ya no estara disponible!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      let url = "/deletecategoria";
      let formdowncategory = new FormData();
      formdowncategory.append('id', id);
      const downcategory = new  acciones_categoria();
      downcategory.delete_categoria(url,formdowncategory);
    }

  });
}

//var delete_categoriass = (id) => {
    //if (confirm('Estas seguro de eliminar la categoria')) {
        //$.ajax({
            //type:'GET',
            //url: '/deletecategoria/'+id,
            //success: function (data) {
                //if (data.estado == 1) {
                    //var TableRefresh = $('#categoria_table').dataTable(); 
                    //TableRefresh.fnDraw(false);
                    //toastr.success(data.mensaje);
                //}else if (data.estado == 0) {
                    //toastr.error(data.mensaje);
                //}
                
            //},
            //error: function (data) {
                //console.log('Error:', data); 
                //toastr.error("Error: Ocurrio un error inesperado, revisa el codigo");
            //}
            
        //});
    //}
//}

/**FUNCION OBTIENE LOS DATOS DE LA CATEGORIA SELECCIONADA EN EL BUTTON*/
var edit_categoria = (id) => {
    //alert('edit '+ id);
    $.get('/categoria-list/'+id, function (data) {
        // $('#CategoriaLabel').html("Editar la categoria");
        $('#ModalCategoriaUpdate').modal('show');
        document.getElementById('upid').value = data.idcategoria;
        document.getElementById('upnombre').value = data.nombre;
        document.getElementById('updescripcion').value = data.descripcion;
        //console.log(data);
    });
}

/**FUNCTION QUE PINTA LOS ERRORES AL ACTUALIZAR INFORMACION*/
var updateprintErrorMsg = (msg) => {
    $(".print-update-error-msg").find("ul").html('');
    $(".print-update-error-msg").css('display','block');
    $.each(msg, function(key, value) {
        $(".print-update-error-msg").find("ul").append('<li>'+value+'</li>');

    });

}
/**FUNCTION QUE PINTA LAOS ERRORES AL GUARDAR LA INFORMACION*/
var saveprintErrorMsg = (msg) => {
    $(".print-save-error-msg").find("ul").html('');
    $(".print-save-error-msg").css('display','block');
    $.each(msg, function(key, value) {
        $(".print-save-error-msg").find("ul").append('<li>'+value+'</li>');

    });

}
