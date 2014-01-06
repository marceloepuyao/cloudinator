function getUrlParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
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
         		window.location.href = "index.php";
         }
         else{
             $.mobile.changePage('#pageError', 'pop', true, true);
             //$("#acceptButton").focus();
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
	        		window.location.href = "recorrer.php?emp="+getUrlParameter("emp")+'&idlev='+obj.id;
	        	}else if(action == "update"){
	        		window.location.href = "levantamiento.php?emp="+getUrlParameter("emp") ;
	        	}
			}else{
				console.log("error en guardarlevantamiento", obj.exception);
			}
			
		}
	);
}
function validateText( str ) {
	var  vsExprReg = /^([a-zA-Z0-9áéíóúÁÉÍÓÚ_\sc]+)$/;
	var test = str.replace(/ /g, "");
	console.log("test",test);
	if(test != "" && vsExprReg.test(str)){
		return true;
	}else{
		return false;
	}
	
}
function validateLargeText( str ) {
	var  vsExprReg = /^([a-zA-Z0-9áéíóúÁÉÍÓÚ,.:;\sc]+)$/;
	 return vsExprReg.test(str);
}

function validateEmail(email){
	
	var  vsExprReg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
	if(vsExprReg.test(email) || email == "admin"){
		return true;
	}else{
		return false;
	}
	
}

//NO SE ESTÁ USANDO
function validatePass(pass) {
    var RegExPattern = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
    var errorMessage = 'Password Incorrecta.';
    if ((pass.match(RegExPattern)) && (pass!='')) {
        return true;
    } else {
        alert(errorMessage);
        return false;
    } 
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
function crearEmpresa(name,industry,textarea, empresaid){
	var action = "edit";
	if(empresaid==0){
		action = "insert";
	}
	console.log("action ",action);
	
	$.post("server/crearempresa.php",{ 
		action: action,
		empresaid : empresaid,
		name : name, 
		industry : industry,   
		textarea: textarea
		},
		function(respuesta){
			console.log(respuesta);
			var resp = jQuery.parseJSON(respuesta);
			
			if(resp.result){
				if(empresaid==0){
					window.location.href = "levantamiento.php?emp="+resp.id;
				}else{
					window.location.href = "empresas.php";
				}
				
			}else{
				if(resp.exception == "existing"){
					alert("Nombre ocupado");
				}else{
					alert("No se ha podido crear la empresa");
				}
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
				window.location.href = "usuarios.php";
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
				window.location.href = "usuarios.php";
			}else{
				if(response.sameperson){
					alert("No puedes borrarte a ti mismo");
				}else{
					console.log("error en eliminar usuario", response.exception);
				}
			}	
		});
}

function deletecompany(idcompany){
	$.post("server/crearempresa.php",{ 
		action: "delete",
		idcompany : idcompany
		},function(respuesta){			
			var response = jQuery.parseJSON(respuesta);
			if(response.result){
				window.location.href = "empresas.php";
			}else{
				console.log("error en eliminar empresa", response.exception);
			}	
		});
}

$(document).ready(function(){
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
    		window.location.href = "nuevaempresa.php";
    	}else{
	    	$.post("server/login.php",{
	       	 action: "empresa",
	       	 empresa : empresa
	       	 },function(respuesta){
	       		 var resp = jQuery.parseJSON(respuesta);
				if(resp.result){
					window.location.href = "levantamiento.php?emp="+empresa;
				}else{
					alert("Error al seleccionar empresa");
				}
	       	 });
    	}
    });
	$(".backtoIndex").on('click', function(){
		window.location.href = "index.php";
	});
	$(".backtoLevantamiento").on('click', function(){
		var emp = $(this).data('idemp');
		window.location.href = "levantamiento.php?emp="+emp;
	});
	$(".ira").on('click', function(){
		var idempresa = $(this).data('empresa');
		var idlevantamiento = $(this).data('levantamiento');
		window.location.href = "recorrer.php?emp="+idempresa+"&idlev="+idlevantamiento;
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
		var idclone = $(this).data('idclone');
		
		if(idclone){
			window.location.href = "responder.php?idclone="+idclone+"&idlev="+lev;
		}else{
			window.location.href = "responder.php?idsubform="+subform+"&idlev="+lev;
		}
		
		
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
		window.location.href = "levantamiento.php?emp="+getUrlParameter('emp');
	});
	
	$(".editor").on('click', function(){
		window.location.href = "editor.php";
	});
	
	$(".edit").on('click', function(){
		var idlevantamiento = $(this).data('id');
		window.location.href = "editarlevantamiento.php?id="+idlevantamiento + "&emp=" + getUrlParameter("emp");
	});
	
	$("#mainback").on('click', function(){
		var idlevantamiento = $(this).data('id');
		window.location.href = "levantamiento.php?emp="+getUrlParameter('emp');
	});
	
	$("#usernamebutton").on('click', function(){
		//$("#mypanel").trigger( "updatelayout" );
		console.log("trigger");
	});
	
	$(".cerrarsesion").on('click', function(){
		$.post("server/session.php",{ 
			action: "deleteall"
			},function(respuesta){
				window.location.href = "index.php";
				console.log("cierra sesion");
				
			});
	});
	
	$(".usuarios").on('click', function(){

		window.location.href = "usuarios.php";
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
		
		if(validateText(nombres) && validateText(apellidos) && validateEmail(email) && password != "" && validateText(idioma) && repassword != ""){
			if(password == repassword){
				newuser(nombres,apellidos,email,password, idioma, superusuario, editto);
			}else{
				alert("Error en Contraseña");
			}

		}else{
			alert("Hay Carácteres Inválidos");
		}
	});
	$(".deleteuser").on('click', function(){
		var iduser = $(this).data('iduser');
		deleteuser(iduser, null);
	});
	$(".edituser").on('click', function(){
		var iduser = $(this).data('iduser');
		window.location.href = "usuarios.php?edit="+iduser+"#newuser";
	});
	
	$("#tonewuser").on('click', function(){
		window.location.href = "usuarios.php#newuser";
	});
	
	$(".deletecompany").on('click', function(){
		var idcompany = $(this).data('idcompany');
		if(!confirm("¿Está seguro que desea eliminar la empresa y todos los levantamientos asocioados? ")){
			return false;
		}else {
			deletecompany(idcompany);
	     }  
			
	});
	$(".editcompany").on('click', function(){
		var idcompany = $(this).data('idcompany');
		window.location.href = "empresas.php?emp="+idcompany;
	});
	
	$(".edicion").on('click', function(){
		$.post("server/session.php",{
			action: 'edit'
			},function(respuesta){
				window.location.href = "recorrer.php?emp="+getUrlParameter("emp")+"&idlev="+getUrlParameter("idlev");
			});
	});
	$(".gestionempresas").on('click', function(){
		window.location.href = "empresas.php";
	});
	
	$(".deleteanswers").on('click', function(){
		var idsubform = $(this).data('idsubform');
		var idlev = $(this).data('levantamiento');
		var idform = $(this).data('idform');
		var idclone = $(this).data('idclone');
		
		$.post("ajax/ajaxresponder.php",{ 
			idlev: idlev,
			idsubform: idsubform,
			idclone: idclone,
			action: 'deleteall'
			},function(respuesta){
				var resp = jQuery.parseJSON(respuesta);
				if(resp.result){
					window.location.href ="recorrer.php?idlev="+idlev+"&edit=1&idform="+idform;
				}else{
					alert("problemas con escribir en la base de datos");
				}
			});
	});
	$("#btnNew").on('click', function(){
		//se checkea si están todos los cambios llenos
		var name = $("#new-name-empresa").val();
        var industry = $("#industry").val();
        var textarea = $("#textarea").val();
		
        
        if(name != null && name != "" &&  industry != null && name != ""){
        	if(validateText(name) && validateText(industry) && (validateLargeText(textarea) || textarea=="")){
        		crearEmpresa(name,industry,textarea, 0);
        	}else{
        		alert("Hay carácteres inválidos");
        	}
        }else{
        	alert("Tienes que llenar todos los campos");
        }
		
		
	});
	
	$("#editCompany").on('click', function(){
		//se checkea si están todos los cambios llenos
		var idcompany = $(this).data('idcompany');
		var name = $("#nombreempresa").val();
        var industry = $("#industry").val();
        var textarea = $("#textarea").val();
		
        if(name != null && name != "" &&  industry != null && name != ""){
        	if(validateText(name) &&  validateText(industry) &&  (validateLargeText(textarea) ||  textarea =="")){
        		crearEmpresa(name,industry,textarea, idcompany);
        	}else{
        		alert("Hay carácteres inválidos");
        	}
        	
        }else{
        	alert("Tienes que llenar todos los campos");
        }
	});
	$(".cloneanswers").on('click', function(){
		var idsubform = $(this).data('subform');
		var idlev = $(this).data('levantamiento');
		var idform = $(this).data('idform');
		var oldname = $(this).data('oldname');
		
		var name = prompt("Nombre del Subformulario clonado", oldname);
		if(name != null){
			$.post("ajax/ajaxresponder.php",{ 
				idlev: idlev,
				idsubform: idsubform,
				idform: idform,
				name:name,
				action: 'cloneanswers'
				},function(respuesta){
					var resp = jQuery.parseJSON(respuesta);
					if(resp.result){
						window.location.href ="recorrer.php?idlev="+idlev+"&edit=1&idform="+idform;
					}else{
						alert("problemas con escribir en la base de datos");
					}
				});
		}
	});
	
	$(".gotoclone").on('click', function(){
		var cloneid = $(this).data('cloneid');
		var lev = $(this).data('levantamiento');
		
		window.location.href = "responder.php?idclone="+cloneid+"&idlev="+lev;
	});
	$(".deleteclone").on('click', function(){
		var idclone = $(this).data('idclone');
		var idlev = $(this).data('levantamiento');
		var idform = $(this).data('idform');
		
		$.post("ajax/ajaxresponder.php",{ 
			idclone: idclone,
			idlev: idlev,
			action: 'deleteclone'
			},function(respuesta){
				var resp = jQuery.parseJSON(respuesta);
				if(resp.result){
					window.location.href = "recorrer.php?idlev="+idlev+"&idform="+idform;
				}else{
					alert("problemas con escribir en la base de datos");
				}
			});
		
		
	});
	
});