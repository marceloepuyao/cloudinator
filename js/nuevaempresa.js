function getLang(){
	var lang = $.session.get("lang");
	if(lang == "" || lang == null){
		lang = "es";
	}
	return lang;
}
function checkSessionorDie(){
	
	if($.session.get('usu')!==undefined){
		console.log("usu",$.session.get('usu') );
	}else{
		window.location.href = "index.html?lang=" + getLang();
	}
	if($.session.get('pass')!==undefined){
		console.log("pass",$.session.get('pass') );
	}else{
		window.location.href = "index.html?lang=" + getLang();
	}
	
	var d = new Date();
	var time = d.getTime(); 
	if($.session.get('lastaccess')!==undefined){
		if((time - $.session.get('lastaccess'))  < 5*60*1000){
			console.log("se renueva", time - $.session.get('lastaccess') );
			$.session.set('lastaccess',time);
		}else{
			console.log("se cierra, han pasado ", time - $.session.get('lastaccess'), "milisegundos" );
			$.session.set('usu', "");
			$.session.set('pass',"");
			$.session.set('empresa',"");
			$.session.set('lastaccess',"");
			window.location.href = "index.html?lang=" + getLang();
		}
		
	}else{
		$.session.set('lastaccess',time);
		console.log("first time lastaccess",$.session.get('lastaccess') );
	}
	
	$("#usernamebutton").text($.session.get('usu'));
}
function crearEmpresa(name,industry,textarea){
	
	$.post("server/crearempresa.php",{ 
		name : name, 
		industry : industry,   
		textarea: textarea
		},
		function(respuesta){
			console.log(respuesta);
			var resp = jQuery.parseJSON(respuesta);
			
			if(resp.result){
				$.session.set('empresa', resp.id);
				//alert("empresa creada con éxito");
				window.location.href = "levantamiento.php?emp="+resp.id + "&lang=" + getLang();
			}else{
				if(resp.exception == "existing"){
					alert("Nombre ocupado");
				}else{
					alert("No se ha podido crear la empresa");
					console.log("exception", resp.exception);
				}
			}
		}
	);
}

$(document).ready(function(){
	
	checkSessionorDie();
	
	$("#backbutton").on('click', function(){
		window.location.href = "index.html?lang=" + getLang();
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
		
		window.location.href = "index.html?lang=" + getLang();
	});
	
	
});