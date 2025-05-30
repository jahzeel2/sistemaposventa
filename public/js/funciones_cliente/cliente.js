/**GET DATA ON THE CUSTOMER*/
$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
    $('#table_customers').DataTable({
            "paging": true,
            "autoWidth": false,
           processing: true,
           serverSide: true,
           ajax: {
             url:'/showlistcustomers',
            type: 'GET',
           },
           columns: [
                   { data: 'idcliente', name: 'idcliente'},
                   { data:'nombre', name: 'nombre'},
                   { data:'direccion', name: 'direccion'},
                   { data: 'telefono', name: 'telefono'},
                   { data: 'email', name: 'email' },
                   {data: 'action', name:'action'}
                 ],
          order: [[0, 'desc']]
        });
    });
});

class cliente{
    constructor(){
    }

    msg_error(data,errores){
        errores.innerHTML = "";
        errores.style.display = "block";
        const mensaje_validacion_cliente = data.mensaje;
        mensaje_validacion_cliente.forEach(element => {
            errores.innerHTML += '<li>'+element+'</li>';
        });
        window.setTimeout(function() { 
            errores.style.display="none";
        }, 3000);

    }
    refresh_table_clientes(){
        let table_refresh = $("#table_customers").dataTable();
        table_refresh.fnDraw(false);
    }

    msgSuccess(msg){
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
}

class acciones_cliente extends cliente{
    clientes = async (url,form,errorform) =>{
        try {
            let seend = await fetch(url, {
                method:'post',
                body: new FormData(form),
            });

            let data = await seend.json();
            ////console.log(data);
            let resp = data.estado;
            let msg = data.mensaje;
            switch (resp) {
                case 1:
                    super.msgSuccess(msg);
                    //toastr.success(msg);
                    if (data.accion == "save") {
                        //this.form.reset();
                        document.getElementById('btn_hide_save_modal').click();
                        super.refresh_table_clientes();
                    }
                    if (data.accion == "update") {
                        document.getElementById('hide_update_modal').click();
                        super.refresh_table_clientes();
                    }
                break;
                case 0:
                    alert(msg)
                break;
                break;
                case 'errorvalidacion':
                    super.msg_error(data,errorform);
                break;
            
                default:
                break;
            }
        } catch (error) {
            
        }
    }

    getdata = async (ruta,id,idmymodal) => {
        try {
           let response = await fetch(ruta+id); 
           let data = await response.json();
            switch (data.estado) {
                case 1:
                    if (data.accion == 'get_cliente') {
                        this.push_data_form(data);
                        //console.log(data)
                        idmymodal.show();
                    }
                    if (data.accion == 'down_cliente') {
                        ////console.log(data)
                        super.msgSuccess(data.mensaje);
                        super.refresh_table_clientes();
                        //toastr.success(data.mensaje);
                    }
                break;
                case 0:
                   alert(data.mensaje)
                break;
                default:
                    break;
            }
            
        } catch (error) {
            //console.log(error);
        }
    }
    
    push_data_form = (data) => {
        let datos_cliente = data.detalle_cliente;
        for(let item of datos_cliente){
            document.querySelector("#clienteupdate").value=item.idcliente;
            document.querySelector("#updnombre").value=item.nombre;
            document.querySelector("#upddireccion").value=item.direccion;
            document.querySelector("#updtelefono").value=item.telefono;
            document.querySelector("#updemail").value=item.email;
        }
               
    }

    
}

/**this accion save cliente */
const errorform = document.querySelector(".print-save-error-msg");
const formcliente = document.querySelector("#save_cliente");
const btnsaveclie = document.querySelector("#btnsavecliente");
btnsaveclie.addEventListener("click", (e) => {
    e.preventDefault();
    
    let url = "/savecliente";
    const save = new acciones_cliente();
    save.clientes(url,formcliente,errorform);

});

const edit_cliente = (id) => {
    let idmodalupdate = document.querySelector("#ModalUpdateCliente");
    const idmymodal = new bootstrap.Modal(idmodalupdate);
    //mymodalupdate.show();

    let getuser = new acciones_cliente();
    getuser.getdata("/get-data-cliente/",id,idmymodal);
}
/** */

const errorupdform = document.querySelector(".print-update-error-msg");
const formupdcliente = document.querySelector("#update_cliente");
const btnupdclie = document.querySelector("#btnupdatecliente");
btnupdclie.addEventListener("click", (e) =>{
    e.preventDefault();
    let url = "/updatecliente";
    const update = new acciones_cliente();
    update.clientes(url,formupdcliente,errorupdform);
});

const down_cliente = (id) =>{
    Swal.fire({
        title: 'Estas seguro de dar de baja el cliente?',
        text: "El cliente no aparecera en el sistema!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        if (result.value) {
            //alert(id);
            let ruta = "/down-cliente/";
            let idmymodal = "";
            const downcliente = new  acciones_cliente();
            downcliente.getdata(ruta,id,idmymodal);
        }

    });
}
