$(document).ready(function(){

    // Cachamos el evento change
    
    $(document).on("change", "#imagen", function () {
    
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
                var img = '<div class="col" style="padding: 0 1px;"><img src="'+imgCodified+'" class="rounded mx-auto d-block" align="center" style="height: 130px; object-fit: cover;" ></div>';
                tabla=img;
            }else{
                seEncontraronElementoNoValidos = true;
            }
            interruptur=0;
            }else{
                if (supportedImages.indexOf(element.type) != -1) {
                imgCodified = URL.createObjectURL(element);
                var img = '<div class="col" style="padding: 0 1px;"><img src="'+imgCodified+'" class="rounded mx-auto d-block" align="center" style="height: 130px; object-fit: cover;" ></div>';
                tabla+=img;
            }else{
                seEncontraronElementoNoValidos = true;
            }
            }
            
            
        }
        $("#divFoto").html(tabla);

        if (seEncontraronElementoNoValidos) {
            alert("Se encontraron archivos no validos.");
        }
    
    });
    
    // -> Cachamos el evento change

$(document).on("change", "#imagen-editar", function () {
    
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
                var img = '<div class="col" style="padding: 0 1px;"><img src="'+imgCodified+'" class="rounded mx-auto d-block" align="center" style="height: 130px; object-fit: cover;" ></div>';
                tabla=img;
            }else{
                seEncontraronElementoNoValidos = true;
            }
            interruptur=0;
            }else{
                if (supportedImages.indexOf(element.type) != -1) {
                imgCodified = URL.createObjectURL(element);
                var img = '<div class="col" style="padding: 0 1px;"><img src="'+imgCodified+'" class="rounded mx-auto d-block" align="center" style="height: 130px; object-fit: cover;" ></div>';
                tabla+=img;
            }else{
                seEncontraronElementoNoValidos = true;
            }
            }
            
            
        }
        $("#divFoto-editar").html(tabla);

        if (seEncontraronElementoNoValidos) {
            alert("Se encontraron archivos no validos.");
        }
    
    });

});

