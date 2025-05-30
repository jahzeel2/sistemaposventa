export class Search{
    constructor(myurl,mysearch,ul_add_li,idli){
        this.url = myurl;
        this.mysearch = mysearch;
        this.ul_add_li = ul_add_li;
        this.idli = idli;
        this.pcantidad = document.querySelector("#pcantidad");
    }

    Inputsearch(){

        this.mysearch.addEventListener("input", (e) =>{
            e.preventDefault();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
            let minimo_letras = 0; // minimo letras visibles en el autocompletar
            let valor = this.mysearch.value;
            switch (this.idli) {
                case "prodventa":
                    const statuscheckBarcode = document.querySelector("#barcodeChecked");
                    let statuschecked = statuscheckBarcode.checked;
                    if (valor.length > minimo_letras && !statuschecked) {
                        let datos = new FormData();
                        datos.append("valor", valor);
                        ////console.log(valor);
                        fetch(this.url, {
                            headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN// <--- aquí el token de seguridad.
                            },
                            method:'post',
                            body:datos
                        })
                        .then(data => data.json())
                        .then(data => {
                            //console.log('Success:', data);
                            this.Showli(data,valor);
                        })
                        .catch(function(error){
                            console.error('Error:', error)
                        });
                    }else{
                        this.ul_add_li.style.display = "none";
                    }
                break;
                case "proveedor":
                    if (valor.length > minimo_letras) {
                        let datos = new FormData();
                        datos.append("valor", valor);
                        ////console.log(valor);
                        fetch(this.url, {
                            headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN// <--- aquí el token de seguridad.
                            },
                            method:'post',
                            body:datos
                        })
                        .then(data => data.json())
                        .then(data => {
                            //console.log('Success:', data);
                            this.Showli(data,valor);
                        })
                        .catch(function(error){
                            console.error('Error:', error)
                        });
                    }else{
                        this.ul_add_li.style.display = "none";
                    }
                break;
                default:
                    break;
            }
            function seend() {
                
        
               
            }
        });

    }

    Showli(data,valor){
        //console.log(data)
        this.ul_add_li.style.display = "block";
        if (data.alldata != "") {
            const checkBarcode = document.querySelector("#barcodeChecked");
            let checked = checkBarcode.checked;
            let arr = data.alldata;
            this.ul_add_li.innerHTML="";
            let n = 0;
            if (data.modulo == "venta") {
                this.Clearcamposproductoventa();

                if (!checked) {//if esta checked se utiliza para el lector de codigo de barras
                    document.querySelector("#pcantidad").value="";
                    this.Showproductoventa(arr,valor,n);
                    this.myonclickventa();
                }
            }else if (data.modulo == "proveedor") {
                /**no aplica para el provedor esta function comentada*/
                //this.CLearcamposproveedor();
                this.Showproveedor(arr,valor,n);
                this.myonclickproveedor();
                

            }

            switch (this.idli) {
                case "prodventa":
                    if (!checked) {//si no esta checked
                        let adclasli= document.getElementById('1'+this.idli);
                        adclasli.classList.add('selected');
                    }
                break;
                case "proveedor":
                    let adclasli= document.getElementById('1'+this.idli);
                    adclasli.classList.add('selected');
                break;    
            
                default:
                    break;
            }
        }else{
            switch (data.modulo) {
                case "venta":
                    this.Clearcamposproductoventa();
                break;
                case "proveedor":
                    this.CLearcamposproveedor();
                break;
                default:
                break;
            }
            this.ul_add_li.innerHTML="";
            this.ul_add_li.innerHTML +=`
                <li>Error: El producto no existe!</li>
            `;
        }
    }
    Showproductoventa(arr,valor,n){
        for (let item of arr) {
            n++;
            let nombre = item.nombre;
            const array = `showproductoventa*/*/*${item.id}*/*/*${item.codigo}*/*/*${item.nombre}*/*/*${item.iva}*/*/*${item.venta}*/*/*${item.stock}*/*/*${item.descuento}`;
            this.ul_add_li.innerHTML +=`
            <li id="${n+this.idli}" value="${item.nombre}" name="${array}" class="list-group-item"  style="width:622px;">
                <div class="d-flex flex-row shadow-lg rounded" style="margin-right:-17px;margin-top:-10px;margin-left:-19px;margin-bottom:-10px;">
                <div class="p-2 text-center" style="border:1px solid white;">
                    <img src="${item.img}" class="img-thumbnail" width="50" height="50" >
                </div>
                <div class="" style="margin-left:5px;">
                    <strong style="color:#12CB98;">${nombre.substr(0,valor.length)}</strong>
                    ${nombre.substr(valor.length)}
                    <p class="card-text">P. venta $ : ${item.venta}<br>Stock : ${item.stock}</p>
                </div>
                </div>
            </li>
            `;
        }
    }

    Showproveedor(arr,valor,n){
        for (let item of arr) {
            n++;
            let nombre = item.nombre;
            const array = `showproveedor*/*/*${item.id}*/*/*${item.nombre}`;
            this.ul_add_li.innerHTML+=`
                <li id="${n+this.idli}" value="${item.nombre}" name="${array}" class="list-group-item">
                    <div>
                        <strong>${nombre.substr(0,valor.length)}</strong>
                        ${nombre.substr(valor.length)}
                    </div>
                </li>
            `;
        }
    }

    InputKeydown(id_ul){
        this.mysearch.addEventListener("keydown", (e) =>{
            switch (e.keyCode) {
                case 40:
                    e.preventDefault(); // prevent moving the cursor
                    const nextkeycode = document.querySelector(id_ul+" li:not(:last-child).selected");
                    if (nextkeycode !=null) {
                        //console.log(nextkeycode);
                        nextkeycode.classList.remove('selected');
                        ////console.log(lisec);
                        const  nextli = nextkeycode.nextElementSibling;
                        nextli.classList.add('selected');
                        ////console.log(nextli.className);
                    }
                    /*d.classList.add('selected');*/
                    //$('#autocompleteli li:not(:last-child).selected').removeClass('selected').next().addClass('selected');
                break;
                case 38:
                    e.preventDefault(); // prevent moving the cursor
                    const prevkeycode = document.querySelector(id_ul+" li:not(:first-child).selected");
                    if (prevkeycode != null) {
                        ////console.log(prevkeycode);
                        prevkeycode.classList.remove('selected');
                        const prevli = prevkeycode.previousElementSibling;
                        prevli.classList.add('selected');
                    }
                    /*$('#autocompleteli li:not(:first-child).selected').removeClass('selected')
                        .prev().addClass('selected');*/
                break;
                case 13:
                    if (this.idli == "prodventa") {
                        const checkBarcode = document.querySelector("#barcodeChecked");
                        let checked = checkBarcode.checked;
                        if (checked) {
                            console.log("barcode")
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
                            let datesearh = new FormData();
                            datesearh.append("valor", document.querySelector("#BuscarVentaProducto").value);
                            fetch(this.url, {
                            headers: {
                                "X-CSRF-TOKEN": CSRF_TOKEN,
                            },
                            method: "post",
                            body: datesearh,
                            })
                            .then(response => response.json())
                            .then(result => {
                                //console.log(result)
                                let findprod = result.alldata[0];
                                const array = `showproductoventa*/*/*${findprod.id}*/*/*${findprod.codigo}*/*/*${findprod.nombre}*/*/*${findprod.iva}*/*/*${findprod.venta}*/*/*${findprod.stock}*/*/*${findprod.descuento}`;
                                //console.log(array);
                                const dividirp = array.split('*/*/*'); // split string on comma space
                                let stock = Number(dividirp[6]);
                                //console.log(stock);
                                if (stock > 0) {//the add for sale product if stock is greater
                                    this.Variablesproductoventa(dividirp);
                                    document.querySelector("#pcantidad").value="1.00";
                                    document.querySelector("#btn_add_prod_tem_vent").click();
                                }

                            })
                            .catch(function(error){
                                console.error('Error:', error)
                            });
                        }else{
                            console.log("type enter")
                            e.preventDefault();
                            //const navbar = Array.from(document.querySelector('#autocompleteli>.selected'));
                            //////console.log('Get first: ', navbar[0].textContent);
                            const liselected = document.querySelector(id_ul+'>.selected');
                            //const text = liselected.textContent;
                            const textarray = liselected.getAttribute('name');
                            //const livalue = liselected.value;
                            ////console.log(textarray);
                            const dividir = textarray.split('*/*/*'); // split string on comma space
                            ////console.log(dividir);
                            const validar = dividir[0];
                            switch (validar) {
                                case "showproductoventa":
                                    //console.log(dividir);
                                    let stock = Number(dividir[6]);
                                    //console.log(stock);
                                    if (stock > 0) {//the add for sale product if stock is greater
                                        this.Variablesproductoventa(dividir);
                                        document.querySelector(id_ul).innerHTML = "";
                                        this.pcantidad.focus();
                                    }
                                break;
                                default:
                                    break;
                            }
                            return false;

                        }
                        
                    }
                    if (this.idli == "proveedor") {
                         //const navbar = Array.from(document.querySelector('#autocompleteli>.selected'));
                        //////console.log('Get first: ', navbar[0].textContent);
                        const liselected = document.querySelector(id_ul+'>.selected');
                        //const text = liselected.textContent;
                        const textarray = liselected.getAttribute('name');
                        //const livalue = liselected.value;
                        ////console.log(textarray);
                        const dividir = textarray.split('*/*/*'); // split string on comma space
                        ////console.log(dividir);
                        const validar = dividir[0];
                        this.Variablesproveedor(dividir);
                        document.querySelector(id_ul).innerHTML = "";
                        switch (validar) {
                            case "showproveedor":
                                ////console.log(validar);
                            break;
                            default:
                            break;
                        }
                        return false;
                    }
                break;
            }
        });
    }

    Variablesproductoventa(dividir){
        const getid = document.querySelector("#idarticulo").value = dividir[1];
        const getcodigo = document.querySelector("#CodigoArticulo").value = dividir[2];
        const getnombre = document.querySelector("#NombreArticulo").value = dividir[3];
        const getiva = document.querySelector("#iva").value = dividir[4];
        const getventa = document.querySelector("#pvprecio_venta").value = dividir[5];
        const getstock = document.querySelector("#pvstock").value = dividir[6];
        const getdescuento = document.querySelector("#pvdescuento").value = dividir[7];
        this.mysearch.value = dividir[3];
    }

    Clearcamposproductoventa(){
        const getid = document.querySelector("#idarticulo").value = "";
        const getcodigo = document.querySelector("#CodigoArticulo").value = "";
        const getnombre = document.querySelector("#NombreArticulo").value = "";
        const getiva = document.querySelector("#iva").value = "";
        const getventa = document.querySelector("#pvprecio_venta").value = "";
        const getstock = document.querySelector("#pvstock").value = "";
        const getdescuento = document.querySelector("#pvdescuento").value = "";
    }
    Variablesproveedor(dividir){
        const getidproveedor =  document.querySelector("#idproveedor").value = dividir[1];
        this.mysearch.value = dividir[2];
    }

    CLearcamposproveedor(){
        const getidproveedor =  document.querySelector("#idproveedor").value = "";
        this.mysearch.value = "";
    }

    
    myonclickventa(){
        let listItems = document.querySelectorAll("#autocompleteventa li");
        //console.log(listItems)

        //let idSelectedList = "";
        listItems.forEach((item, index) => {
            //console.log(item);
            //idSelectedList = item.id;
            item.addEventListener('click', (event) => {
                //console.log("selected");
                const textarray = item.getAttribute('name');
                //console.log(textarray);
                const dividir = textarray.split('*/*/*'); // split string on comma space
                //console.log(dividir);
                let stock = Number(dividir[6]);
                ///console.log(stock);
                if (stock > 0) {//the add for sale product if stock is greater
                    this.Variablesproductoventa(dividir);
                    this.ul_add_li.innerHTML = "";
                }
            });
        });
        //console.log("the last id: " +idSelectedList);
       
    }   

    myonclickproveedor(){
        let listItems = document.querySelectorAll("#autocompleteli li");
        listItems.forEach((item, index) => {
            item.addEventListener('click', (event) => {
                const textarray = item.getAttribute('name');
                ////console.log(textarray);
                const dividir = textarray.split('*/*/*'); // split string on comma space
                ////console.log(dividir);
                this.Variablesproveedor(dividir);
                this.ul_add_li.innerHTML = "";
            });
        });
    }

}
