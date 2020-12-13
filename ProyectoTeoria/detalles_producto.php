<?php 

include 'conexion.php';

$conn= new 	Connect();
if(isset($_SESSION['id'])){
	$conn->rolCliente($_SESSION['rol']);
}
if(isset($_REQUEST['product'])){
	$id_producto = base64_decode($_REQUEST['product']);

	$producto=$conn->buscar("productos INNER JOIN empresas ON productos.id_empresa=empresas.id_empresa INNER JOIN categorias ON categorias.id_categoria=empresas.id_categoria","productos.id_producto,productos.nombre_p,productos.descripcion,productos.precio,empresas.nombre,categorias.categoria,categorias.id_categoria,empresas.eslogan,empresas.logo,empresas.direccion,empresas.telefono,empresas.correo","id_producto=$id_producto");

}elseif(isset($_REQUEST['promo'])){
	
	$id_promocion = base64_decode($_REQUEST['promo']);
	$sql = "SELECT productos.id_producto,productos.nombre_p,productos.descripcion,productos.precio,promociones.descuento,promociones.descripcion as 'descripcion_promo',empresas.nombre,categorias.id_categoria,categorias.categoria,FORMAT((productos.precio-(productos.precio*(promociones.descuento / 100))),2) AS 'total',empresas.eslogan,empresas.logo,empresas.direccion,empresas.telefono,empresas.correo FROM empresas INNER JOIN productos ON empresas.id_empresa=productos.id_empresa INNER JOIN categorias ON empresas.id_categoria=categorias.id_categoria INNER JOIN promociones ON productos.id_producto=promociones.id_producto WHERE promociones.id_promocion='$id_promocion'";
	$promocion = mysqli_query($conn->conexion,$sql);
}



 ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Detalles | Producto</title>

 		<!-- Google font -->
 		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

 		<!-- Bootstrap -->
 		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

 		<!-- Slick -->
 		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
 		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

 		<!-- nouislider -->
 		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>
 		<link rel="stylesheet" href="toast/toastr.css">
 		<!-- Font Awesome Icon -->
 		<link rel="stylesheet" href="css/font-awesome.min.css">

 		<!-- Custom stlylesheet -->
 		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> </a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> </a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> </a></li>
					</ul>
					<ul class="header-links pull-right">
						<?php if(isset($_SESSION['id'])){ ?>
							<li><a href="cerrar_sesion.php"><i class="fa fa-sign-out"></i> Cerrar Sesion</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="#" class="logo">
									<img src="./img/logo.png" alt="" height="90">
								</a>
							</div>
						</div>
						<!-- /LOGO -->
<style>
	.header-search h2, h5{
		color: #fff;
	}
	.header-search{
		text-align: center;
	}
</style>
						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<h2 id="h-nombreEmpresa"></h3>
								<h5 id="h-esloganEmpresa"></h5>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<?php if(!isset($_SESSION['id'])){ ?>
								<div>
									<a style="cursor: pointer;" onclick="accionesAcceso(1)">
										<i class="fa fa-user-plus"></i>
										<span>Registrarme</span>
									</a>
								</div>
								<?php }else{ 
									$id_cliente=$_SESSION['id'];
									$datos=$conn->buscar("clientes","*","id_cliente='$id_cliente'");
									$datos=$datos->fetch_assoc();
									?>
								<div>
									<a href="perfil.php">
										<i class="fa fa-user"></i>
										<span><?php echo $datos['nombre']; ?></span>
									</a>
								</div>
								<?php } ?>
								<!-- /Wishlist -->

								<!-- Cart -->
								<?php if(!isset($_SESSION['id'])){ ?>
								<div class="dropdown">
									<a class="dropdown-toggle" aria-expanded="true" onclick="accionesAcceso(0)">
										<i class="fa fa-sign-in"></i>
										<span>Ingresar</span>
									</a>
								</div>
								<?php }else{ ?>
								<div class="dropdown">
									<a class="dropdown-toggle" aria-expanded="true" href="carrito.php">
										<i class="fa fa-shopping-cart"></i>
										<span>Carrito</span>
										<div class="qty">3</div>
									</a>
								</div>
								<?php } ?>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="index.php">Inicio</a></li>
						<li><a href="promociones_c.php">Promociones</a></li>
						<li><a href="productos_c.php">Productos</a></li>
						<li><a href="comercios.php">Comercios</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="index.php">Inicio</a></li>
							<li><a href="productos.php">Productos</a></li>
							<li class="active">Detalles</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<?php 
				if(isset($producto)){
				while ($row_producto=$producto->fetch_assoc()) {
				$id_categoria=$row_producto['id_categoria'];
				$empresa = $row_producto['nombre'];
				$eslogan = $row_producto['eslogan'];
				$logo = $row_producto['logo'];
				$telefono = $row_producto['telefono'];
				$correo = $row_producto['correo'];
				$direccion = $row_producto['direccion']; ?>
				<div class="row">
					<!-- Product main img -->
					<div class="col-md-5 col-md-push-2">
						<div id="product-main-img">
							<?php $img=$conn->buscar("fotos_productos","*","id_producto='$id_producto'");
									while ($row_img=$img->fetch_assoc()) { ?>
							<div class="product-preview">
								<img src="process_php/img/<?php echo $row_img['foto']; ?>" alt="">
							</div>
							<?php } ?>
						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					<div class="col-md-2  col-md-pull-5">
						<div id="product-imgs">
							<?php $img2=$conn->buscar("fotos_productos","*","id_producto='$id_producto'");
							while ($row_img2=$img2->fetch_assoc()) { ?>
							<div class="product-preview">
								<img src="process_php/img/<?php echo $row_img2['foto']; ?>" alt="">
							</div>
						<?php } ?>
						</div>
					</div>
					
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo $row_producto['nombre_p']; ?></h2>
							<div>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
								</div>
								<!--<a class="review-link" href="#">10 Review(s) | Add your review</a>-->
							</div>
							<div>
								<h3 class="product-price">L. <?php echo $row_producto['precio']; ?> <!--<del class="product-old-price">$990.00</del>--></h3>
								<span class="product-available">Disponible</span>
							</div>
							<p><?php echo $row_producto['descripcion']; ?></p>

							<div class="product-options">
								<input class="input-select" hidden disabled value="<?php echo $row_producto['precio']; ?>" id="txtPrecio" style="text-align: right;">
								<label>total L. <input class="input-select" disabled value="<?php echo $row_producto['precio']; ?>" id="txtTotal" style="text-align: right;">
								</label>
							</div>

							<div class="add-to-cart">
								<div class="qty-label">
									Cant
									<div class="input-number">
										<input type="number" value="1" disabled>
										<span class="qty-up">+</span>
										<span class="qty-down">-</span>
									</div>
								</div>
								<?php if(!isset($_SESSION['id'])){ ?>
									<button class="add-to-cart-btn" id="btnAgregar" onclick="fnAgregarAlCarrito(0)"><i class="fa fa-shopping-cart"></i> Agregar</button>
								<?php }else{ ?> 
									<button class="add-to-cart-btn" id="btnAgregar" onclick="fnAgregarAlCarrito(<?php echo $row_producto['id_producto']; ?>)"><i class="fa fa-shopping-cart"></i> Agregar</button>
								<?php } ?>
							</div>

							<ul class="product-btns">
								<li><a href="#"><i class="fa fa-briefcase"></i> <?php echo $row_producto['nombre']; ?></a></li>
							</ul>

							<ul class="product-links">
								<li><?php echo $row_producto['categoria']; ?></li>
							</ul>

							<ul class="product-links">
								<li>Compartir:</li>
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i></a></li>
							</ul>

						</div>
					</div>
				</div>
				<?php }
				} ?>
				<!-- /row -->
				<!-- row -->
				<?php 
				if(isset($id_promocion)){
				while ($row=$promocion->fetch_assoc()) {
				$id_producto_promo=$row['id_producto'];
				$id_categoria=$row['id_categoria']; 
				$empresa = $row['nombre'];
				$eslogan = $row['eslogan'];
				$logo = $row['logo'];
				$telefono = $row['telefono'];
				$correo = $row['correo'];
				$direccion = $row['direccion']; ?>
				<div class="row">
					<!-- Product main img -->
					
					<div class="col-md-5 col-md-push-2">
						<div id="product-main-img">
							<?php $img=$conn->buscar("fotos_productos","*","id_producto='$id_producto_promo'");
									while ($row_img=$img->fetch_assoc()) { ?>
							<div class="product-preview">
								<img src="process_php/img/<?php echo $row_img['foto']; ?>" alt="">
							</div>
							<?php } ?>
						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					<div class="col-md-2  col-md-pull-5">
						<div id="product-imgs">
							<?php $img2=$conn->buscar("fotos_productos","*","id_producto='$id_producto_promo'");
							while ($row_img2=$img2->fetch_assoc()) { ?>
							<div class="product-preview">
								<img src="process_php/img/<?php echo $row_img2['foto']; ?>" alt="">
							</div>
						<?php } ?>
						</div>
					</div>
					
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo $row['nombre_p']; ?></h2>
							<div>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
								</div>
								<a class="review-link" href="#" style="background-color: #D10024;color: #fff;padding: 1px 3px;">-<?php echo $row['descuento']." %"; ?></a>
							</div>
							<div>
								<h3 class="product-price">L. <?php echo $row['total']; ?> <del class="product-old-price">L. <?php echo $row['precio']; ?></del></h3>
								<span class="product-available">Disponible</span>
							</div>
							<p><?php echo $row['descripcion']; ?></p>

							<div class="product-options">
								<input class="input-select" hidden disabled value="<?php $str = str_replace( ',', '', $row['total']);
								echo $str; ?>" id="txtPrecio" style="text-align: right;">
								<label>total L. <input class="input-select" disabled value="<?php
								 echo $str; ?>" id="txtTotal" style="text-align: right;">
								</label>
							</div>

							<div class="add-to-cart">
								<div class="qty-label">
									Cant
									<div class="input-number">
										<input type="number" value="1" disabled id="txtCantidad">
										<span class="qty-up">+</span>
										<span class="qty-down">-</span>
									</div>
								</div>
								<?php if(!isset($_SESSION['id'])){ ?>
									<button class="add-to-cart-btn" id="btnAgregar" onclick="fnAgregarAlCarrito(0)"><i class="fa fa-shopping-cart"></i> Agregar</button>
								<?php }else{ ?> 
									<button class="add-to-cart-btn" id="btnAgregar" onclick="fnAgregarAlCarrito(<?php echo $row['id_producto']; ?>)"><i class="fa fa-shopping-cart"></i> Agregar</button>
								<?php } ?>
							</div>

							<ul class="product-btns">
								<li><a href="#"><i class="fa fa-briefcase"></i> <?php echo $row['nombre']; ?></a></li>
							</ul>

							<ul class="product-links">
								<li><?php echo $row['categoria']; ?></li>
								<!--<li><a href="#">Headphones</a></li>-->
							</ul>

							<ul class="product-links">
								<li>Compartir:</li>
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i></a></li>
							</ul>

						</div>
					</div>
				</div>
				<?php }
				} ?>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">Promociones Relacionadas</h3>
						</div>
					</div>
<?php 
$x  = $conn->conexion->query("SET lc_time_names = 'es_ES';");
	$sql = "SELECT promociones.id_promocion,productos.id_producto,productos.nombre_p, productos.precio, FORMAT((productos.precio-(productos.precio*(promociones.descuento / 100))),2) AS 'total', promociones.descuento, DATE_FORMAT(promociones.final,'%d  %M %Y') AS 'fin', empresas.nombre, fotos_productos.foto
FROM empresas INNER JOIN productos ON empresas.id_empresa=productos.id_empresa
INNER JOIN promociones ON promociones.id_producto=productos.id_producto
INNER JOIN fotos_productos ON productos.id_producto=fotos_productos.id_producto
WHERE promociones.inicio <= CURRENT_DATE AND promociones.final >= CURRENT_DATE AND empresas.id_categoria='$id_categoria'
GROUP BY promociones.id_promocion
ORDER BY promociones.inicio DESC LIMIT 8;";

	$res=$conn->conexion->query($sql) or die($conn->conexion->error);
 ?>
					<!-- product -->
					
						<?php while ($row=$res->fetch_assoc()) { ?>
							<div class="col-md-3 col-xs-6">
											<div class="product">
											<div class="product-img" style="height: 150px;">
												<img src="process_php/img/<?php echo $row['foto']; ?>" alt="">
												<div class="product-label">
													<span class="sale">-<?php echo $row['descuento']; ?> %</span>
													<span class="new">NEW</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category"><?php echo $row['nombre']; ?></p>
												<h3 class="product-name"><a href="#"><?php echo $row['nombre_p']; ?></a></h3>
												<h4 class="product-price">L. <?php echo $row['total']; ?> <del class="product-old-price">L. <?php echo $row['precio']; ?></del></h4>
												<div class="product-rating" style="height: 3px; margin-bottom: 4px;">
													
												</div>
												<div class="product-btns">
													<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">añadir favorito</span></button>
													<?php $id_productoEncriptado = base64_encode($row['id_promocion']); ?>
													<button class="quick-view" onclick="fnVerDetalles(<?php echo "'".$id_productoEncriptado."'"; ?>)"><i class="fa fa-eye"></i><span class="tooltipp">Detalles</span></button>
													<p class="product-category">Disponible hasta el <?php echo $row['fin']; ?></p>
												</div>
											</div>
											
										</div>
							</div>
									<?php } ?>
					<!-- /product -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->
		<!-- FOOTER -->
		<footer id="footer">
			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
							</ul>
							<span class="copyright">
								<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Grupo #1 <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">UCENM</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
		<script src="toast/toastr.js"></script>
		<script src="detalles_producto.js"></script>
		<script>
			$('#h-nombreEmpresa').html('<?php echo $empresa; ?>');
			$('#h-esloganEmpresa').html('<?php echo $eslogan; ?>');
			$('.logo img').attr('src','process_php/img/<?php echo $logo; ?>');
			$('.fa-envelope-o').after(' <?php echo $correo; ?>');
			$('.fa-phone').after(' <?php echo $telefono; ?>');
			$('.fa-map-marker').after( '<?php echo $direccion; ?>')
		</script>

	</body>
</html>
