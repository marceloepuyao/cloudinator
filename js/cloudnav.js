function getLang(){
	var lang = $.session.get("lang");
	if(lang == "" || lang == null){
		lang = "es";
	}
	return lang;
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
function setSession(usu, pass, empresa){
	$.session.set('usu', usu);
	$.session.set('pass', pass);
	$.session.set('empresa', empresa);
}
function checkSession(){
	if($.session.get('usu')!="undefined"){
		console.log("usu",$.session.get('usu') );
		$("#text-username").val($.session.get('usu'));
	}
	if($.session.get('pass')!="undefined"){
		console.log("pass",$.session.get('pass') );
		$("#passwordcloud").val($.session.get('pass'));
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
			window.location.href = "index.html" + "&lang=" + getLang();
		}
		
	}else{
		$.session.set('lastaccess',time);
	}
	
	
}
function login(){
	 var usu = $("#text-username").val();
     var pass = $("#passwordcloud").val();
     var empresa = $("#select-choice-1").val();
     $.post("server/login.php",{ usu : usu, pass : pass},function(respuesta){
     	
     	var obj = jQuery.parseJSON(respuesta);
     	console.log(obj);
         if (obj.result == true) {
         	
         	if(empresa == "new"){
         		setSession(usu, pass, null);
         		window.location.href = "nuevaempresa.html?lang="+obj.lang;
         		
         	}else{
         		setSession(usu, pass, empresa);
         		window.location.href = "levantamiento.php?emp="+empresa+"&lang="+obj.lang;
         	}

         }
         else{
         	//$("#pageError").show();
             $.mobile.changePage('#pageError', 'pop', true, true);
             //$("#errorMsg").fadeIn(300);
             //$("#errorMsg").css("display", "block");
         }
     
     });
	
	
}
$(document).ready(function(){
	checkSession();
	llamaempresas();
    $("#errorMsg").hide();
    $("#backbutton").on('click', function(){
    	window.location.href = "index.html" + "&lang=" + getLang();
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
    
});