<?php
include '../conexion.php';
$conn = new Connect();

$id_empresa=$_SESSION['id'];

$producto = mysqli_real_escape_string($conn->conexion,$_POST['producto']);
$precio = mysqli_real_escape_string($conn->conexion,$_POST['precio']);
$descripcion = mysqli_real_escape_string($conn->conexion,$_POST['descripcion']);
$numero = mysqli_real_escape_string($conn->conexion,$_POST['numero']);
date_default_timezone_set('America/Tegucigalpa');
$fecha_actual=date("Y-m-d H:i:s");
$guardar=$conn->insertar("productos","'$id_empresa','$producto','$descripcion','$precio','Activo','$fecha_actual'");
if($guardar){
	$id_producto=$conn->conexion->insert_id;


$contador=0;
	for ($i=0; $i < $numero; $i++) {
		if($i>=4){
			$contador++;
		}else{
			$foto=$_FILES["foto".$i.""]["name"];	//obtiene el foto
			$ruta=$_FILES["foto".$i.""]["tmp_name"];
			$destino = "img/".$foto; //crea una ruta de destino del foto
			$guardar_foto=$conn->insertar("fotos_productos","'$foto','$id_producto'");
			if($guardar_foto){
				copy($ruta,$destino);
				$contador++;
			}
		}
	}
	if($contador==$numero){
		echo 1;
	}else{
		echo 2;
	}
}else{
	echo 0;
}


 ?>