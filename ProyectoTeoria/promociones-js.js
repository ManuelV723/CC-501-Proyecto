$(function(){
	mostrarPromociones();
$('#txtBuscar-modal').keyup(function(){
		buscarProductos();
	});
$('#txtBuscar').keyup(function(){
	mostrarPromociones();
});
$('#btnCancelar').click( function(){
	$('#contenido2-modal').attr('hidden','hidden');
	$('#contenido1-modal').removeAttr('hidden');
	fnLimpiar();
});

$('#txtDesPor').keyup(function(){
	var precio = $('#txtPrecio').val();
	var despor = $('#txtDesPor').val();
	var descuento = precio*(despor/100);
	var total = precio - descuento;
	$('#txtDescuento').val(descuento);
	$('#txtTotal').val(total);
	var inputs = ["#txtDesPor","#txtDescuento","#txtNombre","#txtTotal","#fecha-inicio","#fecha-fin"];
	for (var i = 0; i < inputs.length; i++) {
			$(''+inputs[i]+'').css('border-color','#ccc');
	}
});

});
	
function buscarProductos(){
	var parametro = $('#txtBuscar-modal').val();
	var filas = '';
	$.ajax({
		url: 'process_php/mostrar_productosComercio.php',
		type: 'POST',
		data: {parametro: parametro},
		beforeSend: function(){
			$('#tbody-modal').html('<div class="container"><h4>Buscando...</h4></div>');
		},
		success: function(res){
			if(res==0){
					$('#tbody-modal').html('<div class="container"><h4>No se encontraron coicidencias!</h4></div>');
				}else{
					var js = JSON.parse(res);
					for (var i = 0; i < js.length; i++) {
						if(js[i].estado=='Activo'){
							filas += '<tr><td>'+js[i].nombre_p+'</td><td>L. '+js[i].precio+'</td><td style="text-align: center;"><button class="btn btn-success btn-sm" onclick="fnSeleccionar('+js[i].id_producto+','+js[i].precio+')">Seleccionar <i class="fa fa-check"></i></button></td></tr>';
						}
					}
					$('#tbody-modal').html(filas);
				}
		},
		error: function(){
			$('#tbody-modal').html('<div class="container"><h4 style="color: red;">Ocurrió algo inesperado!</h4></div>');
		}
	})
}

function mostrarProductos(){
	var filas = '';
	$.ajax({
		url: 'process_php/mostrar_productosComercio.php',
		type: 'POST',
		beforeSend: function(){
			$('#tbody-modal').html('<div class="container"><h4>Cargando...</h4></div>');
		},
		success: function(res){
			if(res==0){
					$('#tbody-modal').html('<div class="container"><h4>No hay datos!</h4></div>');
				}else{
					var js = JSON.parse(res);
					for (var i = 0; i < js.length; i++) {
						if(js[i].estado=='Activo'){
							filas += '<tr><td>'+js[i].nombre_p+'</td><td>L. '+js[i].precio+'</td><td style="text-align: center;"><button class="btn btn-success btn-sm" onclick="fnSeleccionar('+js[i].id_producto+','+js[i].precio+')">Seleccionar <i class="fa fa-check"></i></button></td></tr>';
						}
					}
					$('#tbody-modal').html(filas);
				}
		},
		error: function(){
			$('#tbody-modal').html('<div class="container"><h4 style="color: red;">Ocurrió algo inesperado!</h4></div>');
		}
	})
}

function fnSeleccionar(id_producto,precio){
	$('#contenido1-modal').attr('hidden','hidden');
	$('#contenido2-modal').removeAttr('hidden');
	$('#btnAceptar').attr('onclick','fnNuevaPromocion('+id_producto+')');
	$('#txtPrecio').val(precio);
	$('#txtTotal').val(precio);
}

function fnLimpiar(){
	var inputs = ["#txtDesPor","#txtDescuento","#txtNombre","#txtTotal","#fecha-inicio","#fecha-fin"];
	for (var i = 0; i < inputs.length; i++) {
			$(''+inputs[i]+'').val('');
	}
}

function fnValidarInputs(){
	var inputs = ["#txtDesPor","#txtDescuento","#txtNombre","#txtTotal","#fecha-inicio","#fecha-fin"];
	var contador = 0;
	for (var i = 0; i < inputs.length; i++) {
		if($(''+inputs[i]+'').val().length==0 || $(''+inputs[i]+'').val()==0 || $(''+inputs[i]+'').val()==""){
			$(''+inputs[i]+'').css('border-color','red');
			contador++;
		}
	}
	if($('#fecha-inicio').val() >= $('#fecha-fin').val()){
		toastr.info('La fecha final debe ser mayor a la inicial!','Info',{
				"positionClass": "toast-bottom-center",
				"timeOut": "3000",
				"closeButton": true
			});
		contador++;
	}
	return contador;
}

function fnNuevaPromocion(id_producto){
	var contador = fnValidarInputs();
	if(contador==0){
		$.ajax({
			url: 'process_php/fnNuevaPromocion.php',
			type: 'POST',
			data: {id_producto: id_producto ,nombre: $('#txtNombre').val(), descuento: $('#txtDesPor').val(), inicio: $('#fecha-inicio').val(), final: $('#fecha-fin').val()},
			beforeSend: function(){
				$('#btnAceptar').html('Cargando...');
				$('#btnAceptar').attr('disabled','disabled');
				$('#btnCancelar').attr('disabled','disabled');
			},
			success: function(res){
				if(res==1){
					toastr.success('Promoción creada con éxito!','Listo',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
					$('#btnAceptar').html('Agregar');
					$('#btnAceptar').removeAttr('disabled');
					$('#btnCancelar').removeAttr('disabled');
					$('#contenido1-modal').removeAttr('hidden');
					$('#contenido2-modal').attr('hidden','hidden');
					fnLimpiar();
					mostrarPromociones();
				}else{
					toastr.error('Error al crear la promoción!','ERROR',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
					$('#btnAceptar').html('Agregar');
					$('#btnAceptar').removeAttr('disabled');
					$('#btnCancelar').removeAttr('disabled');
				}
			},
			error: function(){
				toastr.error('Error al conectar con el SERVER!','FATAL_ERROR',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});
				$('#btnAceptar').html('Agregar');
				$('#btnAceptar').removeAttr('disabled');
				$('#btnCancelar').removeAttr('disabled');
			}
		});
	}
}

function mostrarPromociones(){
	var parametro = $('#txtBuscar').val();
	if(parametro.length==0){
		parametro = "0";
	}
	$.ajax({
		url: 'process_php/mostrarPromociones.php',
		type: 'POST',
		data: {parametro: parametro},
		beforeSend: function(){
			$('#tbody').html('<div class="container"><h4>Cargando...</h4></div>');
		},
		success: function(res){
			if(res==0){
				tbody = '<div class="container"><h4>No Hay Resultados...</h4></div>';
			}else{
				var js = JSON.parse(res);
				var tbody = '';
				for (var i = 0; i < js.length; i++) {
					tbody += '<tr><td class="imagen"><img src="process_php/img/'+js[i].foto+'" height="55" alt=""></td><td>'+js[i].nombre_p+'</td><td>L. '+js[i].precio+'</td><td class="imagen">'+js[i].descuento+' %</td><td class="imagen"><span class="label label-success">'+js[i].Inicio+'</span></td><td class="imagen"><span class="label label-danger">'+js[i].Fin+'</span></td></tr>';
				}
			}
			$('#tbody').html(tbody);
		},
		error: function(){
			$('#tbody').html('<div class="container"><h4 style="color: red;">Ocurrió algo inesperado!</h4></div>');
		}
	});
}

