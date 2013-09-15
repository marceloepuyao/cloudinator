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
			$("#empresanombre2").text(emp.nombre);
			$("#empresanombre3").text(emp.nombre);
			$("#infoempresa").text(emp.infolevantamiento);
		});
	
	
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
			$.mobile.changePage("levantamiento.html"); 
		}

	});

	
});