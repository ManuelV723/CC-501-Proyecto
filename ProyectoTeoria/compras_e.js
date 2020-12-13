$(function(){
	mostrarFacturasE();

$('#txtBuscar').keyup(function(){
	mostrarPromociones();
	});

});
	


function mostrarFacturasE(){
	var parametro = $('#txtBuscar').val();
	if(parametro.length==0){
		parametro = "0";
	}
	$.ajax({
		url: 'process_php/mostrarFacturasE.php',
		type: 'POST',
		data: {parametro: parametro},
		beforeSend: function(){
			$('#tbody').html('<div class="container"><h4>Cargando...</h4></div>');
		},
		success: function(res){
			if(res==0){
				tbody = '<td colspan="6"><div class="alert alert-warning" role="alert">No hay datos!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></td>';
			}else{
				var js = JSON.parse(res);
				var tbody = '';
				for (var i = 0; i < js.length; i++) {
					tbody += '<tr><td class="imagen">'+js[i].id_factura+'</td><td>'+js[i].nombre+' '+js[i].apellido+'</td><td>'+js[i].correo+'</td><td style="text-align: right;">L. '+js[i].total+'</td><td class="imagen"><span class="label label-success">'+js[i].fecha+'</span></td><td class="imagen"><div class="btn-group btn-sm" role="group" aria-label="..."><button type="button" class="btn btn-info btn-sm" onclick="fnOcultarDiv('+js[i].id_factura+')"><i class="fa fa-eye"></i></button><button type="button" class="btn btn-success btn-sm" href="#modal" data-toggle="modal" onclick="fnModal('+js[i].id_factura+')"><i class="fa fa-check"></i></button></div></td></tr>';
				}
			}
			$('#tbody').html(tbody);
		},
		error: function(){
			$('#tbody').html('<div class="container"><h4 style="color: red;">Ocurrió algo inesperado!</h4></div>');
		}
	});
}

function fnOcultarDiv(id_factura){
	$('#div-detalles').removeAttr('hidden');
	$('#div-facturas').attr('hidden','hidden');
	$('#btnRegresar').css('visibility','');
	mostrarDetallesF(id_factura);
}

function fnModal(id_factura){
	$('#btnAceptar').attr('onclick','fnFinalizar('+id_factura+')');
}

function fnFinalizar(id_factura){
	$.ajax({
		url: 'process_php/fnFinalizarFactura.php',
		type: 'POST',
		data: {id_factura: id_factura},
		success: function(res){
			$('#modal').modal('hide');
			mostrarFacturasE();
		}
	})
}

function mostrarDetallesF(id_factura){
	var parametro = $('#txtBuscar').val();
	if(parametro.length==0){
		parametro = "0";
	}
	$.ajax({
		url: 'process_php/mostrarDetallesF.php',
		type: 'POST',
		data: {id_factura: id_factura},
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
					tbody += '<tr><td class="imagen"><img src="process_php/img/'+js[i].foto+'" height="55" alt=""></td><td>'+js[i].nombre_p+'</td><td class="imagen">'+js[i].cantidad+'</td><td style="text-align: right;">L. '+js[i].precio+'</td><td style="text-align: right;">'+js[i].descuento+'</td><td class="imagen">'+js[i].por_descuento+'%</td><td class="imagen">'+js[i].total+'</td></tr>';
				}
			}
			$('#tbody-detalles').html(tbody);
		},
		error: function(){
			$('#tbody').html('<div class="container"><h4 style="color: red;">Ocurrió algo inesperado!</h4></div>');
		}
	});
}

function fnRegresar(){
	$('#btnRegresar').css('visibility','hidden');
	$('#div-facturas').removeAttr('hidden');
	$('#div-detalles').attr('hidden','hidden');
	mostrarFacturasE();
}