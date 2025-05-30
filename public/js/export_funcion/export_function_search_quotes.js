export class searchProduct {
    constructor(myurlp, mysearchp, ul_add_lip,idlip,token,printTbody) {
        this.url = myurlp;
        this.mysearch = mysearchp;
        this.ul_add_li = ul_add_lip;
        this.idli = idlip;
        this.pcantidad = document.querySelector("#pcantidad");
        this.array = [];
        this.token = token;
        this.arrayProd = [];
        this.printBody = printTbody;
    }

    inputSearchProduct() {

        this.mysearch.addEventListener("input", async (e) => {
            e.preventDefault();
            console.log("inputSearch");
            let minimo_letras = 0; // minimo letras visibles en el autocompletar
            let valor = this.mysearch.value;
            const statuscheckBarcode = document.querySelector("#barcodeChecked");
            let statuschecked = statuscheckBarcode.checked;
            if (valor.length > minimo_letras && !statuschecked) { 
                let datesearh = new FormData();
                datesearh.append("valor", valor);
                try {
                    let response = await fetch(this.url, {
                        headers: {
                        "X-CSRF-TOKEN": this.token,
                        },
                        method: "post",
                        body: datesearh,
                    });
                    let data = await response.json();
                    console.log(data);
                    this.ShowliProduct(data, valor);
                } catch (error) {
                    console.log(error);
                }
            }else{
                console.log("no valor found")
                this.ul_add_li.style.display = "none";
            }
        });

    }

    ShowliProduct(data, valor) {
        const checkBarcode = document.querySelector("#barcodeChecked");
        let checked = checkBarcode.checked;
        this.ul_add_li.style.display = "block";
        if (data.status == 1) {
            console.log("ddddddddd")
            if (data.getprod != "") {
                let arrayp = data.getprod;
                this.ul_add_li.innerHTML = "";
                let n = 0;
                if (!checked) {
                    console.log("no esta checked")
                    //this.Clearcamposentradaproducto();
                    this.showProduct(arrayp,valor,n);
                    console.log("estado li")
                    this.myOnclick();
                    let adclasli= document.getElementById('1'+this.idli);
                    adclasli.classList.add('selected');
                }
        
            } else {
                //this.Clearcamposentradaproducto();
                this.ul_add_li.innerHTML = "";
                this.ul_add_li.innerHTML += `
                        <li>Sin datos</li>
                    `;
            }
        }
    }

    showProduct(arrayp,valor,n){
        for (let item of arrayp) {
            console.log(item);
            n++;
            let nombre = item.nombre;
            const array = `showproduct*/*/*${item.id}*/*/*${item.codigo}*/*/*${item.nombre}*/*/*${item.pcompra}*/*/*${item.pventa}`;
            this.ul_add_li.innerHTML +=`
            <li id="${n+this.idli}" value="${item.nombre}" name="${array}" class="list-group-item"  style="width:622px;border:1px solid #f1f1f1;">
                    <div class="d-flex flex-row " style="border:1px solid #ccd2db;margin-right:-17px;margin-top:-10px;margin-left:-19px;margin-bottom:-10px;">
                    <div class="p-2 text-center" style="border:1px solid #ccd2db;">
                        <img src="${item.img}" class="img-thumbnail" width="50" height="50" >
                    </div>
                    <div class="p-2">
                            <strong>${nombre.substr(0,valor.length)}</strong>
                            ${nombre.substr(valor.length)}
                            <p class="card-text">P. unitario $ : ${item.pventa}</p>
                    </div>
                    </div>
            </li>
            `;
        }
    }

    myOnclick(){
        console.log("click")
        let listItems = document.querySelectorAll("#autocomplequote li");
        console.log(listItems)
        listItems.forEach((item, index) => {
            item.addEventListener('click', (event) => {
                const textarray = item.getAttribute('name');
                ////console.log(textarray);
                const dividir = textarray.split('*/*/*'); // split string on comma space
                this.variablesProducto(dividir);
                this.ul_add_li.innerHTML = "";
            });
        });
    }

    async variablesProducto(dividir){
        console.log(dividir)
        let detalle = {
            id: dividir[1],
            codigo:dividir[2],
            nombre:dividir[3],
            pcompra:dividir[4],
            pventa:dividir[5]
        }
        console.log(detalle)
        console.log(JSON.stringify(detalle))
        let form = new FormData();
        form.append( "json", JSON.stringify( detalle ) );
        try {
            let response = await fetch("/quote/saveProdTemp", {
                headers: {
                "X-CSRF-TOKEN": this.token,
                },
                method: "post",
                body: form,
                //body: JSON.stringify(detalle),
            });
            let data = await response.json();
            console.log(data);
            let products = data.prod;
            //this.arrayProd = products;
            //console.log(this.arrayProd);
            this.printDataProd(products);
        } catch (error) {
            console.log(error);
        }
        //const getid = document.querySelector("#idarticulo").value = dividir[1];
        //const getcodigo = document.querySelector("#IngresoCodigoArticulo").value = dividir[2];
        //const getnombre = document.querySelector("#pnombrearticulo").value = dividir[3];
        //const getcompra = document.querySelector("#pprecio_compra").value = dividir[4];
        //const getventa = document.querySelector("#pprecio_venta").value = dividir[5];
        //this.mysearch.value = dividir[3];
    }


    InputKeydownEntradas(id_ulp){
        this.mysearch.addEventListener("keydown", (e) =>{
        switch (e.keyCode) {
            case 40:
            e.preventDefault(); // prevent moving the cursor
            const nextkeycode = document.querySelector(id_ulp+" li:not(:last-child).selected");
            if (nextkeycode !=null) {
                //console.log(nextkeycode);
                nextkeycode.classList.remove('selected');
                ////console.log(lisec);
                const  nextli = nextkeycode.nextElementSibling;
                nextli.classList.add('selected');
                ////console.log(nextli.className);
            }
          
            break;
            case 38:
            e.preventDefault(); // prevent moving the cursor
            const prevkeycode = document.querySelector(id_ulp+" li:not(:first-child).selected");
            if (prevkeycode != null) {
                ////console.log(prevkeycode);
                prevkeycode.classList.remove('selected');
                const prevli = prevkeycode.previousElementSibling;
                prevli.classList.add('selected');
            }
            break;
            case 13:
            const checkBarcode = document.querySelector("#barcodeChecked");
            let checked = checkBarcode.checked;
            if (checked) {
                let datesearh = new FormData();
                datesearh.append("valor", this.mysearch.value);
                fetch(this.url, {
                headers: {
                    "X-CSRF-TOKEN": this.token,
                },
                method: "post",
                body: datesearh,
                })
                .then(response => response.json())
                .then(result => {
                    console.log(result)
                    let findprod = result.getprod[0];
                    const array = `showproduct*/*/*${findprod.id}*/*/*${findprod.codigo}*/*/*${findprod.nombre}*/*/*${findprod.pcompra}*/*/*${findprod.pventa}`;
                    console.log(array)
                    const dividirp = array.split('*/*/*'); // split string on comma space
                    this.variablesProducto(dividirp);
                    //this.Variablesentradaproducto(dividirp);
                    //document.querySelector("#pcantidad").value="1.00";
                    //document.querySelector("#btn_addentradas").click();
                    const quoteProduct = document.querySelector("#buscarQuoteProducto");
                    quoteProduct.value = "";
                    quoteProduct.focus();
                })
           
            }else{
                e.preventDefault();
                ////console.log("se deshabiloto")
                const liselected = document.querySelector(id_ulp+'>.selected');
                //const text = liselected.textContent;
                const textarray = liselected.getAttribute('name');
                const dividir = textarray.split('*/*/*'); // split string on comma space
                ////console.log(dividir);
                const validar = dividir[0];
                switch (validar) {
                case "showproduct":
                    this.variablesProducto(dividir);
                    document.querySelector(id_ulp).innerHTML = "";
                    const quoteProduct = document.querySelector("#buscarQuoteProducto");
                    quoteProduct.value = "";
                    quoteProduct.focus();
                    
                break;
                default:
                break;
                }
                return false;
            }
            break;
            default:
            break;
        }
        });
    }


    printDataProd = (products) => {
        const totalQuote = document.querySelector("#total_quote");
        const print = document.querySelector("#tbodyProd");
        let total = 0;
        print.innerHTML = "";
        products.forEach((element, index) => {
            console.log(element);
            total = total + Number(element.total);
            print.innerHTML += `
                <tr>
                <td>${index + 1}</td>
                <td>${element.nombre}</td>
                <td><input type="text" value="${element.cantidad}" id="cantidad${element.id}" onkeydown="fnInputEnter(event,${element.id},'cantidad');" class="input-table form-control form-control-sm" placeholder="0.00"></td>
                <td><input type="text" value="${element.precio}" id="precio${element.id}" class=" input-table form-control form-control-sm" placeholder="0.00" readonly></td>
                <td><input type="text" value="${element.total}" class=" input-table form-control form-control-sm" placeholder="0.00" readonly></td>
                <td class="text-center"><button type="button" onclick="downProd(${element.id});" class="btn btn-danger btn-sm delete_btn_prod_venta"><i class="fas fa-trash-alt"></i></button></td>
                </tr>
            `;
        });
        totalQuote.value = total;
    }

    //clearcamposentradaproducto();
}