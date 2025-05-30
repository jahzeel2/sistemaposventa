<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Document</title> 
         <!-- CSS only -->
        <!--link href="{{ public_path('theme/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">-->
    </head>
        <style>
            .borders {
                border: #b2b2b2 1px solid;
            }
            .letter{
                font-size: 13px;
                font-family: Helvetica;
                font-weight: bold;
                margin-top: 4px;
            }
            .letter2{
                font-size: 13px;
                font-family: Helvetica;
            }
            hr {
            height: 4px;
            background-color: black;
            }
            .th{
                background-color: #c9f0a2bb;
            }
        </style>
    <body>
        <!--div class="row">
           <img src="{{ public_path('images/logofactura.png') }}" class="mb-1" alt="user avatar">
        </div>
        <div class="row" style="margin-top:3px;">
            <h3 class="text-success border-2 border-bottom  text-center" style="background-color: #c9f0a2bb;font-family: Helvetica;font-weight: bold;">COTIZACIÓN</h3>
        </div>-->
        <!--div class="row" style="margin-top:3px;">
            <table>
                <tbody>
                    <tr>
                        @foreach ($cotizacion as $row) 
                        <td  style="text-align: left;width:60%"> 
                            <label><span class="letter">CLIENTE: </span><span class="letter2">{{$row->nomcliente}}</span></label><br>
                            <label><span class="letter">FECHA: </span><span class="letter2">
                                {{ 
                                    $formattedDate = date('d-m-Y', strtotime($row->fechacotizacion))
                                }} 
                            </span></label><br>
                            <label><span class="letter">DIRECCIÓN: </span><span class="letter2">{{$row->direccion}}</span></label><br>
                            <label><span class="letter">TELEFONO: </span><span class="letter2">{{$row->telefono}}</span></label><br>
                            <label><span class="letter">EMAIL: </span><a class="letter2">{{$row->email}}</a></label> 
                        </td>
                        <td style="text-align: center;width:40%">
                            <p class="borders" style="font-family: Helvetica;font-weight: bold;">{{$row->cod}}-{{$row->serie}}</p>
                            <div>
                                <div style="width:200px; float:left;"><span class="letter">VALIDO:</span></div>
                                <div style="width:200px; float:right;"><span class="letter2">{{$row->validez}} dias</span></div>
                            </div>
                            <div style="margin-top:18px;">
                                <div style="width:200px; float:left;"><span class="letter">HASTA:</span></div>
                                <div style="width:200px; float:right;"><span class="letter2">{{$date_end}}</span></div>
                            </div> 
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table> 
        </div>   
        <hr>-->
        <!--div class="row" >
            <label><span class="letter">VENDEDOR: </span><span class="letter2">{{$vendedor}}</span></label><br>
            <label><span class="letter">SERVICIO: </span><span class="letter2">{{$servicio}}</span></label><br>
        </div>-->
        <div class="row" style="margin-top:3px;">
            <table class="table table-bordered">
                <thead class="borders">
                    <tr >
                        <th class="borders letter th" style="width: 20%">CODIGO</th>
                        <th class="borders letter th" style="width: 40%">NOMBRE</th>
                        <th class="borders letter th" style="width: 10%">STOCK</th>
                        <th class="borders letter th" style="width: 20%">PRECIO COMPRA</th>
                        <th class="borders letter th" style="width: 10%">PRECIO VENTA</th>
                    </tr>
                </thead>
                <tbody class="borders">
                    @foreach ($productos as $row)
                        <tr>
                            <td class="borders letter2">{{$row->codigo}}</td>
                            <td class="borders letter2">{{$row->nombre}}</td>
                            <td class="borders text-center letter2">{{$row->stock}}</td> 
                            <td class="borders text-center letter2">${{$row->pcompra }}</td>
                            <td class="borders text-center letter2">${{$row->pventa}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <!--tfoot>
                    <tr>
                        <td></td>
                        <td></td> 
                        <td></td>
                        <td style="text-align: right;"> <span class="letter">TOTAL:</span></td>
                        <td class="borders text-center"> <span class="letter2">${{number_format($totalcotizacion, 0, ',', '.') }}</span> </td>

                    </tr> 
                    <tr>
                        <td></td>
                        <td></td> 
                        <td></td>
                        <td style="text-align: right;"> <span class="letter">ABONO:</span></td>
                        <td class="borders text-center"> <span class="letter2">${{number_format($abonocotizacion, 0, ',', '.') }}</span></td>
                    </tr> 
                    <tr>
                        <td></td>
                        <td></td> 
                        <td></td>
                        <td style="text-align: right;"> <span class="letter">A PAGAR:</span></td>
                        <td class="borders text-center"> <span class="letter2">${{number_format($apagar, 0, ',', '.') }}</span> </td>
                    </tr> 
                </tfoot>-->
            </table>
        </div>
    </body> 
</html>