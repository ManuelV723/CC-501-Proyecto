<?php 
include '../conexion.php';

$conn = new Connect();

$id_factura = $_POST['id_factura'];

$res=$conn->actualizar("facturas","estado='Finalizado'","id_factura='$id_factura'");
echo $res;

 ?>