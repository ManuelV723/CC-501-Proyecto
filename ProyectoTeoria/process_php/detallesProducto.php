<?php
include '../conexion.php';

$conn = new Connect();

$id_producto = $_POST['id_producto'];

$res = $conn->buscar("productos","productos.id_producto,productos.nombre_p,productos.precio,productos.descripcion","productos.id_producto='$id_producto'");
while ($row=$res->fetch_assoc()) {
	$arr[] = $row;
}

echo json_encode($arr);

 ?>