<?php 

include '../conexion.php';

$conn= new 	Connect();
$id_carrito=$_POST['id_carrito'];

$res=$conn->actualizar("carrito","estado='Eliminado'","id_carrito='$id_carrito'");

if($res){
	echo 1;
}else{
	echo 0;
}

 ?>