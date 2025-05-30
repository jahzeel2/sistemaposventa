<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            font-family: Helvetica;
        }
        .row{
            margin-top:3px;
        }
        .row h3{
            background-color: #03569F;
            font-weight: bold;
            color:white;
        }
        .table{
            width:100%;
            border-collapse: collapse;
        }
        .borders{
            border: #b2b2b2 1px solid;
        }
        .th1, .th4{
            width: 16%;
            text-align: left;

        }
        .th2{
            width: 40%;
            text-align: left;
        }
        .th3, .th5{
            width: 14%;
            text-align: left;
        }
        /******************************** */
        .flex-wrapper{
            /*display: flex;*/
        }
        .div{
            /*border: 1px solid;*/
        }
        .left{
            width: 50%;
            height: 15%;
            float: left;
            /*padding: 3px;*/
        }
        .right{
            float:left;
            width: 50%;
            height: 15%;
            /*padding: 3px;*/
            text-align: right;
        }
        .header{
            text-align: center;
        }
       .p{
            margin-bottom: -5px;
        }
        .content{
            border: 1px solid;
        }
        .letter{
            font-weight: bold;
        }
        .coti{
            padding:3px;
            background-color: #03569F;
            font-weight: bold;
            color:white;
        }
    </style>
</head>
<body>
    <div class="row header">
        <h3 class="text-secondary border-2" style="">COTIZACIÓN</h3>
    </div>
    <div  class="row">
        <div class="div left">
            <div>
                <p class="p">
                    <label><span class="letter">Cliente: </span><span class="letter2"> {{$cotizacion[0]->nomcliente}}</span></label>
                </p>
                <p class="p">
                    <label><span class="letter">Direccion: </span><span class="letter2">{{$cotizacion[0]->direccion}}</span></label>
                </p>
                <p class="p">
                    <label><span class="letter">Telefono: </span><span class="letter2">{{$cotizacion[0]->telefono}}</span></label>
                </p>
                <p class="p">
                    <label><span class="letter">Email: </span><span class="letter2">{{$cotizacion[0]->email}}</span></label>
                </p>
            </div>
        </div>
        <div class="div right">
            <div>
                <p class="p" >
                    <label ><span class="letter2 coti" style="">{{$cotizacion[0]->seriecotizacion}} </span></label>
                </p>
                <p class="p">
                    <label><span class="letter">Fecha: </span><span class="letter2">
                        {{ 
                            $formattedDate = date('d-m-Y', strtotime($cotizacion[0]->fechacotizacion))
                        }} 
                    </span></label>
                </p>
                <p class="p">
                    <label><span class="letter">Valido: </span><span class="letter2">{{$cotizacion[0]->validez}} </span></label>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <p><b>Lista de productos</b></p>
    </div>
    <div class="row">
        <table class="table">
            <thead class="borders">
                <tr>
                    <th class="th1 borders">Codigo</th>
                    <th class="th2 borders">Producto</th>
                    <th class="th3 borders">Cantidad</th>
                    <th class="th4 borders">Precio</th>
                    <th class="th5 borders">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalle as $row)
                <tr>
                    <td class="borders">{{$row->codigo}}</td>
                    <td class="borders">{{$row->nombre}}</td>
                    <td class="borders">{{$row->cantidad}}</td>
                    <td class="borders">{{$row->precio_venta}}</td>
                    <td class="borders">{{$row->total}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="borders"><span><b> Total: </b></span></td>
                    <td class="borders">{{$cotizacion[0]->totalcotizacion}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>