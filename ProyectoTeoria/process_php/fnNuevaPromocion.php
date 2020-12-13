<?php
include '../conexion.php';
$conn = new Connect();

$id_empresa=$_SESSION['id'];

$id_producto = $_POST['id_producto'];
$promocion = $_POST['nombre'];
$descuento = $_POST['descuento'];
$fecha_inicio = $_POST['inicio'];
$fecha_fin = $_POST['final'];

$res = $conn->insertar("promociones","'$id_producto','$promocion','$descuento','$fecha_inicio','$fecha_fin'");

if($res){
	echo 1;
}else{
	echo 0;
}

?>