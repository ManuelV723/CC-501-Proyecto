<?php
include '../conexion.php';
$conn = new Connect();
$id_empresa=$_SESSION['id'];
$nombre=mysqli_real_escape_string($conn->conexion,$_POST['nombre']);
$eslogan=mysqli_real_escape_string($conn->conexion,$_POST['eslogan']);
$correo=mysqli_real_escape_string($conn->conexion,$_POST['correo']);
$telefono=mysqli_real_escape_string($conn->conexion,$_POST['telefono']);
$direccion=mysqli_real_escape_string($conn->conexion,$_POST['direccion']);
$pass = $_POST['pass'];

if($pass==0){
	$res=$conn->actualizar("empresas","nombre='$nombre',eslogan='$eslogan',correo='$correo',telefono='$telefono',direccion='$direccion'","id_empresa='$id_empresa'");
	echo $res;
}else{
	$pass_encriptada=sha1($pass);
	$res=$conn->actualizar("empresas","nombre='$nombre',eslogan='$eslogan',correo='$correo',telefono='$telefono',direccion='$direccion',pass='$pass_encriptada'","id_empresa='$id_empresa'");
	echo $res;
}

 ?>