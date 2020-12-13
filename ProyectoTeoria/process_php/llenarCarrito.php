<?php 

include '../conexion.php';

$conn= new 	Connect();

$id_cliente=$_SESSION['id'];

$res=$conn->buscar("productos INNER JOIN fotos_productos ON productos.id_producto=fotos_productos.id_producto
INNER JOIN carrito ON carrito.id_producto=productos.id_producto","carrito.id_carrito,fotos_productos.foto,productos.nombre_p,productos.precio,carrito.cantidad,productos.precio*carrito.cantidad as 'subtotal',100-ROUND(FORMAT((((carrito.total / carrito.cantidad) / productos.precio))*100,2)) as 'por_descuento',REPLACE(FORMAT(carrito.cantidad*(productos.precio-(carrito.total / carrito.cantidad)),2),',','') as 'descuento',carrito.total","carrito.id_cliente='$id_cliente' AND carrito.estado='Pendiente'
GROUP BY carrito.id_carrito");

if($res->num_rows>0){
	if($res){
		while ($dat=$res->fetch_assoc()) {
			$arr[] = $dat;
		}
		echo json_encode($arr);
	}else{
		echo 0;
	}
}else{
	echo 2;
}


?>