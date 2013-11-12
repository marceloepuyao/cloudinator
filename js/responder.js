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
			window.location.href = "index.html";
		}
		
	}else{
		$.session.set('lastaccess',time);
		console.log("first time lastaccess",$.session.get('lastaccess') );
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
			var resp = jQuery.parseJSON(respuesta);
			console.log("resp", resp);
			//si la respuesta es positiva se continua, si no mensaje de error
			if(resp.result){
				window.location.href = "responder.php?idlev=" + idlev+"&idsubform="+idsubform;
			}else{
				alert("problemas con escribir en la base de datos");
			}
			
			
			
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
						
						$("#textopregunta").text(resp.node.metaname);
						$("#select-choice").remove();
						$("#select-choice-label").remove();
						$('#popupSubpregunta').popup("open");
						$("#formsubpregunta").append("<input type='hidden' id='idnode' name='idnode' value='"+idnode+"' >");
						/*
						var response = prompt(resp.node.metaname,"escriba acá su respuesta");
						if (response!=null && response!="")
						{
							responderpregunta(idnode, idlev, idsubform, idpregunta, response);
						}  <input type="hidden" name="idlev" value="<?php echo $idlevantamiento; ?>" >
						*/
					}else if(resp.node.metatype == "array"){
						$("#textopregunta").text(resp.node.metaname);
						$("#textarea").remove();
						$("#textarea-label").remove();
						
						var array = resp.node.metadata.split(',');
						$("#select-choice").empty();
						$.each( array, function( key, value ) {
							$("#select-choice").append("<option value="+value+">"+value+"</option>");
							});
						
						$("#formsubpregunta").append("<input type='hidden' name='idnode' id='idnode' value='"+idnode+"' >");
						console.log("metadata",array);
						$('#popupSubpregunta').popup("open");
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
		$.session.set('lastaccess',"");
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
		
	});
	
	$("#respondersubpregunta").on('click', function(){
		var idsubform = $("#idsubform").val();
		var idlev = $("#idlev").val();
		var idpregunta = $("#idpregunta").val();
		var select = $("#select-choice").val();
		var textarea =$("#textarea").val(); 
		var idnode =$("#idnode").val(); 
		
		console.log(idsubform,idlev, idpregunta, select , textarea, idnode);
		
		if(typeof(select) != "undefined" && select !== null) {
			var response = select;
		}else{
			var response =textarea;
		}
		
		responderpregunta(idnode, idlev, idsubform, idpregunta, response);
	});
	$("#usuarios").on('click', function(){

		window.location.href = "usuarios.php";
	});
	
});