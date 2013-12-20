function getUrlParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}
function responderpregunta(idnode, idlev, idsubform, idpregunta, respsubpregunta){
	console.log("respsubpregunta",respsubpregunta);
	$.post("ajax/ajaxresponder.php",{ 
		idnode: idnode,
		idlev: idlev,
		idsubform: idsubform,
		action: 'insert',
		idpregunta: idpregunta,
		idempresa: getUrlParameter('emp'), 
		respsubpregunta: respsubpregunta
		},function(respuesta){
			console.log(respuesta);
			var resp = jQuery.parseJSON(respuesta);
			
			//si la respuesta es positiva se continua, si no mensaje de error
			if(resp.result){
				window.location.href = "responder.php?idlev=" + idlev + "&idsubform=" + idsubform + "&lang=" + getUrlParameter('lang');
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
				window.location.href = "responder.php?idlev=" + idlev+"&idsubform="+idsubform+ "&lang=" + getUrlParameter('lang');
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
	
	$(".backtoRecorrer").on('click', function(){
		var idlev = $(this).data('idlev');
		var idform = $(this).data('idform');
		window.location.href = "recorrer.php?idlev="+idlev+ "&lang=" + getUrlParameter('lang')+"&idform="+idform;

	});
	$(".backtoIndex").on('click', function(){
		window.location.href = "index.php?lang=" + getUrlParameter("lang");
	});
	$(".backtoLevantamiento").on('click', function(){
		var emp = $(this).data('idemp');
		window.location.href = "levantamiento.php?emp="+emp+"&lang=" + getUrlParameter("lang");
	});
	
	$(".answer").on('click', function(){
	
		var idnode = $(this).data('idnode');	
		var idlev = $(this).data('idlev');	
		var idsubform = $(this).data('idsubform');	
		var idpregunta = $(this).data('idpregunta');
		//var userid =  $(this).data('idpregunta');
		
		SubPregunta(idpregunta, idnode, idlev, idsubform);
	});
	$("#responderquit").on('click', function(){
		var emp = $(this).data('emp');
		var idlev = $(this).data('idlev');
		window.location.href = "recorrer.php?emp="+emp+"&idlev="+idlev+ "&lang=" + getUrlParameter('lang');
	});
	
	$("#responderback").on('click', function(){
		var idsubform = $(this).data('idsubform');
		var idlev = $(this).data('idlev');
		var idreg = $(this).data('idreg');
		if(idreg == 0){
			alert("No hay preguntas anteriores");
		}else{
			window.location.href = "responder.php?idlev=" + idlev + "&idsubform=" + idsubform + "&idpreg="+idreg+"&lang=" + getUrlParameter('lang');
		}
		//delete ultima pregunta respondida
		//borrarUltimaPreguntaRespondida(idsubform, idlev);
		
	});
	
	$("#respondersubpregunta").on('click', function(){
		var idsubform = $("#idsubform").val();
		var idlev = $("#idlev").val();
		var idpregunta = $("#idpregunta").val();
		var select = $("#select-choice").val();
		var textarea =$("#textarea").val(); 
		var idnode =$("#idnode").val(); 
		
		if(typeof(select) != "undefined" && select !== null) {
			var response = select;
		}else{
			var response =textarea;
		}
		
		responderpregunta(idnode, idlev, idsubform, idpregunta, response);
	});
	$("#omitirsubpregunta").on('click', function(){
		var idsubform = $("#idsubform").val();
		var idlev = $("#idlev").val();
		var idpregunta = $("#idpregunta").val();
		var idnode =$("#idnode").val(); 

		responderpregunta(idnode, idlev, idsubform, idpregunta, "Omitida");
	});
	$(".gobacktoquestion").on('click', function(){
		var idpregunta = $(this).data('id');
		var idsubform = $("#idsubform").val();
		var idlev = $("#idlev").val();
		
		window.location.href = "responder.php?idlev=" + idlev + "&idsubform=" + idsubform + "&idpreg="+idpregunta+"&lang=" + getUrlParameter('lang');
	});
	$(".cerrarsesion").on('click', function(){
		$.post("server/session.php",{ 
			action: "deleteall"
			},function(respuesta){
				window.location.href = "index.php?lang=" + getUrlParameter("lang");
				console.log("cierra sesion");
			});
	});
	
	$(".usuarios").on('click', function(){
		window.location.href = "usuarios.php?lang=" + getUrlParameter("lang");
	});
	$(".edicion").on('click', function(){
		
		if(getUrlParameter("edit") == 1){
			window.location.href = "recorrer.php?emp="+getUrlParameter("emp")+"&idlev="+getUrlParameter("idlev")+"&lang=" + getUrlParameter("lang");
		}else{
			window.location.href = "recorrer.php?emp="+getUrlParameter("emp")+"&idlev="+getUrlParameter("idlev")+"&lang=" + getUrlParameter("lang") +"&edit=1";
		}
	});
	$(".editor").on('click', function(){
		window.location.href = "editor.php";
	});
	$(".gestionempresas").on('click', function(){
		window.location.href = "empresas.php?lang=" + getUrlParameter("lang");
	});
});