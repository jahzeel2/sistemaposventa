const showDetailQuote = document.querySelector("#showDetailQuote");
const detailTotal = document.querySelector("#detailTotal");
const detalleCliente = document.querySelector("#detalle_cliente");
const detalleTipo = document.querySelector("#detalle_tipo");
const detallesFolio  = document.querySelector("#detalles_folio");
const detalleFecha = document.querySelector("#detalle_fecha");
/**GET DATA ON THE QUOTES OF PRODUCTS*/
$(document).ready( function () {
    /*$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });*/
    $(function() {
    $('#quote_table').DataTable({
            "paging": true,
            "autoWidth": false,
           processing: true,
           serverSide: true,
           ajax: {
             url:'/showlistquote',
            type: 'GET',
           },
           columns: [
                   { data: 'id', name: 'id'},
                   { data: 'nombre', name: 'nombre' },
                   { data:'validez', name: 'validez'},
                   { data:'serie', name: 'serie'},
                   { data: 'total', name: 'total'},
                   { data: 'estado', name: 'estado' },
                   {data: 'action', name:'action'}
                 ],
          order: [[0, 'desc']]
        });
    });
});

const getDetailQuote = async (id) => {
    console.log(id);
    let getData = await fetch(`/quote/detail/${id}`);
    let dataDetail = await getData.json();
    console.log(dataDetail);
    console.log(dataDetail.quote);
    detalleCliente.innerHTML = `${dataDetail.quote.nombre}` 
    detalleFecha.innerHTML = `${dataDetail.quote.created_at}`;
    detailTotal.innerHTML = `${dataDetail.quote.total}`;
    detallesFolio.innerHTML = `${dataDetail.quote.serie}`;
    showDetailQuote.innerHTML = "";
    let detail = dataDetail.detail;
    detail.forEach(element => {
        console.log(element);
        showDetailQuote.innerHTML += `
            <tr>
                <td>${element.articulo}</td>
                <td>${element.cantidad}</td>
                <td>${element.precio_venta}</td>
                <td>${element.total}</td>
            </tr>
        `;
    });
    let myModal = new bootstrap.Modal(document.getElementById('ModalDetalleQoute'));
    myModal.show();
}

