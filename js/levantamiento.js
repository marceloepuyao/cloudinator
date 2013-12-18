function getUrlParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}
function llamaempresas(){
	
	$.post("server/empresas.php",function(empresas){
		var emp = jQuery.parseJSON(empresas);
		for (var i=0;i<emp.total;i++)
		{
			$("#select-choice-1").append("<option value='"+emp[i].id+"'>" +emp[i].nombre +"</option>");
		}
		
	});
	
}
function login(){
	 var usu = $("#text-username").val();
     var pass = $("#passwordcloud").val();
     $.post("server/login.php",{
    	 action: "login",
    	 usu : usu, 
    	 pass : pass
    	 },function(respuesta){
     	
     	var obj = jQuery.parseJSON(respuesta);
         if (obj.result == true) {
         		window.location.href = "index.php?lang="+obj.lang;
         }
         else{
             $.mobile.changePage('#pageError', 'pop', true, true);
         }
     });
	
	
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
		empresaid : getUrlParameter("emp")
		},function(respuesta){
			
			console.log("guardarlevantamiento", respuesta);
			var obj = jQuery.parseJSON(respuesta);
			if(obj.result){
	        	console.log("la respuesta es", obj.id );
	        	if(action == "insert"){
	        		window.location.href = "recorrer.php?emp="+getUrlParameter("emp")+'&idlev='+obj.id + "&lang=" + getUrlParameter("lang");
	        	}else if(action == "update"){
	        		window.location.href = "levantamiento.php?emp="+getUrlParameter("emp") + "&lang=" + getUrlParameter("lang");
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

function newuser(nombres,apellidos,email,password, idioma, superusuario, editto){
	
	var action = "insert";
	if(editto != 0){
		action = "update";
	}
	
	$.post("ajax/ajaxusers.php",{ 
		action: action,
		editto : editto,
		nombres : nombres,
		apellidos : apellidos, 
		email : email, 
		password : password,
		idioma : idioma, 
		superusuario : superusuario
		},function(respuesta){
			console.log("respuesta",respuesta);
			
			var response = jQuery.parseJSON(respuesta);
			if(response.result){
				window.location.href = "usuarios.php?lang="+getUrlParameter("lang");
			}else{
				console.log("error guardar información del usuario", response.exception);
			}
			
		});
}

function deleteuser(iduser){
	$.post("ajax/ajaxusers.php",{ 
		action: "delete",
		iduser : iduser
		},function(respuesta){			
			var response = jQuery.parseJSON(respuesta);
			if(response.result){
				window.location.href = "usuarios.php?lang="+getUrlParameter("lang");
			}else{
				if(response.sameperson){
					alert("No puedes borrarte a ti mismo");
				}else{
					console.log("error en eliminar levantamiento", response.exception);
				}
			}	
		});
}

$(document).ready(function(){
	$("#backbutton").on('click', function(){
    	window.location.href = "index.php?lang=" + getUrlParameter('lang');
	});
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
    $("#btnLogin").click(function(){
    	login();
    });
    $('#text-username').bind('keypress', function(e) {
    	var code = (e.keyCode ? e.keyCode : e.which);
    	 if(code == 13) { //Enter keycode
    		 login();
    	 }
    	
    });
    $('#passwordcloud').bind('keypress', function(e) {
    	var code = (e.keyCode ? e.keyCode : e.which);
    	 if(code == 13) { //Enter keycode
    		 login();
    	 }
    	
    });
    
    $("#es").click(function(){
    	window.location.href = "index.php?lang=es";
    });
    $("#en").click(function(){
    	window.location.href = "index.php?lang=en";
    });
    $("#pt").click(function(){
    	window.location.href = "index.php?lang=pt";
    });
    $("#btnEmpresa").click(function(){
    	var empresa = $("#select-choice-1").val();
    	
    	if(empresa == "new"){
    		window.location.href = "nuevaempresa.php?lang="+getUrlParameter('lang');
    	}
    	$.post("server/login.php",{
       	 action: "empresa",
       	 empresa : empresa
       	 },function(respuesta){
       		 var resp = jQuery.parseJSON(respuesta);
			if(resp.result){
				window.location.href = "levantamiento.php?emp="+empresa+ "&lang=" + getUrlParameter('lang');
			}else{
				alert("Error al seleccionar empresa");
			}
       	 });
    	
    });
	

	$("#backbutton").on('click', function(){
		window.location.href = "index.php?lang=" + getUrlParameter("lang");
	});

	$("#backbutton2").on('click', function(){
		window.location.href = "levantamiento.php?emp="+getUrlParameter("emp") + "&lang=" + getUrlParameter("lang");
	});
	$(".ira").on('click', function(){
		var idempresa = $(this).data('empresa');
		var idlevantamiento = $(this).data('levantamiento');
		window.location.href = "recorrer.php?emp="+idempresa+"&idlev="+idlevantamiento + "&lang=" + getUrlParameter("lang");
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
		
		window.location.href = "responder.php?idsubform="+subform+"&idlev="+lev + "&lang=" + getUrlParameter("lang");
		
		


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
		window.location.href = "levantamiento.php?emp="+getUrlParameter('emp') + "&lang=" + getUrlParameter("lang");
	});
	
	$(".editor").on('click', function(){
		window.location.href = "editor.html";
	});
	
	$(".edit").on('click', function(){
		var idlevantamiento = $(this).data('id');
		window.location.href = "editarlevantamiento.php?id="+idlevantamiento + "&emp=" + getUrlParameter("emp")+"&lang=" + getUrlParameter("lang");
	});
	
	$("#mainback").on('click', function(){
		var idlevantamiento = $(this).data('id');
		window.location.href = "levantamiento.php?emp="+getUrlParameter('emp') + "&lang=" + getUrlParameter("lang");
	});
	
	$("#usernamebutton").on('click', function(){
		//$("#mypanel").trigger( "updatelayout" );
		console.log("trigger");
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
	
	$("#acceptnewuser").on('click', function(){
		var nombres = $("#nombres").val();
		var apellidos =$("#apellidos").val();
		var email = $("#email-empresarial").val();
		var password = $("#password").val();
		var repassword = $("#repassword").val();
		var idioma = $("#idioma").val();
		var superusuario = $("#superuser").val();
		
		var editto = $(this).data('editto');
		
		if(nombres && apellidos && email && password && idioma && repassword){
			if(password == repassword){
				console.log("new user", nombres,apellidos,email,password, idioma, superusuario);
				
				newuser(nombres,apellidos,email,password, idioma, superusuario, editto);
			}else{
				alert("Error en Contraseña");
			}

		}else{
			alert("Faltan campos por llenar");
		}
	});
	$(".deleteuser").on('click', function(){
		var iduser = $(this).data('iduser');
		deleteuser(iduser, null);
	});
	$(".edituser").on('click', function(){
		var iduser = $(this).data('iduser');
		window.location.href = "usuarios.php?lang=" + getUrlParameter("lang") + "&edit="+iduser+"#newuser";
	});
	
	$("#tonewuser").on('click', function(){
		window.location.href = "usuarios.php?lang=" + getUrlParameter("lang") +"#newuser";
	});
	
	$(".edicion").on('click', function(){
		
		if(getUrlParameter("edit") == 1){
			window.location.href = "recorrer.php?emp="+getUrlParameter("emp")+"&idlev="+getUrlParameter("idlev")+"&lang=" + getUrlParameter("lang");
		}else{
			window.location.href = "recorrer.php?emp="+getUrlParameter("emp")+"&idlev="+getUrlParameter("idlev")+"&lang=" + getUrlParameter("lang") +"&edit=1";
		}
	});
	
	$(".deleteanswers").on('click', function(){
		var idsubform = $(this).data('subform');
		var idlev = $(this).data('levantamiento');
		
		$.post("ajax/ajaxresponder.php",{ 
			idlev: idlev,
			idsubform: idsubform,
			action: 'deleteall'
			},function(respuesta){
				var resp = jQuery.parseJSON(respuesta);
				if(resp.result){
					console.log(respuesta);
				}else{
					alert("problemas con escribir en la base de datos");
				}
			});
	});
	
	
	

	
});