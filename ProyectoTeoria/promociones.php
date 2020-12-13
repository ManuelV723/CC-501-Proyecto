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

		<title>Promociones | Comercio</title>

 		<!-- Google font -->
 		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

 		<!-- Bootstrap -->
 		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

 		<!-- Slick -->
 		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
 		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

 		<!-- nouislider -->
 		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

 		<!-- Font Awesome Icon -->
 		<link rel="stylesheet" href="css/font-awesome.min.css">

 		<!-- Custom stlylesheet -->
 		<link type="text/css" rel="stylesheet" href="css/style.css"/>
 		<link rel="stylesheet" href="toast/toastr.css">
 		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
 		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
 		<!--[if lt IE 9]>
 		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
 		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 		<![endif]-->

    </head>
	<body>
		<!--MODAL AGREGAR PROMOCION-->
		<div class="modal fade" id="modalPromocion" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Nueva Promocion</h4>
					</div>
					<div class="modal-body">
						<div id="contenido1-modal">
						<div class="form-group col-md-6 div-col">
    						<div class="input-group">
      							<div class="input-group-addon"><i class="fa fa-search"></i></div>
      							<input type="text" class="input" id="txtBuscar-modal" placeholder="Buscar Producto...">
    						</div>
						</div>
						<div class="container-fluid">
							<table class="table table-responsive">
								<thead>
									<th>Producto</th>
									<th>Precio</th>
									<th></th>
								</thead>
								<tbody id="tbody-modal">
									<tr>
										<td>Mouse</td>
										<td>L. 128.00</td>
										<td style="text-align: center;">
											<button class="btn btn-success btn-sm">
												<i class="fa fa-check"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!--<div style="text-align: center;">
							<button type="button" class="btn btn-primary" id="btnNext">Siguiente <i class="fa fa-chevron-right"></i></button>
						</div>-->
						</div>
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
</style>
						<div id="contenido2-modal" class="container-fluid" hidden>
							<div class="form-group col-md-3">
								<label for="">Porcentaje de descuento:</label>
								<div class="input-group">
      								<div class="input-group-addon">%</div>
      								<input type="number" id="txtDesPor" class="input">
    							</div>
    						</div>
    						<div class="form-group col-md-3">
								<label for="">Precio:</label>
								<div class="input-group">
      								<div class="input-group-addon">L. </div>
      								<input type="number" id="txtPrecio" class="input" disabled>
    							</div>
    						</div>
    						<div class="form-group col-md-3">
								<label for="">Descuento:</label>
								<div class="input-group">
      								<div class="input-group-addon">L. </div>
      								<input type="number" id="txtDescuento" class="input" disabled>
    							</div>
    						</div>
    						<div class="form-group col-md-3">
								<label for="">Total:</label>
								<div class="input-group">
      								<div class="input-group-addon">L. </div>
      								<input type="number"id="txtTotal" class="input" disabled>
    							</div>
    						</div>
							<div class="form-group col-md-6 div-col">
								<label for="fecha-inicio">Elije la fecha de inicio de esta promoción:</label>
								<div class="input-group">
      								<div class="input-group-addon"><i class="fa fa-calendar-check-o"></i></div>
      								<input type="datetime-local" class="input" id="fecha-inicio">
    							</div>
    						</div>
    						<div class="form-group col-md-6 div-col">
    							<label for="fecha-fin">Elije la fecha final de esta promoción:</label>
    							<div class="input-group">
      								<div class="input-group-addon"><i class="fa fa-calendar-times-o"></i></div>
      								<input type="datetime-local" class="input" id="fecha-fin">
    							</div>
    						</div>
    						<div class="form-group col-md-12">
								<label for="txtNombre">Nombre De La Promoción</label>
								<textarea class="input" id="txtNombre" rows="3" placeholder="Agrega un nombre para esta promocion"></textarea>
							</div>
    						<div class="form-group" style="text-align: right;">
								<button class="btn btn-default" id="btnCancelar"> <i class="fa fa-chevron-left"></i> Volver</button>
								<button class="btn btn-success" id="btnAceptar" onclick="fnNuevaPromocion()">Aceptar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
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
						<li class="active"><a href="promociones.php">Promociones</a></li>
						<li><a href="inicio_empresa.php">Productos</a></li>
						<li><a href="compras_e.php">Ventas</a></li>
						<li><a href="perfil_empresa.php">Mi Cuenta</a></li>
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
						<h3 class="breadcrumb-header">Promociones</h3>
						<ul class="breadcrumb-tree">
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->
<style>
	#tbody tr td{
		vertical-align: middle;
	}
	.imagen{
		text-align: center;
	}
	.col-md-12{
		overflow-x: scroll;
	}
	.col-md-12::-webkit-scrollbar {
    	display: none;
	}
	#estado{
		font-size: 10px;
    	font-weight: bold;
    	border-top-style: solid;
    	border-top-width: 2.5px;
		/*#d9534f rojo*/
	}
	.div-col{
		margin-bottom: 15px;
		vertical-align: middle !important;
	}
</style>
		<!-- SECTION -->
		<div class="section" style="padding-top: 15px;">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-6 div-col" style="height: 40px;">
						<button class="btn" style="background-color: #D10024; color: #fff;" href="#modalPromocion" data-toggle="modal" onclick="mostrarProductos();"><i class="fa fa-plus"></i> Agregar Promocion</button>
					</div>
					<div class="form-group col-md-6 div-col">
    					<div class="input-group">
      						<div class="input-group-addon"><i class="fa fa-search"></i></div>
      						<input type="text" class="input" id="txtBuscar" placeholder="Buscar por nombre de producto...">
    					</div>
					</div>
					<div class="col-md-12" align="center">
						<table class="table table-responsive">
							<thead>
								<th></th>
								<th>Producto</th>
								<th>Precio</th>
								<th>Descuento</th>
								<th class="imagen">Inicio</th>
								<th class="imagen">Fin</th>
							</thead>
							<tbody id="tbody">
								<tr>
									<td class="imagen">
										<img src="process_php/img/125672993-microscope-logo-icon-vector-illustration-design-template.jpg" height="55" alt="">
									</td>
									<td>Laptop DELL</td>
									<td>L. 1678.99</td>
									<td class="imagen">25 %</td>
									<td class="imagen"><span class="label label-success">18 de noviembre</span></td>
									<td class="imagen"><span class="label label-danger">23 de noviembre</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- NEWSLETTER -->
		<div id="newsletter" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /NEWSLETTER -->

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
		<script src="promociones-js.js"></script>
	</body>
</html>
