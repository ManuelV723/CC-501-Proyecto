<?php 
include '../conexion.php';
$conn = new Connect();
$id_empresa=$_POST['id_empresa'];

if(!isset($_POST['product'])){

	$x  = $conn->conexion->query("SET lc_time_names = 'es_ES';");
	$sql = "SELECT productos.id_producto,promociones.id_promocion, productos.nombre_p, productos.precio, FORMAT((productos.precio-(productos.precio*(promociones.descuento / 100))),2) AS 'total', promociones.descuento, DATE_FORMAT(promociones.final,'%d  %M %Y') AS 'fin', empresas.nombre, fotos_productos.foto
	FROM empresas INNER JOIN productos ON empresas.id_empresa=productos.id_empresa
	INNER JOIN promociones ON promociones.id_producto=productos.id_producto
	INNER JOIN fotos_productos ON productos.id_producto=fotos_productos.id_producto
	WHERE empresas.id_empresa='$id_empresa' AND promociones.inicio <= CURRENT_DATE AND promociones.final >= CURRENT_DATE
	GROUP BY promociones.id_promocion
	ORDER BY promociones.inicio DESC LIMIT 8;";

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
	$sql = "SELECT productos.id_producto,productos.nombre_p,productos.precio,productos.descripcion,empresas.nombre,productos.timestamp,categorias.categoria,fotos_productos.foto FROM categorias INNER JOIN empresas ON categorias.id_categoria=empresas.id_categoria INNER JOIN productos ON empresas.id_empresa=productos.id_empresa INNER JOIN fotos_productos ON fotos_productos.id_producto=productos.id_producto WHERE productos.id_empresa='$id_empresa' AND productos.estado='Activo'
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