$(document).ready(function(){

    // Cachamos el evento change
    
    $(document).on("change", "#imagen", function () {
    
        //console.log(this.files);
        var files = this.files;
        var element;
        var supportedImages = ["image/jpeg", "image/png", "image/gif"];
        var seEncontraronElementoNoValidos = false;

        var interruptur=1;
        var imgCodified;

        for (var i = 0; i < files.length; i++) {
            element = files[i];
           
                if (supportedImages.indexOf(element.type) != -1) {
                        createPreview(element);
                    }else{
                        seEncontraronElementoNoValidos = true;
                        } 
        }

        if (seEncontraronElementoNoValidos) {
            alert("Se encontraron archivos no validos.");
        }
    
    });
    
    // -> Cachamos el evento change
});

