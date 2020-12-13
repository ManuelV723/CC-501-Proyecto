<?php 
include '../conexion.php';

$conn = new Connect();

$id_cliente = $_SESSION['id'];

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$celular = $_POST['celular'];

if($_POST['pass']==false){
	$sql = $conn->actualizar("clientes","nombre='$nombre',apellido='$apellido',correo='$correo',celular='$celular'","id_cliente='$id_cliente'");
}else{
	$pass = sha1($_POST['pass']);
	$sql = $conn->actualizar("clientes","nombre='$nombre',apellido='$apellido',correo='$correo',celular='$celular',pass='$pass'","id_cliente='$id_cliente'");
}

echo $sql;

 ?>