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
	console.log("asdasd");
}
function guardarlevantamiento(titulo, info, contactado, area, forms){
	
	$.post("ajax/ajaxlevantamientos.php",{ 
		titulo : titulo, 
		info : info, 
		contactado : contactado, 
		area : area, 
		forms : forms,
		empresaid : $.session.get('empresa')
		},function(respuesta){
		
			console.log(respuesta);
		}
	);
}

$(document).ready(function(){
	
	checkSessionorDie();
	
	$("#backbutton").on('click', function(){
		window.location.href = "inicio.html";
	});

	
	$(".delete").on('click', function(){
		
		if(confirm("Are you sure?")) { 
			//delete
			$.mobile.changePage("levantamiento.php"); 
		}

	});
	$("#submit").on('click', function(){

		$.mobile.changePage("levantamiento.php#recorrer"); 

	});
	
	$(".goto").on('click', function(){
		var id = $(this).data('id');
		window.location.href = "responder.php?subform="+id;


	});
	
	$("#addlevantamiento").on('click', function(){
		var titulo = $("#titulo-levantamiento").val();
		var info =$("#info-levantamiento").val();
		var contactado = $("#contactado-por").val();
		var area = $("#area-contacto").val();
		//$("#formularios").val();
		var forms = [];
		
		$("#formularios").each(function() {
	        var checkboxes = $(this).find(".ui-checkbox-on");
	        checkboxes.each(function() {
	            var checkbox = $(this);
	            // Highlight pre-selected checkboxes
	            
	            forms.push({name: checkbox.attr('for'), value: checkbox.attr('for')});
	        });
	    });
		if(titulo && info && contactado && area && forms){
			console.log($.param(forms));
			guardarlevantamiento(titulo, info, contactado, area, $.param(forms));
			window.location.href = "levantamiento.php?emp="+$.session.get('empresa')+'#recorrer';

		}else{
			alert("faltan campos por llenar");
		}
	

	});
	$("#cancel").on('click', function(){
		window.location.href = "levantamiento.php?emp="+$.session.get('empresa');
	});

	
});