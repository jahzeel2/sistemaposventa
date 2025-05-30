/**GET DATA ON THE SALES OF PRODUCTS*/
$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
    $('#ventas_table').DataTable({
            "paging": true,
            "autoWidth": false,
           processing: true,
           serverSide: true,
           ajax: {
             url:'/showlistventas',
            type: 'GET',
           },
           columns: [
                   { data: 'idventa', name: 'idventa'},
                   { data:'fecha_hora', name: 'fecha_hora'},
                   { data:'num_folio', name: 'num_folio'},
                   { data: 'tipo_comprobante', name: 'tipo_comprobante'},
                   { data: 'total_venta', name: 'total_venta' },
                   { data: 'estado', name: 'estado' },
                   {data: 'action', name:'action'}
                 ],
          order: [[0, 'desc']]
        });
    });
});
/*SALES CONSTRUCT*/
class VentasFun{
    constructor(name,id,idmodal){
        this.name= name;
        this.id = id;
        this.modal = idmodal;
    }
}
/**OPTIONS CONSTRUCT*/
class OptionsFunction{

    async ExtractFetch(options, tipo){
        try {
            //console.log(options);
            let response = await fetch(options.name+options.id);
            let json = await response.json();
            //console.log(json);
            if(tipo === "showDetalle"){
                this.PaintTable(json);
                let myModal = options.modal;
                this.ShowModalDetalle(myModal);
            }

            if (tipo === "printTicket") {
                console.log(json);
                this.reimpresionTicket(json);
            }

           
        } catch (error) {
            console.log("Ocurrio un error", error);
        }
    }
    ShowModalDetalle(myModal){
        const idmodaldetalleventa = document.querySelector(myModal);
        const myModaldetalleventa = new bootstrap.Modal(idmodaldetalleventa);

        myModaldetalleventa.show();
    }

    PaintTable(json){
        const art = json.detalles;
        let idtbody = document.querySelector("#show_details_sale");
        idtbody.innerHTML = "";
        for(let item of art){
            idtbody.innerHTML += `
                <tr>
                    <td>${item.articulo}</td>
                    <td>${item.cantidad}</td>
                    <td>${item.precio_venta}</td>
                    <td>${item.descuento}</td>
                    <td>${item.subtotal}</td>
                </tr>
            
            `;
        } 
        const dcli = document.querySelector("#detalle_cliente");
        dcli.innerHTML = json.result.nombre;
        const dtipo = document.querySelector("#detalle_tipo");
        dtipo.innerHTML = json.result.tipo_comprobante;
        const dfolio= document.querySelector("#detalles_folio");
        dfolio.innerHTML = json.result.num_folio;
        const dtotales = document.querySelector("#details_total_sale");
        dtotales.innerHTML = json.result.total_venta;
    }

    reimpresionTicket(data){
        console.log(data);
        let settings = data.settings;
        document.querySelector("#nomempresa").textContent = `${settings.name}`;
        document.querySelector("#telefono").textContent = `Telefono ${settings.phone}`;
        document.querySelector("#adress").textContent = `${settings.adress}`;
        document.querySelector("#cajero").textContent = `Cajero ${data.result.name}`;        
        document.querySelector("#sale_folio").textContent = `Folio ${data.result.num_folio}`;        
        document.querySelector("#sale_date").textContent =  `Fecha ${data.result.fecha_hora}`;        
        document.querySelector("#sale_cliente").textContent = `Cliente ${data.result.nombre}`;
        document.querySelector("#sale_total").textContent = data.result.total_venta;        
        document.querySelector("#sale_efectivo").textContent = data.result.efectivo;        
        let cambio = data.result.efectivo - data.result.total_venta 
        document.querySelector("#sale_cambio").textContent = cambio;        
        let saledetail =  data.detalles;
        let tbodyDetails = document.querySelector("#tbodydetails");
        tbodyDetails.innerHTML = ``;
        saledetail.forEach(row => {
            tbodyDetails.innerHTML += `
                <tr style="
                    border-top: 1px solid black;
                    border-collapse: collapse;
                    font-size: 10px;
                ">
                <th scope="row">${row.cantidad}</th>
                <td>${row.articulo}</td>
                <td>${row.precio_venta}</td>
                <td>${row.subtotal}</td>
                </tr>
            `;
            
        });



        let reimprimirContents = document.querySelector("#reimprimirTicket").innerHTML;
        let reimprimiriFrame = document.getElementById('print-iframe-reimprimir');
        reimprimiriFrame.contentDocument.body.innerHTML = reimprimirContents;
        reimprimiriFrame.focus();
        reimprimiriFrame.contentWindow.print();
    }
}

/**FUNCION THAT SHOW THE DETAILS OF THE SALES */
function obtener_detalle_venta(id){
    //create a new Object Venta
    const options = new VentasFun("/venta-detalle/",id,"#ModalDetalleVenta");
    //create a new OptionsFUnction
    let tipo = "showDetalle";
    const showmodaldata = new OptionsFunction();
    showmodaldata.ExtractFetch(options, tipo);
    //user.ShowModalDetalle();
}

const obtener_print_detalle_venta = (id) => {
    //create a new Object Venta
    const options = new VentasFun("/venta-detalle-print/",id,"");
    //create a new OptionsFUnction
    let tipo = "printTicket";
    const showmodaldata = new OptionsFunction();
    showmodaldata.ExtractFetch(options, tipo);
}
