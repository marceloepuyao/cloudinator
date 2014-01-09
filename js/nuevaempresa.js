function getUrlParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}
function crearEmpresa(name,industry,textarea){
	
	$.post("server/crearempresa.php",{ 
		action: 'insert',
		name : name, 
		industry : industry,   
		textarea: textarea
		},
		function(respuesta){
			console.log(respuesta);
			var resp = jQuery.parseJSON(respuesta);
			
			if(resp.result){
				window.location.href = "levantamiento.php?emp="+resp.id;
			}else{
				if(resp.exception == "existing"){
					alert("Nombre ocupado");
				}else{
					alert("No se ha podido crear la empresa");
				}
			}
		}
	);
}

$(document).ready(function(){
	
	$("#backbutton").on('click', function(){
		window.location.href = "index.php";
	});
	//alert($(window).width() );
	$(window).resize(function() {
		  if($(window).width() < 800 ){
			  $("#content").css('padding-right', '5%');
			  $("#content").css('padding-left', '5%');
			  //alert($(window).width());
		  }else{
			  $("#content").css('padding-right', '25%');
			  $("#content").css('padding-left', '25%');
		  }
	
	});
	$("#btnNew").on('click', function(){
		//se checkea si están todos los cambios llenos
		var name = $("#new-name-empresa").val();
        var industry = $("#industry").val();
        var textarea = $("#textarea").val();
        //console.log(name,industry , contacted, areacontacto, textarea);
		
        if(name &&  industry && textarea){
        	crearEmpresa(name,industry,textarea);
        }else{
        	alert("Tienes que llenar todos los campos");
        }
		
		
	});
	$("#cancel").on('click', function(){
		
		window.location.href = "index.php";
	});
	
	
});