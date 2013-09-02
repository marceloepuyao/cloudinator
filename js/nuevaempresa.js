function checkSessionorDie(){
	
	if($.session.get('usu')!==undefined){
		console.log("usu",$.session.get('usu') );
	}else{
		window.location.href = "notfound.html";
	}
	if($.session.get('pass')!==undefined){
		console.log("pass",$.session.get('pass') );
	}else{
		window.location.href = "notfound.html";
	}
	
	$("#usernamebutton").text($.session.get('usu'));
}
function crearEmpresa(name,industry,contacted,areacontacto,textarea){
	
	$.post("server/crearempresa.php",{ 
		name : name, 
		industry : industry, 
		contacted:contacted,
		areacontacto:areacontacto,  
		textarea: textarea
		},
		function(respuesta){
			console.log(respuesta);
			var resp = jQuery.parseJSON(respuesta);
			
			if(resp.result){
				$.session.set('empresa', resp.id);
				 
				alert("empresa creada con éxito");
				window.location.href = "levantamiento.html";
			}else{
				alert("no se ha podido crear la empresa");
			}
		}
	);
}

$(document).ready(function(){
	
	checkSessionorDie();
	
	$("#backbutton").on('click', function(){
		window.location.href = "inicio.html";
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
        var contacted = $("#contacted").val();
        var areacontacto = $("#areacontacto").val();
        var textarea = $("#textarea").val();
        //console.log(name,industry , contacted, areacontacto, textarea);
		
        if(name &&  industry && contacted && areacontacto && textarea){
        	crearEmpresa(name,industry,contacted,areacontacto,textarea);
        }else{
        	alert("Tienes que llenar todos los campos");
        }
		
		
	});
	
	
	
});