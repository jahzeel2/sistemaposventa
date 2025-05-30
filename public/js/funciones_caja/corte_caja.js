$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
   var table = $('#table_corte_dia').DataTable({ 
            "paging": true,
            "autoWidth": false,
           processing: true,
           serverSide: true,
           ajax: {
             url:'/showlistcortes',
            type: 'GET',
           },
           columns: [
                   { data: 'idapertura', name: 'idapertura'},
                   { data:'name', name: 'name'},
                   { data:'cantidad_inicial', name: 'cantidad_inicial'},
                   { data: 'fecha_hora', name: 'fecha_hora'},
                   { data: 'estatus', name: 'estatus'},
                   {data: 'action', name:'action'}
                 ],
          order: [[0, 'desc']]
        });

});

class CorteCaja{
    constructor(form,url){
        this.form=form;
        this.url=url;
    }

}

/**MY CLASS EXTENDS OF CorteCaja */
class Caja extends CorteCaja{
    Savedata(){
        fetch(this.url,{
            method:"post",
            body:this.form

        })
        .then(data => data.json())
            .then(data => {
                console.log("success:", data);
                let message = data.mensaje;
                let divclass = data.class;
                if (data.estado == 1) {
                    document.getElementById('close_box_curt').click();
                    /*Swal.fire(
                        'Exito',
                        message,
                        divclass
                    )*/
                    this.refresh_table_cortes();
                    
                    document.querySelector("#date_operation").textContent = data.cierre;
                    document.querySelector("#name_cajero").textContent = data.name_cajero;
                    document.querySelector("#fondo_caja").textContent = data.inicio;
                    document.querySelector("#efectivo_caja").textContent = data.final;
                    document.querySelector("#sale_efectivo").textContent = data.total;
                    let datafaltante = document.querySelector("#faltante_caja");
                    datafaltante.textContent = data.faltante;
                    let datasobrante = document.querySelector("#sobrante_caja");
                    datasobrante.textContent = data.sobrante;
                    let textfaltante = data.faltante;
                    if (textfaltante > 0) {
                       datafaltante.style.color="red";
                    }else{
                        datasobrante.style.color="green";
                    }
                    document.querySelector("#idaper").value = data.apert;

                    const modaldetalle = document.querySelector("#detalle-corte-Modal");
                    const myModaldetalle = new bootstrap.Modal(modaldetalle);
                    myModaldetalle.show();
                }
                if (data.estado == 0) {
                    this.MessageGeneral(message,divclass,"messageform");
                }else if (data.estado == "errorvalidacion") {
                    this.MessageGeneral(message,divclass,"messageform");
                } 
            })
        .catch(function(error) {
            console.log('Hubo un problema con la petición Fetch:' + error.message);
        });

    }

    ShowModal(idmodal,id,idapertura){
        document.querySelector(idapertura).value = id;
        const modalcaja = document.querySelector(idmodal);
        const myModalCaja = new bootstrap.Modal(modalcaja);
        myModalCaja.show();
    }

    HideModal(idclosemodal){
        document.getElementById(`${idclosemodal}`).click();
    }

    MessageGeneral(message,divclass,divmensaje){
        //const divm = document.querySelector(`#${divmensaje}`);
        //console.log('erooooooooooo');
        //console.log(message+divclass);
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

    StartLoadIcon(button){
        button.innerHTML = "";
        button.disabled = true;
        button.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos...`;
    }

    EndLoadIcon(endbutton,message_end){
        endbutton.disabled = false;
        endbutton.innerHTML = message_end;
    }

    refresh_table_cortes(){
        let TableRefreshCorte = $('#table_corte_dia').dataTable();
        TableRefreshCorte.fnDraw(false);
    }

}


/**FUNCTION THAT SHOW THE MODAL FOR SAVE*/
const show_modal_corte = (id) =>{
    //console.log(id)
    const showmodal = new Caja();
    const idapertura = "#numapertura"
    showmodal.ShowModal("#ModalCorte",id,idapertura);
}

const btnsavebox = document.querySelector("#btn_save_box_curt");
btnsavebox.addEventListener('click', (e)=>{
    e.preventDefault();
    const reload = new Caja();
    reload.StartLoadIcon(btnsavebox);
    const formdata = document.querySelector("#save_form_corte_caja");
    const form = new FormData(formdata);
    let url ="/savecortecaja";
    let savebox = new Caja(form,url);
    savebox.Savedata();
    /**END RELOAD*/
    let message_end = "Aceptar";
    const endloadmodal = new Caja();
    endloadmodal.EndLoadIcon(btnsavebox,message_end);

});

/**Download corte of box*/
/*let btndownload = document.querySelector("#btn-download-corte-caja");
btndownload.addEventListener("click", (e) =>{
    e.preventDefault();

});*/




/*const ticket = document.querySelector("#tick");
ticket.addEventListener("click", (e) =>{
    e.preventDefault();
    var url = '/ticketcorte';
        fetch(url,{
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:"post",
        })
        .then(data => data.json())
        .then(data=> {
             
            
        })
        .catch(error => console.error('Error:', error))
    
});*/
