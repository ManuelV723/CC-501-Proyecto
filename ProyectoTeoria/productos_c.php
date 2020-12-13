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

		<title>Productos</title>

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
								<div>
									<a  href="index.php?r=n">
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
									<a class="dropdown-toggle" href="index.php?s=n" aria-expanded="true">
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
						<li><a href="index.php">Inicio</a></li>
						<li><a href="promociones_c.php">Promociones</a></li>
						<li class="active"><a href="productos_c.php">Productos</a></li>
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
							<li><a href="#">Productos</a></li>
							<li class="active">Carrito</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- ASIDE -->
					
					<!-- /ASIDE -->

					<!-- STORE -->
					<div id="store" class="col-md-12">
						<!-- store top filter -->
						<div class="store-filter clearfix">
							<div class="store-sort">
								<label>
									Categoria:
									<select class="input-select" id="select-cat">
										<?php $cat=$conn->buscar("categorias","*","1=1");
											  while($row_cat=$cat->fetch_assoc()){ ?>
												<option value="<?php echo $row_cat['id_categoria']; ?>"><?php echo $row_cat['categoria']; ?></option>
										<?php } ?>
									</select>
								</label>

								<!--<label>
									Show:
									<select class="input-select">
										<option value="0">20</option>
										<option value="1">50</option>
									</select>
								</label>
							</div>
							<ul class="store-grid">
								<li class="active"><i class="fa fa-th"></i></li>
								<li><a href="#"><i class="fa fa-th-list"></i></a></li>
							</ul>-->
						</div>
						<!-- /store top filter -->
						<!-- store products -->
						<div class="row" id="div-nuevas-promociones">
							<!-- product -->
							<div class="col-md-3 col-xs-6">
								<div class="product">
									<div class="product-img">
										<img src="./img/product01.png" alt="">
										<div class="product-label">
											<span class="sale">-30%</span>
											<span class="new">NEW</span>
										</div>
									</div>
									<div class="product-body">
										<p class="product-category">Category</p>
										<h3 class="product-name"><a href="#">product name goes here</a></h3>
										<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="product-btns">
											<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
											<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
											<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
										</div>
									</div>
									<div class="add-to-cart">
										<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
									</div>
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
		<script src="productos_c.js"></script>
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
