<!DOCTYPE html>
<html>
    <head>
        <style>
            * {
                font-size: 12px;
                font-family: 'Times New Roman';
            }

            .tr_style{
                border-top: 1px solid black;
                border-collapse: collapse;
            }

            .table_ticket{
                border-top: 1px solid black;
                border-collapse: collapse;
            }

            th.producto {
                width: 80px;
                max-width: 80px;
            }

            th.cantidad {
                width: 40px;
                max-width: 40px;
                word-break: break-all;
            }

            th.precio {
                width: 40px;
                max-width: 40px;
                word-break: break-all;
            }

            th.total {
                width: 40px;
                max-width: 40px;
                word-break: break-all;
            }

            th.descuento{
                width: 40px;
                max-width: 40px;
                word-break: break-all;
            }

            .centrado {
                align-items: center;
                display: flex;
                justify-content: center;
                width: 300px;
                max-width: 300px;
                background: #dcdcdc;
                color: #0c0b0b;
            }

            .ticket {
                width: 300px;
                max-width: 300px;
            }
        </style>
    </head>
    <body>
        <div class="ticket">
            <p class="centrado">{{$name}}
                <br>{{$address}}
                <br>{{$details['fecha']}}</p>
            <p class="centrado">
                {{$details['cliente']}}
            </p>
            <table class="table_ticket">
                <thead>
                    <tr>
                        <th class="cantidad">CANT</th>
                        <th class="producto">ART</th>
                        <th class="precio">PRE</th>
                        <th class="descuento">DES</th>
                        <th class="total">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($details['detail'] as $ven)
                  <tr class="tr_style">
                    <td>{{$ven->cantidad}}</td>
                    <td>{{$ven->articulo}}</td>
                    <td>{{$ven->precio_venta}}</td>
                    <td>{{$ven->descuento}}</td>
                    <td>{{$ven->subtotal}}</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                    <tr class="tr_style">
                        <td class="" colspan="4"><small>VENTA TOTAL</small></td>
                        <td class="" id="sale_total">{{$details['total_venta']}}</td>
                    </tr>
                    <tr class="tr_style">
                        <td class="" colspan="4"><small>CAMBIO</small></td>
                        <td class="">{{$details['suelto']}}</td>
                    </tr>
                </tfoot>
            </table>
            <p class="centrado">FOLIO :<span>{{$details['folio']}}</span></p>
            <p class="centrado">¡GRACIAS POR SU COMPRA!</p>
        </div>
    </body>
</html>

