<?php 
include '../conexion.php';

$conn = new Connect();

$id_cliente = $_SESSION['id'];

$sql = $conn->buscar("clientes","*","id_cliente='$id_cliente'");

while ($dat=$sql->fetch_assoc()) {
	$arr[] = $dat;
}

echo json_encode($arr);

 ?>