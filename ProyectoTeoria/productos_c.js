$(function(){
	$('#select-cat').change( function(){
		var categoria = $('#select-cat').val();
		fnMostrarProductos(categoria);
	})
	fnMostrarProductos(0);
});
function fnMostrarProductos(categoria){
	$('#ul-categorias li').removeClass('active');
	$('#li'+categoria+'').addClass('active');
	$.ajax({
		url: 'process_php/fnMostrarProductos.php',
		type: 'POST',
		data: {categoria: categoria},
		success: function(res){
			console.log(res);
			if(res==0){
				$('#div-nuevas-promociones').html('<div class="alert alert-warning" role="alert">No hay datos!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			}else{
				var js = JSON.parse(res);
				var datos = '';
				for (var i = 0; i < js.length; i++) {
					datos += '<div class="col-md-3 col-xs-6"><div class="product"><div class="product-img" style="height: 170px;"><img src="process_php/img/'+js[i].foto+'" alt=""><div class="product-label"></div></div><div class="product-body"><p class="product-category">'+js[i].nombre+'</p><h3 class="product-name"><a href="#">'+js[i].nombre_p+'</a></h3><h4 class="product-price">L. '+js[i].precio+' </h4><div class="product-rating"></div><div class="product-btns"><button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">añadir favorito</span></button><button class="quick-view" onclick='+'fnVerDetalles("'+btoa(js[i].id_producto)+'")'+'><i class="fa fa-eye"></i><span class="tooltipp">Detalles</span></button><p class="product-category">'+js[i].categoria+'</p></div></div></div></div>';
					//datos += '<div class="product"><div class="product-img"><img src="./img/product01.png" alt=""><div class="product-label"><span class="sale">-30%</span><span class="new">NEW</span></div></div><div class="product-body"><p class="product-category">Category</p><h3 class="product-name"><a href="#">product name goes here</a></h3><h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4><div class="product-rating"></div><div class="product-btns"><p class="product-category">Finaliza el 26 noviembre</p></div></div><div class="add-to-cart"><button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button></div></div>';
				}
				$('#div-nuevas-promociones').html(datos);
			}
		}
	})
}

function fnVerDetalles(id_producto){
	window.location = 'detalles_producto.php?product='+id_producto+'';
}