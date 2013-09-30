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
function responderpregunta(id){
	
	return 3;
}

$(document).ready(function(){
	
	checkSessionorDie();
	
	$("#backbutton").on('click', function(){
		window.location.href = "levantamiento.php?emp="+$.session.get('empresa')+"&idlev="+;
	});
	console.log("hago click");
	
	$(".answer").on('click', function(){
		
		
		var id = $(this).data('id');
		
		var nuevapregunta = responderpregunta(id);
		window.location.href = "responder.php?id=" + nuevapregunta;
		
	});

	
	
});