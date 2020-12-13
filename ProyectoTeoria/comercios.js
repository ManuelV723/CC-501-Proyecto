$(function(){
fnMostrarComercios();


	$('#btnComercio').click(
		function() {
			$('#btnComercio').addClass('active');
			$('#btnComercio').addClass('btn-info');
			$('#btnCliente').removeClass('active');
			$('#btnCliente').removeClass('btn-info');
			$('#btnCliente').addClass('btn-default');

			$('#contenido-cliente').attr('hidden','hidden');
			$("#contenido-comercio").removeAttr('hidden');
			$('#contenido-comercio2').attr('hidden','hidden');
			$("#footer-registro").attr('hidden','hidden');
		}
	);
	$('#btnCliente').click(
		function() {
			$('#btnCliente').addClass('active');
			$('#btnCliente').addClass('btn-info');
			$('#btnComercio').removeClass('active');
			$('#btnComercio').removeClass('btn-info');
			$('#btnComercio').addClass('btn-default');
			$('#contenido-comercio').attr('hidden','hidden');
			$('#contenido-comercio2').attr('hidden','hidden');
			$("#contenido-cliente").removeAttr('hidden');
			$("#footer-registro").removeAttr('hidden');
			$('#btnRegistrar').attr('onclick','fnRegistrarCliente()');
			//$('#contenido-form').html('<div class="form-group"><label for="txtNombre">Nombre: </label><input class="input" type="text" id="txtNombre" placeholder="Ingresa Tu Nombre"></div><div class="form-group"><label for="txtApellido">Apellido: </label><input class="input" type="text" id="txtApellido" placeholder="Ingresa Tu Apellido"></div><div class="form-group"><label for="txtCelular">Telefono/Celular: </label><div class="input-group"><div class="input-group-addon">+504 </div><input type="text" class="input" id="txtCelular" placeholder="Telefono/Celular"></div></div><div class="form-group"><label for="txtCorreo">Correo: </label><div class="input-group"><div class="input-group-addon">@</div><input class="input" type="text" id="txtCorreo" placeholder="email@email.com"></div></div>');

		}
	);

	$('#btnNext').click( function(){

		function controles(){
			$('#contenido-comercio').attr('hidden','hidden');
			$('#contenido-comercio2').removeAttr('hidden');
			$('#btnRegistrar').attr('onclick','fnRegistrarComercio()');
			$("#footer-registro").removeAttr('hidden');
		}

		var txtRTN = $('#txtRTN').val();
		var txtNombre = $('#txtNombreC').val();
		var txtEslogan = $('#txtEslogan').val();
		if(txtRTN.length <= 0){
			$('#txtRTN').css('border-color', 'red');
		}else{
			if(txtNombre.length <= 0){
				$('#txtNombreC').css('border-color', 'red');
			}else{
				if(txtEslogan.length <= 0){
					$('#txtEslogan').css('border-color', 'red');
				}else{
					if($("#imagen")[0].files.length <= 0){
						toastr.info('Elije un logo!','Info',{
							"positionClass": "toast-bottom-center",
							"timeOut": "3000",
							"closeButton": true
						});
					}else{
						if($("#categoria").val()==0){
							$('#categoria').css('border-color', 'red');
						}else{
							controles();
						}
					}
				}
			}
		}
	});

	$('#txtRTN').change( function(){
		$('#txtRTN').css('border-color', '#ccc');
	});
	$('#txtNombreC').change( function(){
		$('#txtNombreC').css('border-color', '#ccc');
	});
	$('#txtEslogan').change( function(){
		$('#txtEslogan').css('border-color', '#ccc');
	});
});

$('#txtDireccion').change( function(){
	$('txtDireccion').css('border-color','#ccc');
});

$('#txtPais').change( function(){
	$('txtPais').css('border-color','#ccc');
});

$('#txtCorreoC').change( function(){
	$('txtCorreoC').css('border-color','#ccc');
});

$('#txtCelularC').change( function(){
	$('txtCelularC').css('border-color','#ccc');
});

$('#txtCantidad').change(function(){
	var cant = $('#txtCantidad').val();
	var precio = $('#txtPrecio').val();
	$('#txtTotal').val(cant*precio);
	$('#txtCantidad').css('border-color','#ccc');
});

$('#txtCantidad').keyup(function(){
	var cant = $('#txtCantidad').val();
	var precio = $('#txtPrecio').val();
	$('#txtTotal').val(cant*precio);
});

function deshabilitarBotones(){
		$('#btnRegistrar').attr('disabled','disabled');
		$('#btnRegistrar').html('Cargando...');
		$('#btnCancelar').attr('disabled','disabled');
	};
	function habilitarBotones(){
		$('#btnRegistrar').removeAttr('disabled');
		$('#btnRegistrar').html('Registrar');
		$('#btnCancelar').removeAttr('disabled');
	};
function fnRegistrarComercio(){
		var rtn = $('#txtRTN').val();
		var nombre = $('#txtNombreC').val();
		var eslogan = $('#txtEslogan').val();
		var correo = $('#txtCorreoC').val();
		var telefono = $('#txtCelularC').val();
		var pais = $('#txtPais').val();
		var direccion = $('#txtDireccion').val();
		var pass = $('#txtPass').val();
		var categoria = $('#categoria').val();

		if(pais.length <= 0){
			$('#txtPais').css('border-color','red');
		}else{
			if(direccion.length <= 0){
				$('#txtDireccion').css('border-color','red');
			}else{
				if(correo.length <= 0){
					$('#txtCorreoC').css('border-color','red');
				}else{
					if(telefono.length <= 0){
						$('#txtCelularC').css('border-color','red');
					}else{
						if(pass.length <= 0){
							$('#txtPass').css('border-color','red');
						}else{
						var frmData = new FormData;
						frmData.append("logo",$("#imagen")[0].files[0]);
						frmData.append("rtn",rtn);
						frmData.append("nombre",nombre);
						frmData.append("eslogan",eslogan);
						frmData.append("correo",correo);
						frmData.append("telefono",telefono);
						frmData.append("pais",pais);
						frmData.append("direccion",direccion);
						frmData.append("pass",pass);
						frmData.append("categoria",categoria);
						$.ajax({
							url: 'process_php/registrar_comercio.php',
							type: 'POST',
							data: frmData,
							processData: false,
        					contentType: false,
        					cache: false,
							beforeSend: function(){
								deshabilitarBotones();
							},
							success: function(res){
								console.log(res);
								if(res == 1){
									$('#modal-registro').modal('hide');
									habilitarBotones();
									toastr.success('Inicia Sesion Por Primera Vez!','Listo',{
										"positionClass": "toast-bottom-center",
										"timeOut": "3000",
										"closeButton": true
									});
								}else{
									if(res==2){
										habilitarBotones();
										toastr.info('El usuario que intentas registrar ya existe','Info!',{
											"positionClass": "toast-bottom-center",
											"timeOut": "3000",
											"closeButton": true
										});
									}else{
										habilitarBotones();
										toastr.error('Ocurrió Algo Inesperado!','Error',{
											"positionClass": "toast-bottom-center",
											"timeOut": "3000",
											"closeButton": true
										});
									}
								}
							},
							error: function(){
								habilitarBotones();
								toastr.error('Ocurrió Algo Inesperado!','Error',{
									"positionClass": "toast-bottom-center",
									"timeOut": "3000",
									"closeButton": true
								});
							}
						});
						}
					}
				}
			}
		}

	};
function fnRegistrarCliente(){
	var nombre = $("#txtNombre").val();
	var apellido = $("#txtApellido").val();
	var celular = $("#txtCelular").val();
	var correo = $("#txtCorreo").val();
	var pass = $("#txtPass-cliente").val();
	var datos = ["txtNombre","txtApellido","txtCelular","txtCorreo","txtPass-cliente"];
	var contador=0;
	for (var i = 0; i < datos.length; i++) {
		if($("#"+datos[i]+"").val().length==0){
			$("#"+datos[i]+"").css('border-color','red');
			contador++;
		}
	}
	if(contador==0){
		$.ajax({
			url: 'process_php/registrar_cliente.php',
			type: 'POST',
			data: {nombre: nombre, apellido: apellido, celular: celular, correo: correo, pass: pass},
			beforeSend: function(){
				deshabilitarBotones();
			},
			success: function(res){
				if(res==1){
					$('#modal-registro').modal('hide');
					habilitarBotones();
					toastr.success('Inicia Sesion Por Primera Vez!','Listo',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
				}else{
					if(res==2){
						habilitarBotones();
						toastr.info('El usuario que intentas registrar ya existe','Info!',{
							"positionClass": "toast-bottom-center",
							"timeOut": "3000",
							"closeButton": true
						});
					}else{
						habilitarBotones();
						toastr.error('Ocurrió Algo Inesperado!','Error',{
							"positionClass": "toast-bottom-center",
							"timeOut": "3000",
							"closeButton": true
						});
					}
				}
			},
			error: function(){
				habilitarBotones();
				toastr.error('Ocurrió Algo Inesperado!','Error',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});
			}
		})
	}
}
// LOGIN

$("#btnCliente-login").click( function(){
	$('#btnCliente-login').addClass('active');
	$('#btnCliente-login').addClass('btn-info');
	$('#btnComercio-login').removeClass('active');
	$('#btnComercio-login').removeClass('btn-info');
	$('#btnComercio-login').addClass('btn-default');
	$("#btnIngresar").attr('onclick','fnVerificar("cliente")');
});

$("#btnComercio-login").click( function(){
	$('#btnComercio-login').addClass('active');
	$('#btnComercio-login').addClass('btn-info');
	$('#btnCliente-login').removeClass('active');
	$('#btnCliente-login').removeClass('btn-info');
	$('#btnCliente-login').addClass('btn-default');
	$("#btnIngresar").attr('onclick','fnVerificar("comercio")');
});

function beforeLogin(){
	$("#txtUser-login").attr('disabled','disabled');
	$("#txtPass-login").attr('disabled','disabled');
	$("#btnIngresar").attr('disabled','disabled');
	$("#btnIngresar").html('Verificando...');
	$("#btnCancelar-login").attr('disabled','disabled');
}

function responseLogin(){
	$("#txtUser-login").removeAttr('disabled');
	$("#txtPass-login").removeAttr('disabled');
	$("#btnIngresar").removeAttr('disabled');
	$("#btnIngresar").html('<i class="fa fa-sign-in"></i> Ingresar');
	$("#btnCancelar-login").removeAttr('disabled');
}

function fnVerificar(tipo_user){
	var user = $("#txtUser-login").val();
	var pass = $("#txtPass-login").val();
	if (user.length==0) {
		$("#txtUser-login").css('border-color','red');
	}else{
		if(pass.length==0){
			$("#txtPass-login").css('border-color','red');
		}else{
			$.ajax({
				url: 'process_php/verificar.php',
				type: 'POST',
				data: {tipo_user: tipo_user, user: user, pass: pass},
				beforeSend: function(){
					beforeLogin();
				},
				success: function(res){
					if(res==1){
						console.log("Listo  rol: cliente");
						window.location = 'comercios.php';
						responseLogin();
					}else{
						if(res==2){
							console.log("Listo  rol: empresa");
							window.location.href = "inicio_empresa.php";
							responseLogin();
						}else{
							console.log(res);
							toastr.info('Usuario y/o Contraseña Incorrectos!','Verifica Tus Datos',{
								"positionClass": "toast-bottom-center",
								"timeOut": "3000",
								"closeButton": true
							});
							responseLogin();
						}
					}
				},
				error: function(){
					toastr.error('Ocurrió Algo Inesperado!','Error',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
					responseLogin();
				}
			});
		}
	}
}

function fnMostrarComercios(){
	$.ajax({
		url: 'process_php/fnMostrarComercios.php',
		type: 'POST',
		success: function(res){
			var js = JSON.parse(res);
			var row = '';
			for (var i = 0; i < js.length; i++) {
				row += '<div class="col-md-4 col-xs-6"><div class="shop"><div class="shop-img"><img src="process_php/img/'+js[i].logo+'" height="250" style="object-fit: cover;"></div><div class="shop-body"><h3>'+js[i].nombre+'<br><h5 style="color: #fff;">'+js[i].eslogan+'</h5></h3><a href="promociones_cc.php?emp='+btoa(js[i].id_empresa)+'" class="cta-btn">ir <i class="fa fa-arrow-circle-right"></i></a></div></div></div>';
			}
			$('#row-categorias').html(row);
			//$('#ul-categorias').html(ul);
		}
	});
}

function fnMostrarNuevasPromociones(categoria){
	$('#ul-categorias li').removeClass('active');
	$('#li'+categoria+'').addClass('active');
	$.ajax({
		url: 'process_php/fnMostrarNuevasPromociones.php',
		type: 'POST',
		data: {categoria: categoria},
		success: function(res){
			console.log(res);
			var js = JSON.parse(res);
			var datos = '';
			for (var i = 0; i < js.length; i++) {
				datos += '<div class="product"><div class="product-img"><img src="process_php/img/'+js[i].foto+'" alt=""><div class="product-label"><span class="sale">-'+js[i].descuento+'%</span><span class="new">NEW</span></div></div><div class="product-body"><p class="product-category">'+js[i].nombre+'</p><h3 class="product-name"><a href="#">'+js[i].nombre_p+'</a></h3><h4 class="product-price">L. '+js[i].total+' <del class="product-old-price">L. '+js[i].precio+'</del></h4><div class="product-rating"></div><div class="product-btns"><p class="product-category">Finaliza el '+js[i].fin+'</p></div></div>';
				//datos += '<div class="product"><div class="product-img"><img src="./img/product01.png" alt=""><div class="product-label"><span class="sale">-30%</span><span class="new">NEW</span></div></div><div class="product-body"><p class="product-category">Category</p><h3 class="product-name"><a href="#">product name goes here</a></h3><h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4><div class="product-rating"></div><div class="product-btns"><p class="product-category">Finaliza el 26 noviembre</p></div></div><div class="add-to-cart"><button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button></div></div>';
			}
			$('#div-nuevas-promociones').append(datos);
		}
	})
}





function fnVerDetalles(id_promocion){
	window.location = 'detalles_producto.php?promo='+id_promocion+'';
}