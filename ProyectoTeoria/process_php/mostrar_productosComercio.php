<?php 
include '../conexion.php';
$conn = new Connect();
$id_empresa=$_SESSION['id'];
$tabla='productos INNER JOIN fotos_productos ON productos.id_producto=fotos_productos.id_producto';

if(!isset($_POST['parametro'])){
	$res = $conn->buscar("".$tabla."","productos.id_producto, productos.nombre_p,productos.descripcion,productos.precio,productos.estado,fotos_productos.foto","productos.id_empresa='$id_empresa' AND productos.estado!='Eliminado' GROUP BY productos.id_producto ORDER BY productos.timestamp DESC");

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
	$res = $conn->buscar("".$tabla."","productos.id_producto, productos.nombre_p,productos.descripcion,productos.precio,productos.estado,fotos_productos.foto","productos.id_empresa='$id_empresa' AND productos.estado!='Eliminado' AND productos.nombre_p LIKE '%".$parametro."%' GROUP BY productos.id_producto ORDER BY productos.timestamp DESC");
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