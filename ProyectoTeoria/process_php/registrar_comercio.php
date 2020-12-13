<?php 
include '../conexion.php';

$conn = new Connect();

$rtn=mysqli_real_escape_string($conn->conexion,$_POST['rtn']);
$nombre=mysqli_real_escape_string($conn->conexion,$_POST['nombre']);
$eslogan=mysqli_real_escape_string($conn->conexion,$_POST['eslogan']);
$correo=mysqli_real_escape_string($conn->conexion,$_POST['correo']);
$telefono=mysqli_real_escape_string($conn->conexion,$_POST['telefono']);
$pais=mysqli_real_escape_string($conn->conexion,$_POST['pais']);
$direccion=mysqli_real_escape_string($conn->conexion,$_POST['direccion']);
$categoria=$_POST['categoria'];
$pass=sha1($_POST['pass']);

$foto=$_FILES["logo"]["name"];	//obtiene el logo
$ruta=$_FILES["logo"]["tmp_name"];
$destino = "img/".$foto; //crea una ruta de destino del logo

$verificar=$conn->buscar("empresas","id_empresa","rtn='$rtn' OR correo='$correo'");
	$filas=$verificar->num_rows;
	if($filas<=0){
		copy($ruta,$destino);
		$sql=$conn->insertar("empresas","'$rtn','$nombre','$eslogan','$pais','$direccion','$telefono','$foto','$correo','$pass','$categoria'");
		echo $sql;
	}else{
		echo 2;
	}

 ?>
