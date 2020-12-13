<?php 
include '../conexion.php';
$conn = new Connect();
$id_empresa=$_SESSION['id'];

$id_factura = $_POST['id_factura'];

	$x  = $conn->conexion->query("SET lc_time_names = 'es_ES'");
	$sql = "SELECT carrito.id_carrito,fotos_productos.foto,productos.nombre_p,productos.precio,carrito.cantidad,productos.precio*carrito.cantidad as 'subtotal',100-ROUND(FORMAT((((carrito.total / carrito.cantidad) / productos.precio))*100,2)) as 'por_descuento',REPLACE(FORMAT(carrito.cantidad*(productos.precio-(carrito.total / carrito.cantidad)),2),',','') as 'descuento',carrito.total,facturas.id_factura FROM productos INNER JOIN fotos_productos ON productos.id_producto=fotos_productos.id_producto
INNER JOIN carrito ON carrito.id_producto=productos.id_producto
INNER JOIN fact_carrito ON carrito.id_carrito=fact_carrito.id_carrito INNER JOIN facturas ON facturas.id_factura=fact_carrito.id_factura
WHERE facturas.id_factura='$id_factura'
GROUP BY carrito.id_carrito";

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

//SET lc_time_names = 'es_ES';
//SELECT DATE_FORMAT(inicio,'%d  %M %Y') AS 'Inicio' FROM promociones;

 ?>