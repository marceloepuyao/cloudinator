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
function guardarlevantamiento(titulos, info, contactado, area, forms){
	
	
}

$(document).ready(function(){
	
	checkSessionorDie();
	
	$("#backbutton").on('click', function(){
		window.location.href = "inicio.html";
	});
	//alert($(window).width() );
	$(window).resize(function() {
		/*
		  if($(window).width() < 800 ){
			  $("#content").css('padding-right', '5%');
			  $("#content").css('padding-left', '5%');
			  //alert($(window).width());
		  }else{
			  $("#content").css('padding-right', '25%');
			  $("#content").css('padding-left', '25%');
		  }
		  */
	
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
		var forms = $("#formularios").val();
		//falta checkear que estén marcados los formularios.
		//guardarlevantamiento(titulos, info, contactado, area, forms);
		
		window.location.href = "levantamiento.php?emp="+$.session.get('empresa')+'#recorrer';


	});
	$("#cancel").on('click', function(){
		window.location.href = "levantamiento.php?emp="+$.session.get('empresa');
	});

	
});