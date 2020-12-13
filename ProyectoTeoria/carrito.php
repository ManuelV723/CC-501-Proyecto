<?php 

include 'conexion.php';

$conn= new 	Connect();
if(isset($_SESSION['id'])){
	$conn->rolCliente($_SESSION['rol']);
}
$id_cliente=$_SESSION['id'];
$datos=$conn->buscar("clientes","*","id_cliente='$id_cliente'");
$datos=$datos->fetch_assoc();
 ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Carrito</title>

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
								<div>
									<a href="perfil.php">
										<i class="fa fa-user"></i>
										<span><?php echo $datos['nombre']; ?></span>
									</a>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								
								
								<div class="dropdown">
									<a class="dropdown-toggle" aria-expanded="true" href="cerrar_sesion.php">
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
						<li><a href="index.php">Inicio</a></li>
						<li><a href="promociones_c.php">Promociones</a></li>
						<li><a href="promociones_c.php">Productos</a></li>
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
							<li><a href="productos_c.php">Productos</a></li>
							<li class="active">Carrito</li>
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
		text-align: center;
	}
	.table thead tr th{
		text-align: center;
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
		<div class="section" style="padding-top: 15px;">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-8" align="center" id="div-tabla">
						<table class="table table-responsive">
							<thead>
								<th></th>
								<th>Producto</th>
								<th>Cant</th>
								<th>Precio</th>
								<th>Descuento</th>
								<th>SubTotal</th>
								<th>Total</th>
								<th class="imagen"></th>
							</thead>
							<tbody id="tbody">
								
							</tbody>
						</table>
					</div>

					<div class="col-md-8 panel panel-default" align="center" id="div-datos" style="padding: 15px 15px" hidden>
  						<div class="col-md-12" id="div-radio" style="margin-top: 15px;" >
  							<label class="radio-inline">
  								<input type="radio" id="radio" name="radio" value="option1"><i class="fa fa-cc-mastercard" style="font-size: 25px;"></i>
							</label>
							<label class="radio-inline">
  								<input type="radio" id="radio" name="radio" value="option2"><i class="fa fa-cc-visa" style="font-size: 25px;"></i>
							</label>
							<label class="radio-inline">
  								<input type="radio" id="radio" name="radio" value="option2"><i class="fa fa-cc-discover" style="font-size: 25px;"></i>
							</label>
							<label class="radio-inline">
  								<input type="radio" name="radio" value="option2"><i class="fa fa-cc-jcb" style="font-size: 25px;"></i>
							</label>
							<label class="radio-inline">
  								<input type="radio" id="radio" name="radio" value="option2"><i class="fa fa-cc-amex" style="font-size: 25px;"></i>
							</label>
						</div>
						<div class="col-md-8" style="margin-top: 15px;">
    						<div class="input-group">
      							<input type="number" class="form-control" id="txtTarjeta" placeholder="Numero De Tarjeta...">
      							<span class="input-group-btn">
        							<button class="btn btn-default" type="button"><i class="fa fa-credit-card"></i></button>
      							</span>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
  						<div class="col-md-4" style="margin-top: 15px;">
    						<div class="input-group">
      							<input type="password" class="form-control" id="txtCodigo" placeholder="Código (XXXX)...">
      							<span class="input-group-btn">
        							<button class="btn btn-default" type="button"><i class="fa fa-lock"></i></button>
      							</span>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
  						<div class="col-md-6" style="margin-top: 15px;">
    						<div class="input-group">
      							<input type="text" class="form-control" id="txtNombre" placeholder="Nombre..." value="<?php echo $datos['nombre'] ?>">
      							<span class="input-group-btn">
        							<button class="btn btn-default" type="button"><i class="fa fa-user-o"></i></button>
      							</span>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
						<div class="col-md-6" style="margin-top: 15px;">
    						<div class="input-group">
      							<input type="text" class="form-control" id="txtApellido" placeholder="Apellido..." value="<?php echo $datos['apellido'] ?>">
      							<span class="input-group-btn">
        							<button class="btn btn-default" type="button"><i class="fa fa-user-o"></i></button>
      							</span>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
  						<div class="col-md-12" style="margin-top: 15px;">
    						<div class="input-group">
      							<input type="text" class="form-control" id="txtDireccion" placeholder="Direccion...">
      							<span class="input-group-btn">
        							<button class="btn btn-default" type="button"><i class="fa fa-map-marker"></i></button>
      							</span>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
  						<div class="col-md-12" style="margin-top: 15px;">
    						<div class="input-group">
      							<input type="email" class="form-control" id="txtCorreo" placeholder="Correo Electronico..." value="<?php echo $datos['correo'] ?>">
      							<span class="input-group-btn">
        							<button class="btn btn-default" type="button"><i class="fa fa-envelope-o"></i></button>
      							</span>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
  						<div class="col-md-12" style="margin-top: 15px;">
    						<div class="input-group">
      							<input type="text" class="form-control" id="txtTelefono" placeholder="Nº Telefono/Celular..." value="<?php echo $datos['celular'] ?>">
      							<span class="input-group-btn">
        							<button class="btn btn-default" type="button"><i class="fa fa-phone"></i></button>
      							</span>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
  						<div class="col-md-6" style="margin-top: 15px;">
    						<div class="input-group" style="width: 100%;">
      							<button class="btn btn-secondary" id="btnRegresar" style="border-radius: 0px; width: 100%;"><i class="fa fa-chevron-left"></i> Regresar</button>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
  						<div class="col-md-6" style="margin-top: 15px;">
    						<div class="input-group" style="width: 100%;">
      							<button class="btn btn-primary" id="btnFinalizar" style="border-radius: 0px; width: 100%;">Finalizar <i class="fa fa-check"></i></button>
    						</div><!-- /input-group -->
  						</div><!-- /.col-lg-6 -->
					</div>
				
					<div class="col-md-4" align="center">
						<div class="panel panel-primary">
							<div class="panel-heading">Resumen</div>
							<div class="panel-body">
								<table class="table">
									<tr>
										<td>SubTotal:</td>
										<td id="td-subtotal"></td>
									</tr>
									<tr>
										<td>Total Descuentos:</td>
										<td id="td-descuentos"></td>
									</tr>
									<tr>
										<td>Total:</td>
										<td id="td-total"></td>
									</tr>
								</table>
								<button class="btn btn-primary" style="width: 100%; border-radius: 0px; background-color: #D10024; border-color: transparent;" id="btnContinuar">Continuar</button>
							</div>
						</div>
					</div>
				</div>
				<!--row-->
				
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
		<script src="carrito.js"></script>
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
