<?php
include '../conexion.php';

$conn = new Connect();
$id_empresa=$_SESSION['id'];
$foto=$_FILES["logo"]["name"];	//obtiene el logo
$ruta=$_FILES["logo"]["tmp_name"];
$destino = "img/".$foto; //crea una ruta de destino del logo

$res = $conn->actualizar("empresas","logo='$foto'","id_empresa='$id_empresa'");
if($res){
	copy($ruta,$destino);
	echo 1;
}else{
	echo 0;
}


 ?>