<?php

include '../conexion.php';

$conn = new Connect();

$nombre = mysqli_real_escape_string($conn->conexion,$_POST['nombre']);
$apellido = mysqli_real_escape_string($conn->conexion,$_POST['apellido']);
$correo = mysqli_real_escape_string($conn->conexion,$_POST['correo']);
$celular = mysqli_real_escape_string($conn->conexion,$_POST['celular']);
$pass = sha1($_POST['pass']);

$sql=$conn->buscar("clientes","id_cliente","correo='$correo' OR celular='$celular'");
$filas = $sql->num_rows;
if($filas>0){
	echo 2;
	exit();
}else{
	$registrar=$conn->insertar("clientes","'$nombre','$apellido','$correo','$celular','$pass','1'");
	if($registrar){
		echo 1;
	}else{
		echo 0;
	}
}

 ?>