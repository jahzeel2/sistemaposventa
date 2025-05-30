<!DOCTYPE html>
<html>
<head>
    <title>Sales Ticket</title>
    <style>
    
        body {
            font-family: Arial, sans-serif;
            /*margin: 0;
            padding: 0;*/
            
        }
        .ticket1 {
            width: 300px;
            /*margin: 20px auto;*/
            margin-left:0px;
            background-color: #FFF;
            border: 1px solid #000;
            /*padding: 10px;*/
            padding: 0px;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 0px;
            /*height: 50px;*/
        }
        .ticket-header h1 {
            font-size: 18px;
            margin: 0;
        }
        .ticket-info {
            margin-bottom: 10px;
            /*border: 1px solid #000;*/
        }
        .ticket-items {
            margin-bottom: 10px;
        }
        .ticket-items table {
            width: 100%;
        }
        .ticket-items th, .ticket-items td {
            /*padding: 5px;*/
            border-bottom: 1px solid #000;
        }
        .ticket-total {
            text-align: right;
        }
        .margin-between {
            margin-top: -10px; /* Adjust the value as per your requirement */
        }
        .size {
            font-size: 13px;
        }

    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h5>{{$settings->name}}</h5>
        </div>
        <div class="ticket-info">
	    <p class="margin-between size"><strong>Direccion:</strong> {{$settings->adress}}</p>
	    <p class="margin-between size" ><strong>Telefono:</strong> {{$settings->phone}}</p>
            <p class="margin-between size"><strong>Email:</strong> {{$settings->email}}</p>
            <p class="margin-between size"><strong>Comprobante:</strong> {{$sale->tipo_comprobante}}/{{$sale->num_folio}}</p>
            <p class="margin-between size"><strong>Fecha:</strong> {{$sale->fecha_hora}}</p>
            <p class="margin-between size"><strong>Cliente:</strong> {{$sale->nombre}}</p>
        </div>
        <div class="ticket-items">
            <table>
                <thead>
                    <tr>
                        <th class="size">Cant.</th>
                        <th class="size">Nombre</th>
                        <th class="size">Precio</th>
                        <th class="size">Total</th>
                    </tr>
                </thead>
                <tbody>
		        @foreach ($detail as $item)
                        <tr>
                            <td class="size" style="text-align: center;">{{ $item->cantidad }}</td>
                            <td class="size">{{ $item->articulo }}</td>
                            <td class="size">{{ $item->precio_venta }}</td>
                            <td class="size" style="text-align: right;">{{ $item->subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="ticket-total">
            <p class="size"><strong>Total:</strong> {{$sale->total_venta}}</p>
            <p class="margin-between size"><strong>Recibido:</strong> {{$efectivo}}</p>
            <p class="margin-between size"><strong>Vuelto:</strong> {{$suelto}}</p>
        </div>
        <div class="ticket-items" >
		<p class="size"><Strong>Le atendio:</Strong> {{$sale->nameCajero}}</p>
        </div>
        <div class="ticket-items" style="text-align: center">
		      <h5>¡GRACIAS POR SU COMPRA!</h5>
        </div>
    </div>
</body>
</html>