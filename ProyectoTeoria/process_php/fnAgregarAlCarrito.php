<?php 

include '../conexion.php';
$conn = new Connect();

$id_cliente=$_SESSION['id'];
$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];
$total = $_POST['total'];

$res=$conn->insertar("carrito","'$id_producto','$id_cliente','$cantidad','$total','Pendiente'");

if($res){
	echo 1;
}else{
	echo 0;
}

 ?>