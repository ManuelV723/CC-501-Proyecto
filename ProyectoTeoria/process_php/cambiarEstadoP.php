<?php 
include '../conexion.php';

$conn = new Connect();
$id_producto=$_POST['id_producto'];
$accion=$_POST['accion'];
if($accion=="eliminar"){
	$res = $conn->actualizar("productos","estado='Eliminado'","id_producto='$id_producto'");
	$resultado='Eliminado';
}elseif($accion=="activar"){
	$res = $conn->actualizar("productos","estado='Activo'","id_producto='$id_producto'");
	$resultado='Habilitado';
}elseif($accion=="desactivar") {
	$res = $conn->actualizar("productos","estado='Inactivo'","id_producto='$id_producto'");
	$resultado="Inhabilitado";
}
	if($res){
		echo $resultado;
	}else{
		echo 0;
	}
 ?>