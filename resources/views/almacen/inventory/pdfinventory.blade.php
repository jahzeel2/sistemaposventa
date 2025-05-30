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
            /*.th{
                background-color: #c9f0a2bb;
            }*/
        </style>
    <body>
        <div class="row" style="margin-top:3px;text-align: center;">
            <h3 class="text-success border-2 border-bottom  text-center" style="font-family: Helvetica;font-weight: bold;">LISTA DE PRODUCTOS EN EXISTENCIA</h3>
        </div>
        <div class="row" style="margin-top:3px;">
            <table class="table table-bordered">
                <thead class="borders">
                    <tr>
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
            </table>
        </div>
    </body> 
</html>