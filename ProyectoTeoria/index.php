<?php 
include 'conexion.php';
$conn = new Connect();
if(isset($_SESSION['id'])){
	$conn->rolCliente($_SESSION['rol']);
}
	$x  = $conn->conexion->query("SET lc_time_names = 'es_ES';");
	$sql = "SELECT promociones.id_promocion,productos.id_producto,productos.nombre_p, productos.precio, FORMAT((productos.precio-(productos.precio*(promociones.descuento / 100))),2) AS 'total', promociones.descuento, DATE_FORMAT(promociones.final,'%d  %M %Y') AS 'fin', empresas.nombre, fotos_productos.foto
FROM empresas INNER JOIN productos ON empresas.id_empresa=productos.id_empresa
INNER JOIN promociones ON promociones.id_producto=productos.id_producto
INNER JOIN fotos_productos ON productos.id_producto=fotos_productos.id_producto
WHERE promociones.inicio <= CURRENT_DATE AND promociones.final >= CURRENT_DATE
GROUP BY promociones.id_promocion
ORDER BY promociones.inicio DESC LIMIT 8;";

	$res=$conn->conexion->query($sql) or die($conn->conexion->error);

 ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Inicio</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>
		<link rel="stylesheet" href="toast/toastr.css">
		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

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
		<style>
	.div-col{
		margin-bottom: 15px;
		vertical-align: middle !important;
	}
	.col-md-3 label{
		font-size: 12px;
	}
	.col-md-3 input{
		text-align: center;
	}
	#txtCantidad, #txtTotal, #txtPrecio {
		text-align: center;
	}
</style>
		<!--Modal cantidad-->
		<div class="modal fade" id="modal-cantidad" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content" style="margin-top: 30%;">
					<div class="modal-body">
						<div class="container-fluid">
							<div class="form-group col-md-4">
								<label for="txtCantidad">Cantidad:</label>
								<div class="input-group">
      								<div class="input-group-addon"><i class="fa fa-slack"></i></div>
      								<input type="number" id="txtCantidad" class="input">
    							</div>
    						</div>
    						<div class="form-group col-md-4">
								<label for="txtPrecio">Precio:</label>
								<div class="input-group">
      								<div class="input-group-addon">L. </div>
      								<input type="number" id="txtPrecio" class="input" disabled>
    							</div>
    						</div>
    						<div class="form-group col-md-4">
								<label for="txtTotal">Total:</label>
								<div class="input-group">
      								<div class="input-group-addon">L. </div>
      								<input type="number" id="txtTotal" class="input" disabled>
    							</div>
    						</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
						<button class="btn btn-success btn-sm" id="btnAgregar">Agregar</button>
					</div>
				</div>
			</div>
		</div>
		<!---->
		<!-- MODAL LOGIN -->
		<div class="modal fade" id="modal-login">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content" style="margin-top: 30%;">
					<div class="modal-header">
						<div class="modal-close">
							<button class="close" data-dismiss="modal">&times;</button>
						</div>
						<h4 class="modal-title">Ingresar</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="btn-group" role="group" aria-label="...">
  								<button type="button" class="btn btn-info active" id="btnCliente-login">Cliente</button>
  								<button type="button" class="btn btn-default" id="btnComercio-login">Comercio</button>
							</div>
						</div>
						<form id="contenido-form-login">
							<div class="form-group">
								<label for="txtUser-login">Correo Eléctronico: </label>
    							<div class="input-group">
      								<div class="input-group-addon"><i class="fa fa-user"></i></div>
      								<input type="email" class="input" id="txtUser-login" placeholder="ej: user@email.com">
    							</div>
							</div>
							<div class="form-group">
								<label for="txtPass-login">Contraseña: </label>
    							<div class="input-group">
      								<div class="input-group-addon"><i class="fa fa-lock"></i></div>
      								<input type="password" class="input" id="txtPass-login" placeholder="Password">
    							</div>
							</div>
							<div class="form-group">
									<button type="button" class="btn btn-danger" id="btnCancelar-login" style="width: 49%;" data-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
									<button type="button" class="btn btn-success" id="btnIngresar" onclick='fnVerificar("cliente")' style="width: 49%; float: right;"> <i class="fa fa-sign-in"></i> Ingresar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /MODAL LOGIN -->

		<!-- MODAL REGISTRO -->
		<div class="modal fade" id="modal-registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: scroll;">
			<div class="modal-dialog modal-dialog-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Registrar</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="btn-group" role="group" aria-label="...">
  							<button type="button" class="btn btn-info active" id="btnCliente">Cliente</button>
  							<button type="button" class="btn btn-default" id="btnComercio">Comercio</button>
						</div>
						</div>
						<form id="contenido-form" enctype="multipart/form-data">
						<div id="contenido-cliente">
							<div class="form-group">
								<label for="txtNombre">Nombre: </label>
								<input class="input" type="text" id="txtNombre" placeholder="Ingresa Tu Nombre">
							</div>
							<div class="form-group">
								<label for="txtApellido">Apellido: </label>
								<input class="input" type="text" id="txtApellido" placeholder="Ingresa Tu Apellido">
							</div>
							<div class="form-group">
								<label for="txtCelular">Telefono/Celular: </label>
    							<div class="input-group">
      								<div class="input-group-addon">+504 </div>
      								<input type="text" class="input" id="txtCelular" placeholder="Telefono/Celular">
    							</div>
							</div>
							<div class="form-group">
								<label for="txtCorreo">Correo: </label>
								<div class="input-group">
									<div class="input-group-addon">@</div>
									<input class="input" type="text" id="txtCorreo" placeholder="ej: email@email.com">
								</div>
							</div>
							<div class="form-group">
								<label for="txtPass-cliente">Contraseña: </label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-lock"></i></div>
									<input class="input" type="password" id="txtPass-cliente">
								</div>
							</div>
						</div>

						<div id="contenido-comercio" hidden="hidden">
							<div class="form-group">
								<label for="imagen">Logo: </label>
								<div id="divFoto" style="text-align: center;"></div>
								<input type="file" id="imagen" accept="image/x-png,image/gif,image/jpeg">
							</div>
							<div class="form-group">
								<label for="txtRTN">RTN: </label>
								<input class="input" type="text" id="txtRTN" placeholder="Ingresa El RTN">
							</div>
							<div class="form-group">
								<label for="txtNombreC">Nombre: </label>
								<input class="input" type="text" id="txtNombreC" placeholder="Ingresa El Nombre Del Comercio">
							</div>
							<div class="form-group">
								<label for="txtEslogan">Eslogan: </label>
								<textarea class="form-control" id="txtEslogan" placeholder="Ingresa Un Eslogan" rows="2"></textarea>
							</div>
							<?php $res_cat=$conn->buscar("categorias","id_categoria,categoria","1=1"); ?>
							<div class="form-group">
								<select name="" id="categoria" class="input">
									<option value="0">Selecciona Una Categoria...</option>
									<?php while($cat=$res_cat->fetch_assoc()){ ?>
										<option value="<?php echo $cat['id_categoria']; ?>"><?php echo $cat['categoria']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div style="text-align: center;">
								<button type="button" class="btn btn-primary" id="btnNext">Siguiente <i class="fa fa-chevron-right"></i></button>
							</div>
						</div>

						<div id="contenido-comercio2" hidden>
							<div class="form-group">
								<label for="txtPais">Pais: </label>
    							<div class="input-group">
      								<div class="input-group-addon"><i class="fa fa-globe"></i></div>
      								<input type="text" class="input" id="txtPais" placeholder="Ingresa Tu Pais">
    							</div>
							</div>
							<div class="form-group">
								<label for="txtDireccion">Direccion: </label>
								<textarea class="form-control" id="txtDireccion" placeholder="Ingresa La Direccion" rows="2"></textarea>
							</div>
							<div class="form-group">
								<label for="txtCelularC">Telefono/Celular: </label>
    							<div class="input-group">
      								<div class="input-group-addon"><i class="fa fa-phone"></i></div>
      								<input type="text" class="input" id="txtCelularC" placeholder="Telefono/Celular">
    							</div>
							</div>
							<div class="form-group">
								<label for="txtCorreoC">Correo: </label>
								<div class="input-group">
									<div class="input-group-addon">@</div>
									<input class="input" type="email" id="txtCorreoC" placeholder="email@email.com">
								</div>
							</div>
							<div class="form-group">
								<label for="txtPass">Contraseña: </label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-lock"></i></div>
									<input class="input" type="password" id="txtPass">
								</div>
							</div>
						</div>

						</form>
					</div>
					<div class="modal-footer" id="footer-registro">
						<button class="btn btn-secondary" data-dismiss="modal" id="btnCancelar">Cancelar</button>
						<button class="btn btn-success" id="btnRegistrar" onclick="fnRegistrarCliente();">Registrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /MODAL REGISTRO -->

		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +504 2799-1278</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> store@gmail.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 16201 Catacamas, Olancho</a></li>
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
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<?php if(!isset($_SESSION['id'])){ ?>
								<div>
									<a data-target="#modal-registro" data-toggle="modal">
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
									<a class="dropdown-toggle" href="#modal-login" data-toggle="modal" aria-expanded="true">
										<i class="fa fa-sign-in"></i>
										<span>Ingresar</span>
									</a>
								</div>
								<?php }else{ ?>
								<div class="dropdown">
									<a class="dropdown-toggle" href="carrito.php" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Carrito</span>
										<span class="qty">2</span>
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

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row" id="row-categorias">
					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="http://tecserva.com/images/Producto3.png" alt="" height="">
							</div>
							<div class="shop-body">
								<h3>Laptop<br>Collection</h3>
								<a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Nuevas Promociones</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav" id="ul-categorias">
									
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1" id="div-nuevas-promociones">
										<!-- product -->
										<?php while ($row=$res->fetch_assoc()) { ?>
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
											<div class="add-to-cart">
												<?php if(!isset($_SESSION['id'])){ ?>
												<button class="add-to-cart-btn" onclick="fnModalAgregarAlCarrito(0,0);">
													<i class="fa fa-cart-plus"></i> Agregar
												</button>
												<?php }else{
													$str = str_replace ( ',', '', $row['total']);
												 ?>
												<button class="add-to-cart-btn" onclick="fnModalAgregarAlCarrito(<?php echo $row['id_producto'].",".$str; ?>)">
													<i class="fa fa-cart-plus"></i> Agregar
												</button>
												<?php } ?>
											</div>
										</div>
										<?php } ?>
										
										<!-- /product -->
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- HOT DEAL SECTION -->
		<div id="hot-deal" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="hot-deal">
							<ul class="hot-deal-countdown">
								<li>
									<div>
										<h3>10%</h3>
										<span>Desde</span>
									</div>
								</li>
								<li>
									<div>
										<h3>20%</h3>
									</div>
								</li>
								<li>
									<div>
										<h3>40%</h3>
									</div>
								</li>
								<li>
									<div>
										<h3>60%</h3>
										<span>Hasta</span>
									</div>
								</li>
							</ul>
							<h2 class="text-uppercase">Descuentos</h2>
							<p>El mejor sitio de promociones</p>
							<a class="primary-btn cta-btn" href="promociones_c.php">Ver Todas</a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /HOT DEAL SECTION -->
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
		<script src="index-js.js"></script>
		<script src="js/main.js"></script>
		<script src="toast/toastr.js"></script>
		
		<script src="Cambas_Fotos/functions.js"></script>
		<script src="Cambas_Fotos/scripts.js"></script>
		<?php if(isset($_REQUEST['s'])){ ?>
			<script>
				 $('#modal-login').modal('show');
			</script>
		<?php }elseif(isset($_REQUEST['r'])){ ?>
			<script>
				$('#modal-registro').modal('show');
			</script>
		<?php } ?>
	</body>
</html>
