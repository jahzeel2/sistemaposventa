
class cajaApertura{
    constructor(){

    }
}

class Apertura{
    ShowModal(idmodal){
        const idmodalg= document.querySelector(`#${idmodal}`);
        const myModalshow = new bootstrap.Modal(idmodalg);
        myModalshow.show();
        
        
    }

    GetDataf(idform){
        const btnsaveform = document.querySelector(`#${idform}`);
        const dataform = new FormData(btnsaveform);
        return dataform;
       
    }

    MessageGeneral(message,divclass){
        const divmessage = document.querySelector("#messageform");
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

    SaveDataForm(idform,idmodal,action){
        let datosf = this.GetDataf(idform);
        var url = '/saveapertura';
        fetch(url,{
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:"post",
            body:datosf
        })
        .then(data => data.json())
        .then(data=> {
             
            let message = data.mensaje;
            let divclass = data.class;
            let hora = data.fecha;
            let nombre= data.nombre;
            let cantidad = data.cantidad;
            if (data.estado == 1) {
                //console.log('Success:', data)
                document.getElementById('cantapertura').value = "";
                document.getElementById('closemodalapertura').click();
                Swal.fire(
                    'Exito',
                    message,
                    divclass
                )
                this.TableDate(nombre,hora,cantidad);
            }else if(data.estado == 0) {
                this.MessageGeneral(message,divclass);
            }else if(data.estado == 2){
                this.MessageGeneral(message,divclass);
            }else if (data.estado == "errorvalidacion") {
                this.MessageGeneral(message,divclass);
            }
            
        })
        .catch(error => console.error('Error:', error));
    }
    
    TableDate(nombre,hora,cantidad){
        const datos_inicial = document.querySelector("#datos_apertura");
        datos_inicial.innerHTML =`
        <div class="card">
            <div class="card-header">
            Registro
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                <div class="group">
                    <label for="">Nombre</label>
                    <h5>${nombre}</h5>
                </div>
                </div>
                <div class="col-md-4">
                <div class="group">
                    <label for="">Hora</label>
                    <h5>${hora}</h5>
                </div>  
                </div>
                <div class="col-md-4">
                <div class="group">
                    <label for="">Cantidad inicial</label>
                    <h5>${cantidad}</h5>
                </div>
                </div>
            </div>
            </div>
        </div>
        `;

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



}

/*SHOW THE MODAL*/
const btncaja = document.querySelector("#btnshowmodalapertura");
btncaja.addEventListener("click", (e) =>{
    e.preventDefault();
    const modalshow = new Apertura();
    var idmodal ="saveModalcaja";
    modalshow.ShowModal(idmodal);
});

/*SAVE APERTURA BOX*/
const savedata = document.querySelector("#btnsaveapertura");
savedata.addEventListener("click", (e) =>{
    e.preventDefault();
    /*START ICON RELOAD*/
    const reload = new Apertura();
    reload.StartLoadIcon(savedata);
    idform = "form_save_apertura";
    var idmodal ="saveModalcaja";
    /**SAVE THE INFORMATION*/
    const saveform = new Apertura();
    saveform.SaveDataForm(idform,idmodal);

    /**End RElOAD */
    let message_end = `<i class="fas fa-check-circle text-success mr-2"></i>Guardar`;
    const end = new Apertura();
    end.EndLoadIcon(savedata,message_end);

});