<?php
include '../conexion.php';

$conn = new Connect();

$user=mysqli_real_escape_string($conn->conexion,$_POST['user']);
$pass=sha1($_POST['pass']);
$tipo_user=$_POST['tipo_user'];

if($tipo_user=='cliente'){
	$verificar=$conn->buscar("clientes","id_cliente","correo='$user' AND pass='$pass' LIMIT 1");
	$filas=$verificar->num_rows;
	if($filas>0){
		$row=$verificar->fetch_assoc();
		$_SESSION['id']=$row['id_cliente'];
		$_SESSION['rol']=1; // 1 = rol de cliente
		echo 1;
	}else{
		echo 0;
	}
}elseif($tipo_user=='comercio'){
	$verificar=$conn->buscar("empresas","id_empresa","correo='$user' AND pass='$pass' LIMIT 1");
	$filas=$verificar->num_rows;
	if($filas>0){
		$row=$verificar->fetch_assoc();
		$_SESSION['id']=$row['id_empresa'];
		$_SESSION['rol']=2; // 2 = rol de empresa
		echo 2;
	}else{
		echo 0;
	}
}

 ?>