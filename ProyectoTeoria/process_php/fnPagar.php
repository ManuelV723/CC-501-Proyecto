<?php 

include '../conexion.php';

$conn = new Connect();

$ids = $_POST['ids'];
$total = $_POST['total'];
$id_cliente=$_SESSION['id'];
date_default_timezone_set('America/Tegucigalpa');
$fecha_actual=date("Y-m-d H:i:s");

$transaccion=mysqli_query($conn->conexion,"START TRANSACTION;");

$factura=$conn->insertar("facturas","'$id_cliente','$fecha_actual','Pendiente'");
if($factura){
	$id_factura=mysqli_insert_id($conn->conexion);
	

	for ($i=0; $i < count($ids); $i++) {
		$id=$ids[$i];
		$fact_carrito = "INSERT INTO fact_carrito(id_carrito,id_factura) VALUES ('$id','$id_factura')";
		$fact_carrito_query=mysqli_query($conn->conexion,$fact_carrito);
		$carrito = "UPDATE carrito SET estado='Facturado' WHERE id_carrito='$id'";
		$carrito_query=mysqli_query($conn->conexion,$carrito);
	}

	if($fact_carrito_query){
		
		if($carrito_query){
			$pagos=$conn->insertar("pagos","'$id_factura','$total','Pagado','$fecha_actual'");
			if($pagos){
				$commit=mysqli_query($conn->conexion,"COMMIT;");
				echo 1;
			}else{
				$rollback=mysqli_query($conn->conexion,"ROLLBACK;");
				echo "0";	
			}
		}else{
			$rollback=mysqli_query($conn->conexion,"ROLLBACK;");
			echo "0";
		}
	}else{
		$rollback=mysqli_query($conn->conexion,"ROLLBACK;");
		echo "0";
	}
}else{
	$rollback=mysqli_query($conn->conexion,"ROLLBACK;");
	echo "0";
}




 ?>