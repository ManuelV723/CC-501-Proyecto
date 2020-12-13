$('#btnEditarLogo').click(function() {
	$('#logo').click();
});

$('#logo').change(function(){
	$('#btnGuardarLogo').css('visibility','');
	console.log(this.files);
        var files = this.files;
        var element;
        var supportedImages = ["image/jpeg", "image/png", "image/gif"];
        var seEncontraronElementoNoValidos = false;

        var interruptur=1;
        var imgCodified;

        for (var i = 0; i < files.length; i++) {
            element = files[i];
            if(interruptur==1){
                var tabla;
                if (supportedImages.indexOf(element.type) != -1) {
                imgCodified = URL.createObjectURL(element);
                //var img = '<div class="col" style="padding: 0 1px;"><img src="'+imgCodified+'" class="rounded mx-auto d-block" align="center" style="height: 130px; object-fit: cover;" ></div>';
                //tabla=img;
            }else{
                seEncontraronElementoNoValidos = true;
            }
            interruptur=0;
            }else{
                if (supportedImages.indexOf(element.type) != -1) {
                imgCodified = URL.createObjectURL(element);
                //var img = '<div class="col" style="padding: 0 1px;"><img src="'+imgCodified+'" class="rounded mx-auto d-block" align="center" style="height: 130px; object-fit: cover;" ></div>';
                //tabla+=img;
            }else{
                seEncontraronElementoNoValidos = true;
            }
            }
            
            
        }
        $("#imgLogo").attr('src',imgCodified);

        if (seEncontraronElementoNoValidos) {
            alert("Se encontraron archivos no validos.");
        }
    
});

$('#CambiarPass').click(function(){
	if($('#CambiarPass').is(':checked')){
		$('#divPass').css('visibility','');
	}else{
		$('#divPass').css('visibility','hidden');
		$('#txtPass').val('');
	}
});

function cambiarLogo(){
	console.log("ya");
	var frmData = new FormData;
	frmData.append("logo",$("#logo")[0].files[0]);
	frmData.append("x","x");
	$.ajax({
		url: 'process_php/cambiarLogo.php',
		type: 'POST',
		data: frmData,
		processData: false,
        contentType: false,
        cache: false,
        success: function(res){
        	console.log(res);
        	if(res==1){
        		$('#btnGuardarLogo').css('visibility','hidden');
        	}
        }
    });
}

function datosEmpresa(){
	$.ajax({
		url: 'process_php/datosEmpresa.php',
		type: 'POST',
		success: function(res){
			var js = JSON.parse(res);
			for (var i = 0; i < js.length; i++) {
				$('#txtNombre').val(js[i].nombre);
				$('#txtEslogan').val(js[i].eslogan);
				$('#txtCorreo').val(js[i].correo);
				$('#txtTelefono').val(js[i].telefono);
				$('#txtDireccion').val(js[i].direccion);
			}
		}
	})
}

function modificarDatos_empresa(){
	var campos = ['txtNombre','txtEslogan','txtCorreo','txtTelefono','txtDireccion'];
	var contador = 0;
	for (var i = 0; i < campos.length; i++) {
		if($('#'+campos[i]+'').val().length==0){
			$('#'+campos[i]+'').css('border-color','red');
			contador++;
		}
	}
	if(contador==0){
		if($('#CambiarPass').is(':checked')){
			var pass=$('#txtPass').val();
		}else{
			var pass=0;
		}

		$.ajax({
			url: 'process_php/modificarDatos_empresa.php',
			type: 'POST',
			data: {nombre: $('#txtNombre').val(), eslogan: $('#txtEslogan').val(), correo: $('#txtCorreo').val(), telefono: $('#txtTelefono').val(), direccion: $('#txtDireccion').val(), pass: pass},
			beforeSend: function(){
				for (var i = 0; i < campos.length; i++) {
					$('#'+campos[i]).attr('disabled','disabled');
				}
				$('#btnAceptar').html('Cargando...');
				$('#btnAceptar').attr('disabled','disabled');
				$('#btnCancelar').attr('disabled','disabled');
			},
			success: function(res){
				console.log(res);
				if(res==1){
					for (var i = 0; i < campos.length; i++) {
						$('#'+campos[i]).removeAttr('disabled');
					}
					$('#btnAceptar').html('Aceptar');
					$('#btnAceptar').removeAttr('disabled');
					$('#btnCancelar').removeAttr('disabled');
					window.location = 'perfil_empresa.php';
				}else{
					for (var i = 0; i < campos.length; i++) {
						$('#'+campos[i]).removeAttr('disabled');
					}
					$('#btnAceptar').html('Aceptar');
					$('#btnAceptar').removeAttr('disabled');
					$('#btnCancelar').removeAttr('disabled');
					toastr.error('Ocurrió Algo Inesperado!','Error',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
				}
			},
			error: function(){
				for (var i = 0; i < campos.length; i++) {
						$('#'+campos[i]+'').removeAttr('disabled');
					}
					$('#btnAceptar').html('Aceptar');
					$('#btnAceptar').removeAttr('disabled');
					$('#btnCancelar').removeAttr('disabled');
					toastr.error('Ocurrió Algo Inesperado!','Error',{
						"positionClass": "toast-bottom-center",
						"timeOut": "3000",
						"closeButton": true
					});
			}
		})

	}
}