//the example database sales ---> https://www.youtube.com/watch?v=22DVuSmQpNw

class SaleReturn{
    constructor(rutaname,folio){
        this.rutaname = rutaname;
        this.folio = folio;
    }

}

class OptionSale{
    async FolioProduct(options,endbutton){
        try {

           //console.log(options)
           let response = await fetch(options.rutaname+options.folio); 
           let jsondev = await response.json();
           console.log(jsondev);
            let mess = jsondev.mensaje;
            let clasdiv=jsondev.class;
            let message_end = "<i class='fas fa-search'></i> Buscar";
           if (jsondev.estado == 0) {
               this.EndLoadIcon(endbutton,message_end);
               this.MessagesGeneral(mess,clasdiv);
               this.CLeartable();
               return false;
           }else if (jsondev.estado == null) {
               this.EndLoadIcon(endbutton,message_end);
               this.MessagesGeneral(mess,clasdiv);
               this.CLeartable();
               return false;
           }else if (jsondev.estado == 1) {
               this.PaintTableDevolucion(jsondev);           
           }
        
        } catch (error) {
            console.log(error);
        }
    }

    PaintTableDevolucion(jsondev){
        const devarticle = jsondev.detalles;
        const idventa = jsondev.getventa.idventa;
        const aper = jsondev.onlyapecaja;
        //console.log(idventa)
        let idbodydev = document.querySelector("#tbodydevoluciones");
        idbodydev.innerHTML = "";
        let num = 0;
        for(let item of devarticle){
            num++;
            idbodydev.innerHTML += `
                <tr>
                    <td hidden><input type="number" name="numero[]" class="lectura" value="${item.idarticulo}" readonly></td>
                    <td><input type="text" name="nombre[]" class="form-control lectura" style="width:100%" value="${item.articulo}" readonly></td>
                    <td><input type="number" name="cantidad[]" class="form-control lectura" value="${item.cantidad}" readonly></td>
                    <td><input type="number" name="pventa[]" class="form-control lectura" value="${item.precio_venta}" readonly></td>
                    <td><input type="number" name="descue[]" class="form-control lectura" value="${item.descuento}" readonly></td>
                    <td><input type="number" name="subtotal[]" class="form-control lectura" value="${item.subtotal}" readonly></td>
                    <td>
                       <div class="row">
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input check-dev" name="namecheckdev" type="checkbox" value="${item.idarticulo}" id="des${item.idarticulo}" onchange="show_hide_des(this.value,this.checked)">
                                <label class="form-check-label">
                                    Si
                                </label>
                            </div>
                        </div>
                        <div class="col-md-10">

                            <select style="display:none;" name="descripcion[]" class="form-control select-tipo-devolucion" id="${item.idarticulo}">
                                <option value="">Elige una opcion</option>
                                <option value="Devolucion a stock">Devolucion a stock</option>
                                <option value="Producto defectuoso">Producto defectuoso</option>
                                <option value="Producto caducado">Producto caducado</option>
                            </select>
                        </div>
                       </div>
                    </td>
                </tr>
            `;
        }
        const inputventa = document.querySelector("#idventades").value = idventa;
        const inputcaja = document.querySelector("#nowcaja").value = aper; 
    }
    
    MessagesGeneral(message,divclass){
        //console.log(message+divclass);
        const divmessage = document.querySelector("#messagedevoluciones");
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
    CLeartable(){
        document.querySelector("#idventades").value = "";
        document.querySelector("#tbodydevoluciones").innerHTML = "";
    }
    Savedevolucion(formdata,urlsave){
        //console.log(formdata);
        //console.log(urlsave);
        fetch(urlsave,{
            method:"post",
            body:formdata

        })
        .then(data => data.json())
        .then(data =>{
            console.log("success:", data);
            let mess = data.mensaje;
            let clasdiv = data.class;
            
            if (data.estado == 1) {
                this.CLeartable();
                this.MessagesGeneral(mess,clasdiv);

            }else if (data.estado == 0) {
                this.MessagesGeneral(mess,clasdiv);
            }else if (data.estado == "errorvalidacion") {
                this.MessagesGeneral(mess,clasdiv);
            }
        })
        .catch(function(error) {
            console.log('Hubo un problema con la petición Fetch:' + error.message);
        });

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
/*LOOK FOR THE FOLIO OF THE SALE*/
const searchventa = document.querySelector("#searchsaledev");
searchventa.addEventListener('click', (e) =>{
    e.preventDefault();
    const reload = new OptionSale();
    reload.StartLoadIcon(searchventa);
    //alert("#jjsjjjs");
    const inputfolio = document.querySelector("#foliosaledev").value;
    const apecajauser = document.querySelector("#nomcaja").value;
    const showerror = new OptionSale();
    if (apecajauser === "") {
        let message_end = "<i class='fas fa-search'></i> Buscar";
        showerror.MessagesGeneral('Error, Necesita seleccionar el usuario de la caja abierta','danger');
        showerror.CLeartable();
        showerror.EndLoadIcon(searchventa,message_end);
        return false;
    }
    if (inputfolio === "") {
        let message_end = "<i class='fas fa-search'></i> Buscar";
        showerror.MessagesGeneral('Error, Necesitas ingresar el folio','danger');
        showerror.CLeartable();
        showerror.EndLoadIcon(searchventa,message_end);
        return false;
    }
    const nowfolio = inputfolio+"|||"+apecajauser;
    const options = new SaleReturn("/products_devolucion/",nowfolio);
    //console.log(options)
    const showproductfolio = new OptionSale();
    showproductfolio.FolioProduct(options,searchventa);
    //console.log(rest);
     let message_end = "Buscar";
    const endreload = new OptionSale();
    endreload.EndLoadIcon(searchventa,message_end);
});
/**FUNCTION THAT SHOW THE INPUT DESCRIPTION*/
const show_hide_des = (value,check) => {
    const inputdescri = document.getElementById(value)
    if (check == true){ 
        inputdescri.style.display= "block";
        //alert(value);
    } else {
        inputdescri.style.display= "none";
        inputdescri.selectedIndex = 0;
    }

}

/*SAVE THE RETURN OF A RODUCTS */
const btnsavedevolucion = document.querySelector("#save_devolucion");
btnsavedevolucion.addEventListener("click", (e) =>{
    e.preventDefault();
    let cont_check = 0;
    const check = document.querySelectorAll('.check-dev');
    check.forEach(element => {
        if (element.checked) {
            cont_check = cont_check+1;
        }
    });
    if (cont_check == 0) {
        //console.log(cont_check);
        const message = new OptionSale();
        message.MessagesGeneral('Error, no ha checkeado un articulo para su devolucion','danger');
        return false;
    }else{
        let contdev = 0;
        const selectdev = document.querySelectorAll('.select-tipo-devolucion');
        selectdev.forEach(element => {
        if(element.value != ""){
                contdev = contdev+1;
        }
        });
        if (contdev == 0) {
            const messagedev = new OptionSale();
            messagedev.MessagesGeneral('Error, No has seleccionado el tipo de devolucion del articulo','danger');
            return false;
        }
    }
    const btnstart = new OptionSale();
    btnstart.StartLoadIcon(btnsavedevolucion);

    setTimeout(() => {
        const formdevolucion = document.querySelector("#save_producto_devolucion");
        const formdata = new FormData(formdevolucion);
        let urlsave = "/savedevolucionproduct";
        const saveprod = new OptionSale();
        saveprod.Savedevolucion(formdata,urlsave);
    
        let message_end = "Realizar devolucion";
        const btnend = new OptionSale();
        btnend.EndLoadIcon(btnsavedevolucion,message_end);

    },2000);
   
});