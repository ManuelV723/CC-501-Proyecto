<?php 
include '../conexion.php';
$conn = new Connect();

$res=$conn->buscar("categorias","*","1=1");

while ($row=$res->fetch_assoc()) {
	$arr[] = $row;
}

echo json_encode($arr);

?>