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
	
	if($.session.get('empresa')!==undefined){
		console.log("empresa",$.session.get('empresa') );
	}else{
		window.location.href = "notfound.html";
	}
	
	$("#usernamebutton").text($.session.get('usu'));
	setEmpresaInfo($.session.get('empresa'));
	console.log("asdasd");
}

function setEmpresaInfo(id){
	
	$.post("server/empresas.php",{ 
		action : "getById", 
		id: id
		},function(empresas){
			var emp = jQuery.parseJSON(empresas);
			console.log(emp);
			//console.log("hola", empresas);
			$("#empresanombre").text(emp.nombre);
			$("#infoempresa").text(emp.infolevantamiento);
		});
}
function responderpregunta(idnode, idlev, idsubform, idpregunta, respsubpregunta){
	console.log("respsubpregunta",respsubpregunta);
	$.post("ajax/ajaxresponder.php",{ 
		idnode: idnode,
		idlev: idlev,
		idsubform: idsubform,
		action: 'insert',
		idpregunta: idpregunta,
		iduser: $.session.get('usu'),
		idempresa: $.session.get('empresa'), 
		respsubpregunta: respsubpregunta
		},function(respuesta){
			console.log(respuesta);
			var resp = jQuery.parseJSON(respuesta);
			
			//si la respuesta es positiva se continua, si no mensaje de error
			if(resp.result){
				window.location.href = "responder.php?idlev=" + idlev+"&idsubform="+idsubform;
			}else{
				alert("problemas con escribir en la base de datos");
			}
		});
	
}

function borrarUltimaPreguntaRespondida(idsubform, idlev){
	
	$.post("ajax/ajaxresponder.php",{ 
		action: 'deletelast',
		idlev: idlev,
		idsubform: idsubform
		},function(respuesta){
			window.location.href = "responder.php?idlev=" + idlev+"&idsubform="+idsubform;
		});
	}

function SubPregunta(idpregunta, idnode, idlev, idsubform){
	
	$.post("ajax/ajaxresponder.php",{ 
		action: 'subpregunta',
		idpregunta: idpregunta
		},function(respuesta){
			var resp = jQuery.parseJSON(respuesta);
			//si la respuesta es positiva se continua, si no mensaje de error
			if(resp.result){
				//si tiene subpregunta, se hace, si no se responde pregunta
				if(resp.subpregunta){
					if(resp.node.metatype == "textarea"){
						var response = prompt(resp.node.metaname,"escriba acá su respuesta");
						if (response!=null && response!="")
						{
							responderpregunta(idnode, idlev, idsubform, idpregunta, response);
						}
					}else if(resp.node.metatype == "array"){
						
					}
				}else{
					responderpregunta(idnode, idlev, idsubform, idpregunta, null);
				}
			}else{
				alert("problemas con escribir en la base de datos");
			}
		
		});	
	
}



$(document).ready(function(){
	
	checkSessionorDie();
	
	$("#backbutton").on('click', function(){
		var emp = $(this).data('emp');
		var idlev = $(this).data('idlev');
		window.location.href = "recorrer.php?emp="+emp+"&idlev="+idlev;
	});
	
	$(".answer").on('click', function(){
	
		var idnode = $(this).data('idnode');	
		var idlev = $(this).data('idlev');	
		var idsubform = $(this).data('idsubform');	
		var idpregunta = $(this).data('idpregunta');
		
		SubPregunta(idpregunta, idnode, idlev, idsubform);
		
		

		
	});
	$("#cerrarsesion").on('click', function(){
		$.session.set('usu', "");
		$.session.set('pass',"");
		$.session.set('empresa',"");
		window.location.href = "index.html";
		console.log("cierra sesion");
	});
	
	$("#responderquit").on('click', function(){
		var emp = $(this).data('emp');
		var idlev = $(this).data('idlev');
		window.location.href = "recorrer.php?emp="+emp+"&idlev="+idlev;
	});
	
	$("#responderback").on('click', function(){
		var idsubform = $(this).data('idsubform');
		var idlev = $(this).data('idlev');
		
		//delete ultima pregunta respondida
		borrarUltimaPreguntaRespondida(idsubform, idlev);
		
		window.location.href = "responder.php?idsubform="+idsubform+"&idlev="+idlev;
	});
});