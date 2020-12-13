<?php 
include '../conexion.php';

$conn = new Connect();
$id_producto = $_POST['id_producto'];
$producto = mysqli_real_escape_string($conn->conexion,$_POST['producto']);
$precio = mysqli_real_escape_string($conn->conexion,$_POST['precio']);
$descripcion = mysqli_real_escape_string($conn->conexion,$_POST['descripcion']);

$res=$conn->actualizar("productos","nombre_p='$producto',precio='$precio',descripcion='$descripcion'","id_producto='$id_producto'");
echo $res;

 ?>