<?php 

include 'conexion.php';

$conn= new 	Connect();
if(isset($_SESSION['id'])){
	$conn->rolCliente($_SESSION['rol']);
}
 ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Mi Cuenta</title>

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
		<!--Modal cantidad-->
		<div class="modal fade" id="modal-eliminar" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content" style="margin-top: 30%;">
					<div class="modal-body">
						<h4>Desea Eliminar Este Producto Del Carrito De Compras?</h4>
					</div>
					<div class="modal-footer">
						<button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
						<button class="btn btn-success btn-sm" id="btnEliminar">Confirmar</button>
					</div>
				</div>
			</div>
		</div>
		<!---->
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
								<!-- Wishlist -->
								<?php if(!isset($_SESSION['id'])){ ?>
								
								<?php }else{ 
									$id_cliente=$_SESSION['id'];
									$datos=$conn->buscar("clientes","*","id_cliente='$id_cliente'");
									$datos=$datos->fetch_assoc();
									?>
								<div>
									<a href="#">
										<i class="fa fa-user" style="color: #D10024;"></i>
										<span>Mi Cuenta</span>
									</a>
								</div>
								<?php } ?>
								<!-- /Wishlist -->

								<!-- Cart -->
								<?php if(!isset($_SESSION['id'])){ ?>
								
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
						<li><a href="index.php">Inicio</a></li>
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
							<li><a href="#">Perfil</a></li>
							<li class="active">Mis Datos</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
<style>
	.col-md-7 .input{
		margin-bottom: 10px;
	}
</style>
		<!-- /BREADCRUMB -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div id="store" class="col-md-12">
						<!-- store products -->
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									Mis Datos
									<div class="close" style="opacity: 100;" hidden id="div-btn">
										<button class="btn btn-secondary btn-sm" id="btnCancelar">Cancelar</button>
										<button class="btn btn-success btn-sm" id="btnEditar">Guardar</button>
									</div>
								</div>
								<div class="panel-body">
								 	<div class="col-md-5">
								 		<div class="form">
								 			Tipo: <b>Cliente</b><br><br>
								 			<p>
								 				<i class="fa fa-user" style="width: 20px;"></i> Nombre: <b id="lbNombre"></b>
								 			</p>
								 			<p>
								 				<i class="fa fa-envelope" style="width: 20px;"></i> Correo: <b id="lbCorreo"></b>
								 			</p>
								 			<p>
								 				<i class="fa fa-phone" style="width: 20px;"></i> Celular: <b id="lbTelefono"></b>
								 			</p>
								 		</div>
								 	</div>
								 	<div class="col-md-7">
								 		<div class="col-md-6">
								 			<input type="text" class="input" placeholder="Nombre..." id="txtNombre">	
								 		</div>
								 		<div class="col-md-6">
								 			<input type="text" class="input" placeholder="Apellido..." id="txtApellido">
								 		</div>
								 		<div class="col-md-12">
								 			<input type="text" class="input" placeholder="Correo Electrónico..." id="txtCorreo">
								 		</div>
								 		<div class="col-md-12">
								 			<input type="number" class="input" placeholder="Celular..." id="txtTelefono">
								 		</div>
								 		<div class="col-md-12">
								 			<input type="password" class="input" placeholder="Nueva Contraseña..." id="txtPass">
								 		</div>
								 	</div>
								</div>
							</div>
						</div>
					</div>
				<!--row-->
				</div>
			</div>
			<!-- /container -->
		</div>
		<!-- Section -->
		
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
		<script src="perfil.js"></script>
		<script>
			/*$('#h-nombreEmpresa').html('<?php //echo $empresa; ?>');
			$('#h-esloganEmpresa').html('<?php //echo $eslogan; ?>');
			$('.logo img').attr('src','process_php/img/<?php //echo $logo; ?>');
			$('.fa-envelope-o').after(' <?php //echo $correo; ?>');
			$('.fa-phone').after(' <?php //echo $telefono; ?>');
			$('.fa-map-marker').after( '<?php //echo $direccion; ?>') */
		</script>

	</body>
</html>
