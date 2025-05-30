$(document).ready(function () {
    //traer_registros();
       
});
function traer_registros(id){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    //console.log('jajajja'+id);
    $.ajax({
        url: '/mostrardetalle',
        type: 'POST',
        data: {_token: CSRF_TOKEN, id: id},
    })
    .done(function(data) {
        //console.log("success");
        // console.log(data.detalles);
        var detalles_art = data.detalles;
        //console.log(detalles_art);
        let res = document.querySelector('#res');
        res.innerHTML = '';
        for (let item of detalles_art) {
            
            //console.log(item.articulo);
            res.innerHTML +=`
                <tr>
                    <td>${item.articulo}</td>
                    <td>${item.cantidad}</td>
                    <td>${item.precio_venta}</td>
                    <td>${item.descuento}</td>
                    <td>${item.subtotal}</td>
                </tr>
            ` 
            
        }

        // console.log(data.result.nombre);
        $("#detalle_cliente").text(data.result.nombre);
        $("#detalle_tipo").text(data.result.tipo_comprobante);
        $("#detalle_serie").text(data.result.serie_comprobante);
        $("#detalles_folio").text(data.result.num_comprobante);
        $("#detalles_total").text("$ "+data.result.total_venta);
        $('#Modal_detalles').modal('toggle'); 
        
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
   
}
