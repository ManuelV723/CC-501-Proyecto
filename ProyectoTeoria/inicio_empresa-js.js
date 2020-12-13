$(function(){
	$('#imagen-1').click( function(){
		$('#imagen').click();
	});
	$('#imagen-1-editar').click( function(){
		$('#imagen-editar').click();
	});
	mostrarProductos();

	$('#txtBuscar').keyup(function(){
		buscarProductos();
	});

});

function fnAgregarProducto(){
	var contador=0;
	var campos = ["#txtProducto","#txtPrecio","#txtDescripcion"];
	for (var i = 0; i < campos.length; i++) {
		if($(""+campos[i]+"").val().length==0){
			$(""+campos[i]+"").css('border-color','red');
			contador++;
		}
	}

	if(contador==0){
		var frmData = new FormData;
    	var num_files = $("#imagen")[0].files.length;
    	if(num_files==0 || $("#divFoto").html()=="El numero máximo de imagenes es 4"){
    		toastr.info('Selecciona al menos una imagen!','Info',{
				"positionClass": "toast-bottom-center",
				"timeOut": "3000",
				"closeButton": true
			});
    	}else{
    		for (var i = 0; i < 4; i++) {
        		frmData.append("foto"+i,$("#imagen")[0].files[i]);
    		}
    		frmData.append("producto",$('#txtProducto').val());
    		frmData.append("precio",$('#txtPrecio').val());
    		frmData.append("descripcion",$('#txtDescripcion').val());
    		frmData.append("numero",num_files);
			$.ajax({
				url: 'process_php/agregar_producto.php',
				type: 'POST',
				data: frmData,
				processData: false,
        		contentType: false,
        		cache: false,
				beforeSend: function(){
					beforeAdd();
				},
				success: function(res){
					if(res==1){
						toastr.success('El producto ha sido agregado!','Agregado',{
							"positionClass": "toast-bottom-center",
							"timeOut": "3000",
							"closeButton": true
						});
						responseAdd(true);
					}else{
						if(res==0){
							toastr.error('Error al agregar producto!','Error',{
								"positionClass": "toast-bottom-center",
								"timeOut": "3000",
								"closeButton": true
							});
							responseAdd(false);
						}else{
							toastr.error('Error al guardar una de las imagenes!','Producto Agregado',{
								"positionClass": "toast-bottom-center",
								"timeOut": "3000",
								"closeButton": true
							});
							responseAdd(false);
						}
					}
				},
				error: function(){
					toastr.error('Error al conectar con el servidor!','FATAL ERROR',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
					responseAdd(false);
				}
			});
    	}
	}
}

function beforeAdd(){
	$('#btnAceptar').attr('disabled','disabled');
	$('#btnCancelar').attr('disabled','disabled');
	$('#btnAceptar').html("Cargando...");
}

function responseAdd(x){
	$('#btnAceptar').removeAttr('disabled');
	$('#btnCancelar').removeAttr('disabled');
	$('#btnAceptar').html("Aceptar");
	if(x==true){
		$('#txtProducto').val("");
		$('#txtDescripcion').val("");
		$('#txtPrecio').val("");
		$('#divFoto').html("El numero máximo de imagenes es 4");
		mostrarProductos();
	}
}

function mostrarProductos(){
	var filas = '';
	$.ajax({
		url: 'process_php/mostrar_productosComercio.php',
		type: 'POST',
		beforeSend: function(){
			$('#tbody').html('<div class="container"><h4>Cargando...</h4></div>');
		},
		success: function(res){
			if(res==0){
					$('#tbody').html('<div class="container"><h4>No hay datos!</h4></div>');
				}else{
					var js = JSON.parse(res);
					for (var i = 0; i < js.length; i++) {
						if(js[i].estado=='Activo'){
							filas += '<tr><td class="imagen"><img src="process_php/img/'+js[i].foto+'" height="55" alt=""></td><td>'+js[i].nombre_p+'<br><span id="estado" style="border-top-color: #28a745; color: #28a745;">Activo</span></td><td>'+js[i].descripcion+'</td><td>L. '+js[i].precio+'</td><td class="imagen"><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-danger btn-sm" onclick='+"cambiarEstadoP('eliminar',"+js[i].id_producto+")"+'><i class="fa fa-trash"></i></button><button type="button" class="btn btn-warning btn-sm" onclick='+"detallesProducto("+js[i].id_producto+")"+'><i class="fa fa-pencil"></i></button><button type="button" class="btn btn-info btn-sm" onclick='+"cambiarEstadoP('desactivar',"+js[i].id_producto+")"+'><i class="fa fa-minus-circle"></i></button></div></td></tr>';
						}else{
							filas += '<tr><td class="imagen"><img src="process_php/img/'+js[i].foto+'" height="55" alt=""></td><td>'+js[i].nombre_p+'<br><span id="estado" style="border-top-color: #d9534f; color: #d9534f;">Inactivo</span></td><td>'+js[i].descripcion+'</td><td>L. '+js[i].precio+'</td><td class="imagen"><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-danger btn-sm" onclick='+"cambiarEstadoP('eliminar',"+js[i].id_producto+")"+'><i class="fa fa-trash"></i><button type="button" class="btn btn-warning btn-sm" onclick='+"detallesProducto("+js[i].id_producto+")"+'><i class="fa fa-pencil"></i></button></button><button type="button" class="btn btn-success btn-sm" onclick='+"cambiarEstadoP('activar',"+js[i].id_producto+")"+'><i class="fa fa-check"></i></button></div></td></tr>';
						}
					}
					$('#tbody').html(filas);
				}
		},
		error: function(){
			$('#tbody').html('<div class="container"><h4 style="color: red;">Ocurrió algo inesperado!</h4></div>');
		}
	})
}

function buscarProductos(){
	var parametro = $('#txtBuscar').val();
	var filas = '';
	$.ajax({
		url: 'process_php/mostrar_productosComercio.php',
		type: 'POST',
		data: {parametro: parametro},
		beforeSend: function(){
			$('#tbody').html('<div class="container"><h4>Buscando...</h4></div>');
		},
		success: function(res){
			if(res==0){
					$('#tbody').html('<div class="container"><h4>No se encontraron coicidencias!</h4></div>');
				}else{
					var js = JSON.parse(res);
					for (var i = 0; i < js.length; i++) {
						if(js[i].estado=='Activo'){
							filas += '<tr><td class="imagen"><img src="process_php/img/'+js[i].foto+'" height="55" alt=""></td><td>'+js[i].nombre_p+'<br><span id="estado" style="border-top-color: #28a745; color: #28a745;">Activo</span></td><td>'+js[i].descripcion+'</td><td>L. '+js[i].precio+'</td><td class="imagen"><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-danger btn-sm" onclick='+"cambiarEstadoP('eliminar',"+js[i].id_producto+")"+'><i class="fa fa-trash"></i></button><button type="button" class="btn btn-info btn-sm" onclick='+"cambiarEstadoP('desactivar',"+js[i].id_producto+")"+'><i class="fa fa-minus-circle"></i></button></div></td></tr>';
						}else{
							filas += '<tr><td class="imagen"><img src="process_php/img/'+js[i].foto+'" height="55" alt=""></td><td>'+js[i].nombre_p+'<br><span id="estado" style="border-top-color: #d9534f; color: #d9534f;">Inactivo</span></td><td>'+js[i].descripcion+'</td><td>L. '+js[i].precio+'</td><td class="imagen"><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-danger btn-sm" onclick='+"cambiarEstadoP('eliminar',"+js[i].id_producto+")"+'><i class="fa fa-trash"></i></button><button type="button" class="btn btn-success btn-sm" onclick='+"cambiarEstadoP('activar',"+js[i].id_producto+")"+'><i class="fa fa-check"></i></button></div></td></tr>';
						}
					}
					$('#tbody').html(filas);
				}
		},
		error: function(){
			$('#tbody').html('<div class="container"><h4 style="color: red;">Ocurrió algo inesperado!</h4></div>');
		}
	})
}

function cambiarEstadoP(opcion,id_producto){
	if(opcion=='activar'){
		$('#titulo-modal').html('Desea Habilitar Este Producto?');
		$('#modalActivar').modal('show');
	}
	if (opcion=='desactivar'){
		$('#titulo-modal').html('Desea Inhabilitar Este Producto?');
		$('#modalActivar').modal('show');
	}
	if(opcion=='eliminar'){
		$('#titulo-modal').html('Desea Eliminar Este Producto?');
		$('#modalActivar').modal('show');
	}
	$('#btnAceptar-confirmacion').attr('onclick','ajaxCambiar("'+opcion+'",'+id_producto+')');
}

function ajaxCambiar(opcion,id_producto){
	$.ajax({
		url: 'process_php/cambiarEstadoP.php',
		type: 'POST',
		data: {accion: opcion, id_producto: id_producto},
		beforeSend: function(){
			$('#btnAceptar-confirmacion').html('Cargando...');
			$('#btnAceptar-confirmacion').attr('disabled','disabled');
			$('#btnCancelar-confirmacion').attr('disabled','disabled');
		},
		success: function(res){
			if(res!=0){
				toastr.success('El producto ha sido '+res+'!',''+res+'',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});

				$('#modalActivar').modal('hide');
				mostrarProductos();
			}else{
				toastr.error('Ocurrió algo inesperado!','FATAL_ERROR',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});
			}
			$('#btnAceptar-confirmacion').html('Aceptar');
			$('#btnAceptar-confirmacion').removeAttr('disabled');
			$('#btnCancelar-confirmacion').removeAttr('disabled');
		},
		error: function(){
			toastr.error('Ocurrió algo inesperado al intentar conectar al servidor!','ERROR_SERVER_CONNECTION',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});
			$('#btnAceptar-confirmacion').html('Aceptar');
			$('#btnAceptar-confirmacion').removeAttr('disabled');
			$('#btnCancelar-confirmacion').removeAttr('disabled');
		}
	})
}

function detallesProducto(id_producto){
	mostrarFotos(id_producto);
	$('#modalProducto-editar').modal('show');
	$('#btnAceptar-editar').attr('onclick','modificarProducto('+id_producto+')');
	$.ajax({
		url: 'process_php/detallesProducto.php',
		type: 'POST',
		data: {id_producto: id_producto},
		beforeSend: function(){
			$('#alerta-editar').removeAttr('hidden');
			$('#alerta-editar').html('Cargando...');
			$('#form-editar').attr('hidden','hidden');
		},
		success: function(res){
			var js = JSON.parse(res);
			for (var i = 0; i < js.length; i++) {
				$('#txtProducto-editar').val(js[i].nombre_p);
				$('#txtPrecio-editar').val(js[i].precio);
				$('#txtDescripcion-editar').val(js[i].descripcion);
			}
			$('#form-editar').removeAttr('hidden');
			$('#alerta-editar').attr('hidden','hidden');
		},
		error: function(){
			$('#alerta-editar').html('Ocurrió algo inesperado !!!');
		}
	});
}

function modificarProducto(id_producto){
	var contador=0;
	var campos = ["#txtProducto-editar","#txtPrecio-editar","#txtDescripcion-editar"];
	for (var i = 0; i < campos.length; i++) {
		if($(""+campos[i]+"").val().length==0){
			$(""+campos[i]+"").css('border-color','red');
			contador++;
		}
	}
if(contador==0){
	for (var i = 0; i < campos.length; i++) {
			$(""+campos[i]+"").css('border-color','#ccc');
	}
	$.ajax({
		url: 'process_php/modificarProducto.php',
		type: 'POST',
		data: {id_producto: id_producto, producto: $('#txtProducto-editar').val(), precio: $('#txtPrecio-editar').val(), descripcion: $('#txtDescripcion-editar').val()},
		beforeSend: function(){

		},
		success: function(res){
			if(res==1){
				$('#modalProducto-editar').modal('hide');
				toastr.success('Cambios guardados!','Listo',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});
				mostrarProductos();
			}else{
				toastr.error('Ocurrió algo inesperado! '+res+'','FATAL_ERROR',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});
			}
		},
		error: function(){
			toastr.error('Ocurrió algo inesperado!','FATAL_ERROR',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});
		}
	})
 }
}

function mostrarFotos(id_producto){
	$.ajax({
		url: 'process_php/mostrarFotos.php',
		type: 'POST',
		data: {id_producto: id_producto},
		success: function(res){
			var js = JSON.parse(res);
			var dat='';
			for (var i = 0; i < js.length; i++) {
				dat += '<div class="col" style="padding: 0 1px;"><i class="fa fa-pencil" style="position: absolute; cursor: pointer;"></i><img src="process_php/img/'+js[i].foto+'" class="rounded mx-auto d-block" align="center" style="height: 130px; object-fit: cover; margin-right: 10px;" ></div>';
			}
			$('#divFoto-editar').html(dat);
		}
	});
}