<div id="ticket" >
  <section style="
    text-overflow: ellipsis;
    color:black;
    width: 155px !important;
    max-width: 155px !important;
  ">
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      text-align: center !important;
      align-content: center !important;
    " id=>{{$name}}</p>
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      text-align: center !important;
      align-content: center !important;
      margin-top: -5px !important;
    " id="adress"></p>
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      text-align: center !important;
      align-content: center !important;
      margin-top: -5px !important;
    " >RFC: PAHT771023SD4</p>
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      text-align: center !important;
      align-content: center !important;
      margin-top: -5px !important;
    " id="telefono"></p>
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      text-align: center !important;
      align-content: center !important;
      margin-top: -5px !important;
    " >Horario de Atencion:<br>Lun - Sab 8:00 AM - 18:00 PM</p>
    <hr>
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      margin-top: -4px !important;
    " id="cajero"></p>
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      margin-top: -5px !important;
    " id="sale_folio"></p>
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      margin-top: -5px !important;
    " id="sale_date"></p>
    <p class="centrado" style="
      text-overflow: ellipsis;
      color:black;
      font-size: 10px !important;
      margin-top: -5px !important;
    " id="sale_cliente"></p>
    <table id="content_prod" style="border-collapse: collapse">
        <thead>
            <tr class="tr_table" style="
              text-overflow: ellipsis;
              color:black;
              border-top: 1px solid black;
              border-collapse: collapse;
              font-size: 10px;
              font-weight: 900;
            ">
              <th class="tick_cant" style="width: 20%"><small>CANT</small></th>
              <th class="tick_art" style="width: 30%"><small>ARTICULO</small></th>
              <th class="tick_precio" style="width: 20%"><small>PREC</small></th>
              <th class="tick_total" style="width: 30%"><small>TOTAL</small></th>
            </tr>
        </thead>
        <tbody id="tbody_details">
        </tbody>
        <tfoot style="
        border-collapse: collapse;
        border-top: 1px solid black;
        ">
            <tr class="tr_table" style="
              font-size: 10px;
            ">
              <td class="" colspan="3"><small>TOTAL A PAGAR</small></td>
              <td class="" id="sale_total"></td>
            </tr>
            <tr class="tr_table" style="
              font-size: 10px;
            ">
              <td class="" colspan="3"><small>EFECTIVO</small></td>
              <td class="" id="sale_efectivo"></td>
            </tr>
            <tr class="tr_table" style="
              font-size: 10px;
            ">
              <td class="" colspan="3"><small>CAMBIO</small></td>
              <td class="" id="sale_cambio"></td>
            </tr>
        </tfoot>
    </table>
    <div class="centrado" style="
      font-size: 10px !important;
      text-align: center !important;
      align-content: center !important;
    ">
    </div>
    <p class="centrado" style="
      font-size: 10px !important;
      text-align: center !important;
      align-content: center !important;
    "><small>¡GRACIAS POR SU COMPRA!</small></p>
  </section>
</div>
<object type="text/html" id="print-iframe" width="0" height="0"></object>

<!-- Modal success and ticket-->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-content-cambio">
    <div class="modal-content">
      <div class="modal-header style-modal-form">
        <h5 class="modal-title text-center" id="messsageModalLabelSuccess"></h5>
      </div>
      <div class="modal-body style-modal-form">
        <br>
        <form id="send-email-now">
          @csrf
          <input type="number" id="cons_send_email" name="cons_send_email" hidden="true">
          <input type="number" id="suelt_vent" name="suelt_vent" hidden="true">
          <input type="text" name="idventa" id="idventa" hidden="true">
          <div class=" text-center">
            <h5><strong style="color:white"> EL CAMBIO ES DE $ : <span id="cambio_sale"></span></strong></h5>
          </div>
          <div id="show_input_email" style="display:none;">
            <div class="row g-3" >
              <div class="col-sm-9">
                <input type="text" class="form-control" name="nowemail" id="nowemail" placeholder="Ingresa el correo electronico" >
              </div>
              <div class="col-sm">
                <button class="btn btn6 btn-block btn-flat" id="btn-send-ticket-email"><i class="fas fa-envelope mr2"></i> Aceptar</button>
              </div>
            </div>
          </div>
        </form>
        <div class="">
            <div class="alert alert-danger show_alert_modal" style="display:none;" role="alert"></div>
        </div>
      </div>
      <div class="modal-footer style-modal-form">
        <div class="container text-center">
        <button type="button" class="btn btn-default btn4" data-bs-dismiss="modal" id="btn-close-modal"><i class="fas fa-times-circle mr-1"></i> Cerrar ventana</button>
        <button type="button" class="btn btn-default btn3" id="btn-show-email"><i class="fas fa-envelope-open-text mr-2"></i> Enviar correo</button>
        <!--button type="button" class="btn btn-default btn2" id="print_now_ticket"><i class="fas fa-print mr-2"></i> Imprimir ticket</button>-->
        <button type="button" class="btn btn-default btn2" id="print_now_ticket"><i class="fas fa-print mr-2"></i> Imprimir ticket</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal show ticket pdf -->
<div class="modal fade" id="generatePdfModal" tabindex="-1" aria-labelledby="generatePdfModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="generatePdfModalLabel">Imprimir ticket de venta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="pdf-iframe" frameborder="0" width="100%" height="600"></iframe>
      </div>
    </div>
  </div>
</div>
<template id="template_details">
  <tr class="tr_table" style="
  border-top: 1px solid black;
  border-collapse: collapse;
  font-size: 10px;
  ">
    <td class="tick_cant detail_cantidd"></td>
    <td class="tick_art detail_nombre"></td>
    <td class="tick_precio detail_venta"></td>
    <td class="tick_total detail_subtotal"></td>
  </tr>
</template>

