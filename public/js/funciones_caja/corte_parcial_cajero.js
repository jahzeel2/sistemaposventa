//console.log('este esta listo');

/**GET DATA ON THE CAJERO*/
$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
   var table = $('#parcial_table').DataTable({
            "paging": true,
            "autoWidth": false,
           processing: true,
           serverSide: true,
           ajax: {
             url:'/showlistcajeros',
            type: 'GET',
           },
           columns: [
                   { data: 'idcortecaja', name: 'idcortecaja'},
                   { data:'name', name: 'name'},
                   { data:'total_acomulado', name: 'total_acomulado'},
                   { data: 'fecha', name: 'fecha'},
                   {data: 'action', name:'action'}
                 ],
          order: [[0, 'desc']]
        });
  
    /*setInterval( function () {
        table.ajax.reload( null, false ); 
        
    }, 30000 );*/

});

class CorteParcial{
    constructor(form,url){
        this.form=form;
        this.url=url;

    }

}

class Parcial extends CorteParcial{
    Saveform(formu){
        fetch(this.url,{
        method: 'POST', // or 'PUT'
        body: this.form// data can be `string` or {object}!
        })
        .then(data=> data.json())
        .then(data=> {
            //console.log('Success:', data)
            let message = data.mensaje;
            let divclass = data.class;
            if (data.estado == 1) {
                 formu.reset();
                document.getElementById('closemodalparcial').click();
                Swal.fire(
                    'Exito',
                    message,
                    divclass
                )
                this.refresh_table_parcial();
            }else if (data.estado == "errorvalidacion") {
               this.MessageGeneral(message,divclass,"messageformparcial")
            }else if (data.estado == "errorcantidad" ) {
               this.MessageGeneral(message,divclass,"messageformparcial")
            } 
        })
        .catch(function(error){
            console.log('Hubo un problema con la petición Fetch:' + error.message);
        });
         
    }

    MessageGeneral(message,divclass,divmensaje){
        const divmessage = document.querySelector(`#${divmensaje}`);
        divmessage.innerHTML = "";
        divmessage.innerHTML += `
        <div class="alert alert-${divclass} alert-dismissible fade show" role="alert">
                <strong>Mensaje :</strong> <strong>${message}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
        `;
        setTimeout(function(){
            document.querySelector(".alert").remove();
        },5000);
    }

    ShowModal(idmodal,id,inputidapertura){
        /*const divmessage = document.querySelector(`#messageformparcial`);
        divmessage.innerHTML = "";*/
        document.querySelector(inputidapertura).value = id;
        const modalparcial = document.querySelector(idmodal);
        const mymodalparcial =  new bootstrap.Modal(modalparcial);
        mymodalparcial.show();

    }

    StartLoadIcon(button){
        button.innerHTML = "";
        button.disabled = true;
        button.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos...`;
    }

    EndLoadIcon(endbutton,message_end){
        endbutton.disabled = false;
        endbutton.innerHTML = message_end;
    }

    refresh_table_parcial(){
        let TableRefreshProduct = $('#parcial_table').dataTable(); 
        TableRefreshProduct.fnDraw(false);
    }

}

/**FUNCTION THAT SHOW MODAL FOR SAVE THE PARTIAL CUT */
const show_modal_parcial = (id) => {
    //alert("tu id es :"+id)
    const showparcial = new Parcial();
    const inputidaper = "#numparcial";
    showparcial.ShowModal("#ModalCorteParcial",id,inputidaper);
}

const btnsaveparcial = document.querySelector("#btn_save_parcial");
btnsaveparcial.addEventListener('click', (e) =>{
    e.preventDefault();
    /*START ICON RELOAD*/
    const reload = new Parcial();
    reload.StartLoadIcon(btnsaveparcial);
    /**SAVE THE INFORMATION*/
    const formdata = document.querySelector("#save_form_parcial");
    const form = new FormData(formdata);
    let = url = "/saveformparcial";
    let savedata = new Parcial(form,url);
    savedata.Saveform(formdata); 
    /**End RElOAD */
    let message_end = "Aceptar";
    const endl = new Parcial();
    endl.EndLoadIcon(btnsaveparcial,message_end);

});