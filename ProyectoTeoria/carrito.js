$(function(){
	llenarCarrito();
	$('#btnRegresar').click(function(){
		$('#div-tabla').removeAttr('hidden');
		$('#div-datos').attr('hidden','hidden');
		$('#btnContinuar').css('visibility','');
	});
});

function fnEditarCantidad(id_carrito) {
	$('#label-cant'+id_carrito+'').attr('hidden','hidden');
	$('#input-cant'+id_carrito+'').removeAttr('hidden');
}

function fnFinEditarCantidad(id_carrito){
	/*$.ajax({
		url: '',
		type: 'POST',
		data: {id_carrito: id_carrito,cantidad: $('#input-cant'+id_carrito+'').val()},
		success: function(res){

		}
	})*/
	$('#input-cant'+id_carrito+'').attr('hidden','hidden');
	$('#label-cant'+id_carrito+'').removeAttr('hidden');
}

function llenarCarrito(){
	$.ajax({
		url: 'process_php/llenarCarrito.php',
		type: 'POST',
		beforeSend: function(){

		},
		success: function(res){
			if(res==2){
				$('#tbody').html('<tr><td colspan="7"><div class="alert alert-warning" role="alert">No hay datos!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></td></tr>');
			}else{
				console.log(res);
				var js = JSON.parse(res);
				var tbody = '';
				var descuentos = 0;
				var subtotal = 0;
				var total = 0;
				var ids = [];
				for (var i = 0; i < js.length; i++) {
					tbody+='<tr><td class="imagen"><img src="process_php/img/'+js[i].foto+'" height="55" alt=""></td><td>'+js[i].nombre_p+'</td><td><span id="label-cant'+js[i].id_carrito+'" onclick="fnEditarCantidad('+js[i].id_carrito+');">'+js[i].cantidad+'</span><div data-toggle="tooltip" data-placement="bottom" title="Presiona Enter Para Guardar Los Cambios"><input type="number" id="input-cant'+js[i].id_carrito+'" value="'+js[i].cantidad+'" hidden class="input" style="width: 80px; text-align: center;" onchange="fnFinEditarCantidad('+js[i].id_carrito+')"></div></td><td>L. '+js[i].precio+'</td><td>'+js[i].por_descuento+'%</td><td>L. '+js[i].subtotal+'</td><td>L. '+js[i].total+'</td><td class="imagen"><div class="btn-group" role="group" aria-label="..."><button type="button" class="btn btn-danger btn-sm" onclick="fnEliminar('+js[i].id_carrito+')"><i class="fa fa-trash"></i></button><!--<button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>--></div></td></tr>';
					descuentos+=Number(js[i].descuento);
					subtotal+=Number(js[i].subtotal);
					ids.push(js[i].id_carrito);
				}
				total=subtotal-descuentos;
				$('#td-subtotal').html('L. '+subtotal.toFixed(2));
				$('#td-descuentos').html('L. '+descuentos.toFixed(2));
				$('#td-total').html('L. '+total.toFixed(2));
				$('#tbody').html(tbody);
				$('#btnContinuar').attr('onclick','continuar(['+ids+'],'+total.toFixed(2)+')');
			}
		},
		error: function(res){

		}
	})
}

function fnEliminar(id_carrito){
	$('#modal-eliminar').modal('show');
	$('#btnEliminar').attr('onclick','fnEliminarAjax('+id_carrito+')');
}

function fnEliminarAjax(id_carrito){
	$.ajax({
		url: 'process_php/eliminar_carrito.php',
		type: 'POST',
		data: {id_carrito: id_carrito},
		beforeSend: function(){

		},
		success: function(res){
			if(res==1){
				$('#modal-eliminar').modal('hide');
				llenarCarrito();
			}
		}
	})
}

function continuar(ids,total){
	$('#div-tabla').attr('hidden','hidden');
	$('#div-datos').removeAttr('hidden');
	$('#btnContinuar').css('visibility','hidden');
	$('#btnFinalizar').attr('onclick','fnPagar(['+ids+'],'+total+')')
}

function fnValidarCampos(){
	var contador = 0;
	var campos = ["#txtTarjeta","#txtCodigo","#txtNombre","#txtApellido","#txtCorreo","#txtTelefono","#txtDireccion"];
	for (var i = 0; i < campos.length; i++) {
		if($(''+campos[i]+'').val().length==0 || $(''+campos[i]+'').val()==''){
				$(''+campos[i]+'').css('border-color','red');
				contador++;
		}
	}
	if(!($('input:radio[name=radio]').is(':checked'))){
		$('#div-radio').css({'border-style':'solid','border-width':'thin','border-color':'red'});
		contador++;
	}
	return contador;
}

function fnPagar(ids,total){
	var validar = fnValidarCampos();
	if(validar==0){
		$.ajax({
			url: 'process_php/fnPagar.php',
			type: 'POST',
			data: {ids: ids, total:total},
			beforeSend: function(){
				$('#btnFinalizar').attr('disabled','disabled');
				$('#btnFinalizar').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span>');
			},
			success: function(res){
				console.log(res);
				if(res==1){
					toastr.success('Gracias Por Tu Compra!','Finalizado',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
					$('#div-tabla').removeAttr('hidden');
					$('#div-datos').attr('hidden','hidden');
					llenarCarrito();
					$('#btnContinuar').attr('disabled','disabled');
				}
			},
			error: function(ex){

			}
		})
	}
}