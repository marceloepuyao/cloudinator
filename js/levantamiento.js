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
	
	if($.session.get('empresa')!==undefined){
		console.log("empresa",$.session.get('empresa') );
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
	console.log("asdasd");
}
function guardarlevantamiento(titulo, info, contactado, area, forms, idlev){
	if(idlev){
		action = "update";
	}else{
		action = "insert";
	}
	
	$.post("ajax/ajaxlevantamientos.php",{ 
		action: action,
		idlev : idlev,
		titulo : titulo, 
		info : info, 
		contactado : contactado, 
		area : area, 
		forms : forms,
		empresaid : $.session.get('empresa')
		},function(respuesta){
			
			console.log("guardarlevantamiento", respuesta);
			var obj = jQuery.parseJSON(respuesta);
			if(obj.result){
	        	console.log("la respuesta es", obj.id );
	        	if(action == "insert"){
	        		window.location.href = "recorrer.php?emp="+$.session.get('empresa')+'&idlev='+obj.id + "&lang=" + getLang();
	        	}else if(action == "update"){
	        		window.location.href = "levantamiento.php?emp="+$.session.get('empresa') + "&lang=" + getLang();
	        	}
			}else{
				console.log("error en guardarlevantamiento", obj.exception);
			}
			
		}
	);
}

function deleteLevantamiento(idlev){
	$.post("ajax/ajaxlevantamientos.php",{ 
		idlev : idlev,
		action: "delete"
		},function(respuesta){
			console.log("deletelevantamiento", respuesta);
			var response = jQuery.parseJSON(respuesta);
			if(response.result){
				window.location.href = "";
			}else{
				console.log("error en eliminar levantamiento", response.exception);
			}
		}
	);
}

$(document).ready(function(){
	
	checkSessionorDie();
	
	console.log("WTF");
	
	$("#backbutton").on('click', function(){
		window.location.href = "index.html?lang=" + getLang();
	});

	$("#backbutton2").on('click', function(){
		window.location.href = "levantamiento.php?emp="+$.session.get('empresa') + "&lang=" + getLang();
	});
	$(".ira").on('click', function(){
		var idempresa = $(this).data('empresa');
		var idlevantamiento = $(this).data('levantamiento');
		window.location.href = "recorrer.php?emp="+idempresa+"&idlev="+idlevantamiento + "&lang=" + getLang();
	});
	
	
	$(".delete").on('click', function(){
		
		if(confirm("¿Está seguro que desea eliminar el levantamiento?")) { 
			var lev = $(this).data('levantamiento');
			console.log("kakakakak",lev);
			deleteLevantamiento(lev);
		}

	});
	$("#submit").on('click', function(){

		$.mobile.changePage("levantamiento.php#recorrer"); 

	});
	
	$(".goto").on('click', function(){
		var subform = $(this).data('subform');
		var lev = $(this).data('levantamiento');
		window.location.href = "responder.php?idsubform="+subform+"&idlev="+lev + "&lang=" + getLang();


	});
	
	$("#addlevantamiento").on('click', function(){
		var titulo = $("#titulo-levantamiento").val();
		var info =$("#info-levantamiento").val();
		var contactado = $("#contactado-por").val();
		var area = $("#area-contacto").val();
		var idlev= $(this).data('idlev');
		
		//$("#formularios").val();
		var forms = [];
		
		$("#formularios").each(function() {
	        var checkboxes = $(this).find(".ui-checkbox-on");
	        checkboxes.each(function() {
	            var checkbox = $(this);
	            // Highlight pre-selected checkboxes
	            
	            forms.push(checkbox.attr('for'));
	        });
	    });
		if(titulo && info && contactado && area && forms){
			console.log("cambio", JSON.stringify(forms));
			guardarlevantamiento(titulo, info, contactado, area, JSON.stringify(forms), idlev);

		}else{
			alert("faltan campos por llenar");
		}
	

	});
	$("#cancel").on('click', function(){
		window.location.href = "levantamiento.php?emp="+$.session.get('empresa') + "&lang=" + getLang();
	});
	
	$(".edit").on('click', function(){
		var idlevantamiento = $(this).data('id');
		window.location.href = "editarlevantamiento.php?id="+idlevantamiento + "&lang=" + getLang();
	});
	
	$("#mainback").on('click', function(){
		var idlevantamiento = $(this).data('id');
		window.location.href = "levantamiento.php?emp="+$.session.get('empresa') + "&lang=" + getLang();
	});
	
	$("#usernamebutton").on('click', function(){
		//$("#mypanel").trigger( "updatelayout" );
		console.log("trigger");
	});
	
	$("#cerrarsesion").on('click', function(){
		$.session.set('usu', "");
		$.session.set('pass',"");
		$.session.set('empresa',"");
		$.session.set('lastaccess',"");
		window.location.href = "index.html?lang=" + getLang();
		console.log("cierra sesion");
	});
	
	$("#usuarios").on('click', function(){

		window.location.href = "usuarios.php?lang=" + getLang();
	});

	
});