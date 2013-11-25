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
     var empresa = $("#select-choice-1").val();
     $.post("server/login.php",{ usu : usu, pass : pass, empresa : empresa},function(respuesta){
     	
     	var obj = jQuery.parseJSON(respuesta);
         if (obj.result == true) {
         	if(empresa == "new"){
         		window.location.href = "nuevaempresa.php?lang="+obj.lang;
         		
         	}else{
         		window.location.href = "levantamiento.php?emp="+empresa+"&lang="+obj.lang;
         	}
         }
         else{
             $.mobile.changePage('#pageError', 'pop', true, true);
         }
     
     });
	
	
}
$(document).ready(function(){
	
	llamaempresas();
    $("#errorMsg").hide();
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
    
});