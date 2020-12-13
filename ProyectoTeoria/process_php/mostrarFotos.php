<?php 
include '../conexion.php';

$conn = new Connect();

$id_producto = $_POST['id_producto'];

$res = $conn->buscar("fotos_productos","id_foto,foto","id_producto='$id_producto'");
while ($row=$res->fetch_assoc()) {
	$arr[] = $row;
}

echo json_encode($arr);

 ?>