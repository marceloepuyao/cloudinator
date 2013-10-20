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
         		window.location.href = "nuevaempresa.html";
         		
         	}else{
         		setSession(usu, pass, empresa);
         		window.location.href = "levantamiento.php?emp="+empresa; 
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
    	window.location.href = "index.html";
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