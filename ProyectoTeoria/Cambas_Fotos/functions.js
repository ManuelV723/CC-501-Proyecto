//Genera las previsualizaciones
function createPreview(file) {
    var imgCodified = URL.createObjectURL(file);
    var img = '<img src="'+imgCodified+'" class="rounded mx-auto d-block" align="center" style="height: 130px;">';
    $("#divFoto").html(img);
}