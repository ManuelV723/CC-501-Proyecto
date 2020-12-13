<?php 
include '../conexion.php';
$conn = new Connect();
$id_categoria=$_POST['categoria'];

if($id_categoria==0){
	$x  = $conn->conexion->query("SET lc_time_names = 'es_ES';");
	$sql = "SELECT productos.id_producto,productos.nombre_p,productos.precio,productos.descripcion,empresas.nombre,productos.timestamp,categorias.categoria,fotos_productos.foto FROM categorias INNER JOIN empresas ON categorias.id_categoria=empresas.id_categoria INNER JOIN productos ON empresas.id_empresa=productos.id_empresa INNER JOIN fotos_productos ON fotos_productos.id_producto=productos.id_producto WHERE productos.estado='Activo'
GROUP BY productos.id_producto
ORDER BY productos.timestamp DESC;";

	$res=$conn->conexion->query($sql) or die($conn->conexion->error);
	$filas=$res->num_rows;
	if($filas>0){
		while ($row=$res->fetch_assoc()) {
			$arr[] = $row;
		}
		echo json_encode($arr);
	}else{
		echo 0;
	}
}else{
	$x  = $conn->conexion->query("SET lc_time_names = 'es_ES';");
	$sql = "SELECT productos.id_producto,productos.nombre_p,productos.precio,productos.descripcion,empresas.nombre,productos.timestamp,categorias.categoria,fotos_productos.foto FROM categorias INNER JOIN empresas ON categorias.id_categoria=empresas.id_categoria INNER JOIN productos ON empresas.id_empresa=productos.id_empresa INNER JOIN fotos_productos ON fotos_productos.id_producto=productos.id_producto WHERE productos.estado='Activo' AND categorias.id_categoria='$id_categoria'
GROUP BY productos.id_producto
ORDER BY productos.timestamp DESC;";

	$res=$conn->conexion->query($sql) or die($conn->conexion->error);
	$filas=$res->num_rows;
	if($filas>0){
		while ($row=$res->fetch_assoc()) {
			$arr[] = $row;
		}
		echo json_encode($arr);
	}else{
		echo 0;
	}
}
?>