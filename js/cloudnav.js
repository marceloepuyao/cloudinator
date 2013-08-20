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
$(document).ready(function(){
	checkSession();
	llamaempresas();
    $("#errorMsg").hide();
    $("#backbutton").on('click', function(){
    	window.location.href = "inicio.html";
	});
    $("#btnLogin").click(function(){
        var usu = $("#text-username").val();
        var pass = $("#passwordcloud").val();
        var empresa = $("#select-choice-1").val();
        $.post("server/login.php",{ usu : usu, pass : pass},function(respuesta){
        	
        	var obj = jQuery.parseJSON(respuesta);
        	console.log(obj);
            if (obj.result == "true") {
            	
            	if(empresa == "new"){
            		setSession(usu, pass, null);
            		window.location.href = "nuevaempresa.html";
            		
            	}else{
            		$.mobile.changePage("levantamiento.html");   
            		setSession(usu, pass, empresa);
            	}

            }
            else{
            	//$("#pageError").show();
                $.mobile.changePage('#pageError', 'pop', true, true);
                //$("#errorMsg").fadeIn(300);
                //$("#errorMsg").css("display", "block");
            }
        
        });
    });
});