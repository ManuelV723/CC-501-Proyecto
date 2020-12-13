<?php 

include '../conexion.php';

$conn = new Connect();

$res = $conn->buscar("empresas INNER JOIN categorias ON empresas.id_categoria=categorias.id_categoria","empresas.id_empresa,empresas.logo,empresas.nombre,empresas.eslogan,categorias.id_categoria","1=1 ORDER BY categorias.id_categoria ASC");

if($res->num_rows>0){
	while ($dat=$res->fetch_assoc()) {
		$arr[] = $dat;
	}
	echo json_encode($arr);
}else{
	echo 2;
}

 ?>