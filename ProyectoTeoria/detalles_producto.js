function fnVerDetalles(id_promocion){
	window.location = 'detalles_producto.php?promo='+id_promocion+'';
}

function accionesAcceso(accion){
	if(accion==1){ //registrar
		window.location = 'index.php?r=n';
	}else{
		window.location = 'index.php?s=n';
	}
}

function fnAgregarAlCarrito(id_producto){
	if(id_producto==0){
		window.location = 'index.php?s=n';
	}
	var cantidad = $('#txtCantidad').val();
	var total = $('#txtTotal').val();

	if(cantidad<=0 || cantidad=="" || total<=0 || total==""){
		$('#txtCantidad').css('border-color','red');
	}else{
		$.ajax({
			url: 'process_php/fnAgregarAlCarrito.php',
			type: 'POST',
			data: {id_producto: id_producto, cantidad: cantidad, total: total},
			beforeSend: function(){
				$('#btnAgregar').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span>');
				$('#btnAgregar').attr('disabled','disabled');
				//$('#btnCancelar').attr('disabled','disabled');
			},
			success: function(res){
				if(res==1){
					toastr.success('Agregado Al Carrito!','Agregado',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
					$('#btnAgregar').html('<i class="fa fa-shopping-cart"></i> Agregar');
					$('#btnAgregar').removeAttr('disabled');
					//$('#btnCancelar').removeAttr('disabled');
				}else{
					console.log(res);
					toastr.error('Ocurrió Algo Inesperado!','Error Al Agregar',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
					$('#btnAgregar').html('<i class="fa fa-shopping-cart"></i> Agregar');
					$('#btnAgregar').removeAttr('disabled');
					//$('#btnCancelar').removeAttr('disabled');
				}
			},
			error: function(ex){
				console.log(ex);
				toastr.error('Ocurrió Algo Inesperado!','FATAL_ERROR',{
					"positionClass": "toast-bottom-center",
					"timeOut": "3000",
					"closeButton": true
				});
				$('#btnAgregar').html('<i class="fa fa-shopping-cart"></i> Agregar');
				$('#btnAgregar').removeAttr('disabled');
				//$('#btnCancelar').removeAttr('disabled');
			}
		})
	}
}