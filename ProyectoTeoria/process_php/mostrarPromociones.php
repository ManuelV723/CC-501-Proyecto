<?php 
include '../conexion.php';
$conn = new Connect();
$id_empresa=$_SESSION['id'];

if($_POST['parametro']=="0"){
	$x  = $conn->conexion->query("SET lc_time_names = 'es_ES'");
	$sql = "SELECT fotos_productos.foto, productos.nombre_p,productos.precio,promociones.descuento,DATE_FORMAT(promociones.inicio,'%d  %M %Y') AS 'Inicio',DATE_FORMAT(promociones.final,'%d  %M %Y') AS 'Fin'
FROM productos INNER JOIN fotos_productos ON productos.id_producto=fotos_productos.id_producto
INNER JOIN promociones ON promociones.id_producto = productos.id_producto
WHERE productos.id_empresa='$id_empresa' AND promociones.final >= CURRENT_DATE
GROUP BY promociones.id_promocion
ORDER BY promociones.inicio DESC;";

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
	$parametro = mysqli_real_escape_string($conn->conexion,$_POST['parametro']);
	$x  = $conn->conexion->query("SET lc_time_names = 'es_ES'");
	$sql = "SELECT fotos_productos.foto, productos.nombre_p,productos.precio,promociones.descuento,DATE_FORMAT(promociones.inicio,'%d  %M %Y') AS 'Inicio',DATE_FORMAT(promociones.final,'%d  %M %Y') AS 'Fin'
	FROM productos INNER JOIN fotos_productos ON productos.id_producto=fotos_productos.id_producto
	INNER JOIN promociones ON promociones.id_producto = productos.id_producto
	WHERE productos.id_empresa='$id_empresa' AND promociones.final >= CURRENT_DATE AND productos.nombre_p LIKE '%".$parametro."%'
	GROUP BY promociones.id_promocion
	ORDER BY promociones.inicio DESC;";
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

//SET lc_time_names = 'es_ES';
//SELECT DATE_FORMAT(inicio,'%d  %M %Y') AS 'Inicio' FROM promociones;

 ?>