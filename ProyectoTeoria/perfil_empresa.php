<?php
include 'conexion.php';
$conn = new Connect();

$conn->sesion();
if(isset($_SESSION['id'])){
	$conn->rolEmpresa($_SESSION['rol']);
}

$id_empresa=$_SESSION['id'];
$res = $conn->buscar("empresas","*","id_empresa='".$id_empresa."'");
$datos=$res->fetch_assoc();

 ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Perfil | Comercio</title>

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
		<!--MODAL EDITAR DATOS-->
		<div class="modal fade" id="modalEditar" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="titulo-modal"></h4>
					</div>
					<div class="modal-body">
						<div class="form-group col-md-6" style="padding-left: 0px;">
							<label for="txtNombre">Nombre Comercio:</label>
							<input type="text" class="input" id="txtNombre" >
						</div>
						<div class="form-group col-md-6" style="padding-left: 0px; padding-right: 0px !important;">
							<label for="txtEslogan">Eslogan: </label>
      						<textarea class="input" id="txtEslogan" rows="1" style="min-height: 40px;"></textarea>
						</div>
						<div class="form-group col-md-6" style="padding-left: 0px;">
							<label for="txtCorreo">Correo Eléctronico: </label>
    						<div class="input-group">
      							<div class="input-group-addon">@</div>
      							<input type="email" class="input" id="txtCorreo" placeholder="ej: user@email.com">
    						</div>
						</div>
						<div class="form-group col-md-6" style="padding-left: 0px; padding-right: 0px !important;">
							<label for="txtTelefono">Telefono/Celular: </label>
    						<div class="input-group">
      							<div class="input-group-addon"><i class="fa fa-phone"></i></div>
      							<input type="email" class="input" id="txtTelefono" placeholder="xxxxxxxx">
    						</div>
						</div>
						<div class="form-group">
							<label for="txtDireccion">Direccion:</label>
							<textarea class="input" id="txtDireccion" rows="3"></textarea>
						</div>
						<div class="form-group">
								<label> <input type="checkbox" id="CambiarPass"> Cambiar Contraseña </label>
    							<div class="input-group" id="divPass" style="visibility: hidden;">
      								<div class="input-group-addon"><i class="fa fa-lock"></i></div>
      								<input type="password" class="input" id="txtPass" placeholder="Password">
    							</div>
							</div>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-default" id="btnCancelar" data-dismiss="modal">Cancelar</button>
							<button class="btn btn-success" id="btnAceptar" onclick="modificarDatos_empresa()">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--FIN MODAL-->
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +504 <?php echo $datos['telefono']; ?></a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> <?php echo $datos['correo']; ?></a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> <?php echo $datos['pais'].", ".$datos['direccion']; ?></a></li>
					</ul>
					<ul class="header-links pull-right">
						<li><a href="#"><i class="fa fa-dollar"></i> LPS</a></li>
						<li><a href="#"><i class="fa fa-user-o"></i> <?php echo $datos['nombre']; ?></a></li>
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
									<img src="process_php/img/<?php echo $datos['logo']; ?>" height="90">
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
								<h2><?php echo $datos['nombre']; ?></h3>
								<h5><?php echo $datos['eslogan']; ?></h5>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="perfil_empresa.php">
										<i class="fa fa-user-circle-o"></i>
										<span>Mi Cuenta</span>
									</a>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" href="cerrar_sesion.php" aria-expanded="true">
										<i class="fa fa-sign-out"></i>
										<span>Cerrar Sesion</span>
									</a>
								</div>
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
			<input type="file" accept="image/x-png,image/gif,image/jpeg" id="logo" style="visibility: hidden;">
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
						<li><a href="promociones.php">Promociones</a></li>
						<li><a href="inicio_empresa.php">Productos</a></li>
						<li><a href="compras_e.php">Ventas</a></li>
						<li class="active"><a href="perfil_empresa.php">Mi Cuenta</a></li>
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
						<h3 class="breadcrumb-header">Mis Datos</h3>
						<ul class="breadcrumb-tree">
							<li><a href="promociones.php">Inicio</a></li>
							<li class="active">Mis Datos</li>
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
				<div class="row">
					<div class="panel panel-default col-md-8 col-md-offset-2">
  						<div class="panel-body">
  							<table class="table" style="width: 100%;">
  								<tr>
  									<td class="col-md-6" style="vertical-align: middle;">
  										<h3><?php echo $datos['nombre']; ?></h3>
  										<span style="font-size: 15px;"><?php echo $datos['rtn']; ?></span>
  									</td>
  									<td class="col-md-3">
  										<img height="150" id="imgLogo" src="process_php/img/<?php echo $datos['logo']; ?>" class="img-rounded">
  										<div class="btn-group" role="group" aria-label="..." id="botonesImagen" style="position: absolute;">
  											<button class="btn btn-sm btn-warning" id="btnEditarLogo" style="background-color: #D10024;"><i class="fa fa-pencil"></i></button>
  											<button type="button" id="btnGuardarLogo" onclick="cambiarLogo()" class="btn btn-sm btn-success" style="visibility: hidden;"><i class="fa fa-check"></i></button>
										</div>
  									</td>
  								</tr>
  							</table>
<style>
	.col-md-7 .fa{
		margin-right: 10px;
	}
</style>
  							<div class="col-md-7">
  								<p style="font-size: 17px; margin-bottom: 10px;">"<?php echo $datos['eslogan']; ?>"</p>
  								<p class="col"><i class="fa fa-envelope"></i> <?php echo $datos['correo']; ?></p>
  								<p class="col"><i class="fa fa-phone"></i> <?php echo $datos['telefono']; ?></p>
  								<p class="col"><i class="fa fa-map-marker"></i> <?php echo $datos['direccion']; ?></p>
  							</div>
  							<div class="col-md-2" style="vertical-align: middle;">
  								<button class="btn btn-danger" style="background-color: #D10024;" href="#modalEditar" data-toggle="modal" onclick="datosEmpresa()"><i class="fa fa-pencil-square-o"></i> Editar Información</button>
  							</div>
  						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

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
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Grupo #1<i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">UCENM</a>
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
		<script src="Cambas_Fotos/scripts_multiple.js"></script>
		<script src="perfil_empresa-js.js"></script>

	</body>
</html>
