$(function(){
	mostrarInfo();

	$('#txtNombre').keyup(function(){
		$('#div-btn').removeAttr('hidden');
		$('#txtNombre').css('border-color','#ccc');
	});
	$('#txtApellido').keyup(function(){
		$('#div-btn').removeAttr('hidden');
		$('#txtApellido').css('border-color','#ccc');
	});
	$('#txtCorreo').keyup(function(){
		$('#div-btn').removeAttr('hidden');
		$('#txtCorreo').css('border-color','#ccc');
	});
	$('#txtTelefono').keyup(function(){
		$('#div-btn').removeAttr('hidden');
		$('#txtTelefono').css('border-color','#ccc');
	});
	$('#txtPass').keyup(function(){
		$('#div-btn').removeAttr('hidden');
	});
	$('#btnCancelar').click(function(){
		$('#div-btn').attr('hidden','hidden');
		mostrarInfo();
		$('#txtPass').val("");
	});
	$('#btnEditar').click(function(){
		fnEditarInfoCliente();
	});
})

function mostrarInfo() {
	$.ajax({
		url: 'process_php/mostrarInfo.php',
		type: 'POST',
		success: function(res){
			var js = JSON.parse(res);
			for (var i = 0; i < js.length; i++) {
				$('#txtNombre').val(js[i].nombre);
				$('#txtApellido').val(js[i].apellido);
				$('#txtCorreo').val(js[i].correo);
				$('#txtTelefono').val(js[i].celular);
				$('#lbNombre').html(js[i].nombre+" "+js[i].apellido);
				$('#lbCorreo').html(js[i].correo);
				$('#lbTelefono').html(js[i].celular);
			}
		}
	})
}

function validarInputs(){
	var inputs = ["#txtNombre","#txtApellido","#txtCorreo","#txtTelefono"];
	var contador = 0;
	for (var i = 0; i < inputs.length; i++) {
		if($(""+inputs[i]+"").val().length==0){
			$(""+inputs[i]+"").css('border-color','red');
			contador++;
		}
	}
	return contador;
}

function fnEditarInfoCliente(){
	if(validarInputs()==0){
		if ($('#txtPass').val().length>0) {
			var pass = $('#txtPass').val();
		}else{
			var pass = false;
		}

		$.ajax({
			url: 'process_php/fnEditarInfoCliente.php',
			type: 'POST',
			data: {nombre: $('#txtNombre').val(),apellido: $('#txtApellido').val(),correo: $('#txtCorreo').val(),celular: $('#txtTelefono').val(),pass: pass},
			success: function(res){
				console.log(res);
				if(res==1){
					$('#div-btn').attr('hidden','hidden');
					mostrarInfo();
				}else{
					mostrarInfo();
				}
			}
		})

	}
}