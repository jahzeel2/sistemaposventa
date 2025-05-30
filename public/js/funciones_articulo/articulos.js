$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
    $('#producto_table').DataTable({
           "autoWidth": false,
           processing: true,
           serverSide: true,
           ajax: {
             url:'/showproducto',
            type: 'GET',
           },
           columns: [
                   { data: 'idarticulo', name: 'idarticulo'},
                   { data:'codigo', name: 'codigo'},
                   { data:'img', name: 'img'},
                   { data: 'nombre', name: 'nombre' },
                   { data: 'stock_producto', name: 'stock_producto' },
                   { data: 'compra', name: 'compra' },
                   { data: 'venta', name: 'venta' },
                   {data: 'action', name:'action'}
                 ],
          order: [[0, 'desc']]
        });
    });
});

class articulo {
  constructor() {}

  msg_error(msg,errorform){
    console.log(msg)
    errorform.innerHTML = "";
    errorform.style.display = "block";
    msg.forEach(element =>{
        errorform.innerHTML += `<li>${element}</li>`;
    });

    setTimeout(() => {
        errorform.style.display = "none";
    }, 3000);
  }
  success_message(msg){
    Swal.fire(
      'Exito',
      msg,
      'success'
    )
  }
  img_preview(inputfile,container,imgpreview){
    inputfile.addEventListener("change", (e) => {
      e.preventDefault();
      const file = inputfile.files[0];
      if (file) {
        const reader = new FileReader();
        reader.addEventListener("load", (e) => {
          e.preventDefault();
          //console.log(reader);
          imgpreview.setAttribute("src", reader.result);
        });
        reader.readAsDataURL(file);
      } else {
        imgpreview.setAttribute("src", "//placehold.it/100?text=IMAGEN");
      }
    });
  }
  refresh_table_product(){
    var TableRefreshProduct = $('#producto_table').dataTable(); 
    TableRefreshProduct.fnDraw(false);
  }
  startLoadIcon(button){
      button.innerHTML = "";
      button.disabled = true;
      button.innerHTML += `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando datos...`;
  }

  endLoadIcon(endbutton,message_end){
      endbutton.disabled = false;
      endbutton.innerHTML = message_end;
        
  }

}

class acciones_articulo extends articulo {
  articulo_main = async (url,form,errorform,imgpreview) => {
    try {
      let seend = await fetch(url, {
        method: "post",
        body: new FormData(form),
      });
      let data = await seend.json();
      console.log(data);
        let resp = data.estado;
        let msg = data.mensaje;
        switch (resp) {
          case 1:
            super.success_message(msg);
            imgpreview.setAttribute("src", "//placehold.it/100?text=IMAGEN");
            form.reset(); 
            super.refresh_table_product();
          break;
          case 0:
             alert(msg);
            break;
          case 'errorvalidacion':
            super.msg_error(msg,errorform);
            break;
          default:
           break;
        }
    } catch (error) {
      console.log(error);
    }
  };

  get_data_product = async (id,mymodal) => {
    let response = await fetch('/product-list/'+id)
    let json = await response.json()
    //console.log(json) 
    document.querySelector("#idprod").value = json.idarticulo;
    document.querySelector('#upnombre').value = json.nombre;
    document.querySelector('#upidcategoria').value = json.categoria_id;
    document.querySelector('#upcodigo').value = json.codigo;
    document.querySelector('#upstock').value = json.stock;
    document.querySelector('#uppcompra').value = json.pcompra;
    document.querySelector('#uppventa').value = json.pventa;
    document.querySelector('#updescripcion').value = json.descripcion;
    let img_actual = json.imagen;
    let imgactual = document.querySelector('#imgactual');
    imgactual.innerHTML="";
    imgactual.innerHTML=`
    <div class="row">
    <div class="col ">
        <div class="form-group">
            <label for="nombre">Cambiar imagen</label>
            <input type="file" name="upimagen" id="upimagen" class="form-control" accept="image/*">
        </div>
    </div>
    <div class="col text-center ">
        <div class="form-group" style="margin-top:8px;">
          <figure class="figure">
            <div class="text-center" id="updimagepreview">
                <img src="//placehold.it/100?text=IMAGEN" class="" id="updpreview" width="90px" height="80px"/>
            </div>
            <figcaption class="figure-caption">Imagen nueva</figcaption>
          </figure>
        </div>
    </div>
    <div class="col text-center ">
        <div class="form-group" style="margin-top:8px;">
          <figure class="figure">
            <img src="../imagenes/articulos/${img_actual}" height="80px" width="90px" class="">
            <figcaption class="figure-caption">Imagen actual</figcaption>
          </figure>
        </div>
    </div>
    </div>
    `;
    document.querySelector('#uparticulo_des').value = json.descuento;
    mymodal.show();

    /**FUNCTION THAT GET THE NAME OF INPUT UPIMAGEN*/
    const updimg = document.querySelector("#upimagen");
    const updpreviewcontainer = document.querySelector("#updimagepreview");
    const updpreviewimage = document.querySelector("#updpreview");
    super.img_preview(updimg,updpreviewcontainer,updpreviewimage);
  }

  update_product = async (url,form,errorform) => {
    try {
      let seend = await fetch(url, {
        method: "post",
        body: new FormData(form),
      });
      let data = await seend.json();
      console.log(data);
      let resp = data.estado;
      let msg = data.mensaje;
      switch (resp) {
        case 1:
          super.success_message(msg);
          document.querySelector("#btn-close-form-modal-product").click();
          super.refresh_table_product();
          //form.reset(); 
          break;
        case 0:
          alert(msg);
          break;
        case "errorvalidacion":
          super.msg_error(msg,errorform);
          break;
        default:
          break;
      }
    } catch (error) {
      console.log(error);
    }
  }

  down_product = async (url,form) => {
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
      console.log(data);
      switch (data.estado) {
        case 1:
          Swal.fire(
            'Exito!',
            data.mensaje,
            'success'
          )
          super.refresh_table_product();
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

  send_data_excel = async (url,form,section_table_products) => {
    try {
      let seend = await fetch(url, {
        method: "post",
        body: new FormData(form),
      });
      let data = await seend.json();
      console.log(data);
      let resp = data.estado;
      let msg = data.mensaje;
      switch (resp) {
        case 1:
          section_table_products.style.display = "block";
          const bodyshow = document.querySelector("#body_show_data_articulos");
          const template = document.querySelector("#template_data_articulos").content;
          let fragment = document.createDocumentFragment();
          let i = 0;
          let data_productos = data.datos;
          data_productos.forEach(element => {
              i++;
              template.querySelector(".auto").textContent = i;
              template.querySelector(".input_categoria").value = data.categoria;
              template.querySelector(".input_codigo").value = element.codigo;
              template.querySelector(".input_name").value = element.name;
              template.querySelector(".input_stock").value = element.stock;
              template.querySelector(".input_compra").value = element.pcompra;
              template.querySelector(".input_venta").value = element.pventa;
              template.querySelector(".input_description").value = element.descripcion;
              template.querySelector(".input_descuento").value = element.descuento;
              const clone = template.cloneNode(true);
              fragment.appendChild(clone);
          });
          bodyshow.appendChild(fragment);
          /*DELETE ROW PRODUCTS */
          const btndeleterow = document.querySelectorAll(".btn-delete-producto");
          //console.log(btndeleterow);
          btndeleterow.forEach(element => {
            element.addEventListener("click", (e) => {
              element.parentElement.parentElement.remove();
              //console.log(element.parentElement.parentElement);
            });
          });
        break;
        case "errorvalidacion":
          let error = document.querySelector(".error-form-upload_file");
          super.msg_error(msg,error);
          break;
        case 0:
          alert(msg);
          break;
        default:
          break;
      }
    } catch (error) {
      console.log(error);
    }
  }

  upload_products_category = async (url,form,section_table_products) => {
    try {
      let seend = await fetch(url, {
        method: "post",
        body: new FormData(form),
      });
      let data = await seend.json();
      console.log(data);
      let resp = data.estado;
      let msgart = data.mensaje;
      switch (resp) {
        case 1:
          const clearbody = document.querySelector("#body_show_data_articulos");
          clearbody.innerHTML = "";
          const formaddexcel = document.querySelector("#form-add-excel");
          formaddexcel.reset();
          section_table_products.style.display = "none";
          super.refresh_table_product();
          super.success_message(msgart);

          break;
        case "error_codigo":
          let code_existent = data.existente;
          code_existent.forEach(element => {
            console.log(element.num_codigo);
            const inputcode = document.querySelectorAll(".input_codigo");
            inputcode.forEach(input => {
              console.log(input.value);
              if (element.num_codigo === input.value) {
                input.style.borderColor = "red";
              }
            });
          });
          break;
        case 0:
          alert(msgart);
          break;
        default:
          break;
      }
    } catch (error) {
      console.log(error);
    }
  }

}
/***section table */
const section_table_products = document.querySelector("#section-table-data-products");

/**PREVIEW IMAGE FORM SAVE ARTICLLE */
const imgupload = document.querySelector("#file");
const previewcontainer = document.querySelector("#imagepreview");
const previewimage = document.querySelector("#preview");
const imgpreviewp = new articulo();
imgpreviewp.img_preview(imgupload,previewcontainer,previewimage);

/**SAVE THE PRODUCT*/
const errorform = document.querySelector(".error-form");
const formsavearticulo = document.querySelector("#save_producto");
let btnsaveproducto = document.querySelector("#btnsaveproducto");
btnsaveproducto.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "/savearticulo";
  const save_art = new acciones_articulo();
  save_art.articulo_main(url,formsavearticulo,errorform,previewimage);

});

/**FUNCTION QUE ME PERMITE OBTENER LA INFORMACION A EDITAR*/
const idmodalupdate = document.querySelector("#ModalUpdateProduct");
const myModalUpdateProd = new bootstrap.Modal(idmodalupdate);
const edit_product = (id) =>{
  const data_product = new acciones_articulo();
  data_product.get_data_product(id,myModalUpdateProd);
}

/**FUNCTION UPDATE FORM PRODUCT */
const upderrorform = document.querySelector(".error-modal-form");
const updformsavearticulo = document.querySelector("#update_one_product");
const btnupdateprod = document.querySelector("#btn_update_prod");
btnupdateprod.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "/updateproduct";
  const update_art = new acciones_articulo();
  update_art.update_product(url,updformsavearticulo,upderrorform);
});

/**DELETE PRODUCT THE LIST*/
const delete_product = (id) => {
  Swal.fire({
    title: 'Estas seguro de dar de baja el articulo?',
    text: "El articulo ya no estara disponible!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      let url = "/delete-product";
      let formdownproduct = new FormData();
      formdownproduct.append('id', id);
      const downproduct = new  acciones_articulo();
      downproduct.down_product(url,formdownproduct);
    }

  });
}

/**SEND FORM UPLOAD FILE EXCEL FROM PRODUCTS TO PREVIEW*/
const formexcel = document.querySelector("#form-add-excel");
const btnaddexcel = document.querySelector("#btnaddfileexcel");
btnaddexcel.addEventListener("click", (e) => {
  e.preventDefault();
  let url = "/send-articulo-excel";
  const sendexcel = new  acciones_articulo();
  sendexcel.send_data_excel(url,formexcel,section_table_products);

});
/**import articulos */
const form_upload_products = document.querySelector("#form-save-products");
const btn_save_products = document.querySelector("#btn-save-products");
btn_save_products.addEventListener("click", (e) => {
  e.preventDefault();
  const start = new articulo();
  start.startLoadIcon(btn_save_products);

  let url = "/save_upload_products";
  const save_products = new acciones_articulo();
  save_products.upload_products_category(url,form_upload_products,section_table_products);

  let message_end = `<i class="fas fa-upload text-success mr-2"></i>Importar`;
  start.endLoadIcon(btn_save_products,message_end);
  
});