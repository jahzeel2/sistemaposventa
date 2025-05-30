export class SearchProducto {
  constructor(myurlp, mysearchp, ul_add_lip,idlip) {
    this.url = myurlp;
    this.mysearch = mysearchp;
    this.ul_add_li = ul_add_lip;
    this.idli = idlip;
    this.pcantidad = document.querySelector("#pcantidad");
    this.array = [];
  }

  InputSearchProduct() {
    this.mysearch.addEventListener("input", (e) => {
      e.preventDefault();
      try {
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        let minimo_letras = 0; // minimo letras visibles en el autocompletar
        let valor = this.mysearch.value;
        //console.log(valor.length);
        
        const statuscheckBarcode = document.querySelector("#barcodeChecked");
        let statuschecked = statuscheckBarcode.checked;
        
        if (valor.length > minimo_letras && !statuschecked) {
          let datesearh = new FormData();
          datesearh.append("valor", valor);

          fetch(this.url, {
            headers: {
              "X-CSRF-TOKEN": token,
            },
            method: "post",
            body: datesearh,
          })
            .then((data) => data.json())
            .then((data) => {
              //console.log("Success:", data);
              this.ShowliProduct(data, valor);
              this.array = data.getprodent;
              //console.log(this.array)

            })
            .catch(function (error) {
              console.error("Error:", error);
            });
        } else {
          this.ul_add_li.style.display = "none";
        }
      } catch (error) {}
    });
  }

  ShowliProduct(data, valor) {
    const checkBarcode = document.querySelector("#barcodeChecked");
    let checked = checkBarcode.checked;
    this.ul_add_li.style.display = "block";
    if (data.estado == 1) {
      if (data.getprodent != "") {
        let arrayp = data.getprodent;
        this.ul_add_li.innerHTML = "";
        let n = 0;
        if (!checked) {
          this.Clearcamposentradaproducto();
          this.Showproductentradas(arrayp,valor,n);
          this.myonclickentrada();
          let adclasli= document.getElementById('1'+this.idli);
          adclasli.classList.add('selected');
        
        }
        
      } else {
        this.Clearcamposentradaproducto();
        this.ul_add_li.innerHTML = "";
        this.ul_add_li.innerHTML += `
                <li>Sin datos</li>
            `;
      }
    }
  }

  Showproductentradas(arrayp,valor,n){
    for (let item of arrayp) {
        n++;
        let nombre = item.nombre;
        const array = `showproductoingreso*/*/*${item.id}*/*/*${item.codigo}*/*/*${item.nombre}*/*/*${item.pcompra}*/*/*${item.pventa}`;
        this.ul_add_li.innerHTML +=`
        <li id="${n+this.idli}" value="${item.nombre}" name="${array}" class="list-group-item"  style="width:622px;border:1px solid #f1f1f1;">
                <div class="d-flex flex-row " style="border:1px solid #ccd2db;margin-right:-17px;margin-top:-10px;margin-left:-19px;margin-bottom:-10px;">
                <div class="p-2 text-center" style="border:1px solid #ccd2db;">
                    <img src="${item.img}" class="img-thumbnail" width="50" height="50" >
                </div>
                <div class="p-2">
                        <strong>${nombre.substr(0,valor.length)}</strong>
                        ${nombre.substr(valor.length)}
                        <p class="card-text">P. compra $ : ${item.pcompra}</p>
                </div>
                </div>
        </li>
        `;
    }
  }

  myonclickentrada(){
    let listItems = document.querySelectorAll("#autocompleteentrada li");
    listItems.forEach((item, index) => {
        item.addEventListener('click', (event) => {
            const textarray = item.getAttribute('name');
            ////console.log(textarray);
            const dividir = textarray.split('*/*/*'); // split string on comma space
            this.Variablesentradaproducto(dividir);
            this.ul_add_li.innerHTML = "";
        });
    });
  }

  Variablesentradaproducto(dividir){
    const getid = document.querySelector("#idarticulo").value = dividir[1];
    const getcodigo = document.querySelector("#IngresoCodigoArticulo").value = dividir[2];
    const getnombre = document.querySelector("#pnombrearticulo").value = dividir[3];
    const getcompra = document.querySelector("#pprecio_compra").value = dividir[4];
    const getventa = document.querySelector("#pprecio_venta").value = dividir[5];
    this.mysearch.value = dividir[3];
  }

  Clearcamposentradaproducto(){
    const getid = document.querySelector("#idarticulo").value = '';
    const getcodigo = document.querySelector("#IngresoCodigoArticulo").value = '';
    const getnombre = document.querySelector("#pnombrearticulo").value = '';
    const getventa = document.querySelector("#pprecio_venta").value = '';
    const getcompra = document.querySelector("#pprecio_compra").value = '';
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
            let token = document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content");
            let datesearh = new FormData();
            datesearh.append("valor", document.querySelector("#BuscarEntradaProducto").value);
            fetch(this.url, {
              headers: {
                "X-CSRF-TOKEN": token,
              },
              method: "post",
              body: datesearh,
            })
            .then(response => response.json())
            .then(result => {
              //console.log(result)
              let findprod = result.getprodent[0];
              const array = `showproductoingreso*/*/*${findprod.id}*/*/*${findprod.codigo}*/*/*${findprod.nombre}*/*/*${findprod.pcompra}*/*/*${findprod.pventa}`;
              const dividirp = array.split('*/*/*'); // split string on comma space
              this.Variablesentradaproducto(dividirp);
              document.querySelector("#pcantidad").value="1.00";
              document.querySelector("#btn_addentradas").click();
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
              case "showproductoingreso":
                ////console.log(validar);
                this.Variablesentradaproducto(dividir);
                document.querySelector(id_ulp).innerHTML = "";
                this.pcantidad.focus();
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

  
}
