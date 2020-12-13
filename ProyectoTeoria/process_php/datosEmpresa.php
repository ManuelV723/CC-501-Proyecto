<?php 
include '../conexion.php';

$conn = new Connect();
$id_empresa=$_SESSION['id'];

$res=$conn->buscar("empresas","*","id_empresa='".$id_empresa."'");
while ($row=$res->fetch_assoc()) {
	$arr[] = $row;
}

echo json_encode($arr);

 ?>