<!DOCTYPE html>
<html>
<head>
<style>
table, td, th {
  /*border: 1px solid black;*/
  border: 1px solid #ddd;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 10px;
}
.right{
   text-align: right;
}
h5,
h3{
		text-align: center;
		text-transform: uppercase;
}
.mitad{
  width:50%;
}
.tdcenter{
 	text-align: center;
}
</style>
</head>
<body>

  <h3>Corte del cajero</h3>
  <h5>{{$name}}</h5>
	<hr>

  <table>
    <tr>
      <th class="mitad"></th>
      <th class="mitad"></th>
    </tr>
    <tr>
      <td>Fecha de operacion</td><td class="right">{{$cierre}}</td>
    </tr>
    <tr>
      <td>Nombre del cajero</td><td class="right">{{$name_cajero}}</td>
    </tr>
    <tr>
      <td class="tdcenter" colspan="2"><strong>Movimientos</strong></td>
    </tr>
    <tr>
      <td>Fondo de caja</td><td class="right">{{$inicio}}</td>
    </tr>
    <tr>
      <td>Efectivo en caja</td><td class="right">{{$final}}</td>
    </tr>
    <tr>
      <td>Ventas en efectivo</td><td class="right">{{$total}}</td>
    </tr>
     <tr>
      <td>Faltante</td><td class="right">{{$faltante}}</td>
    </tr>
    <tr>
      <td>Sobrante</td><td class="right">{{$sobrante}}</td>
    </tr>
  </table>

</body>