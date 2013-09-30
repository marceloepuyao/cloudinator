<?php
//Obtengo el id del subform que estoy completanto
$idsubform = 1;
//Obtengo el id del levantamiento.
$idlevantamiento = 1;
//id de la empresa
$idempresa = 1;


$subform->nombre = "Comunicaciones";

//veo cual fue la última pregunta respondida (según levantamiento y subform) sino tomo la primera.
if(false){
	
}else{
	//saco la pregunta
	$pregunta = "¿Qué tal?";
	//saco las respuestas
	$respuestas = array("2" =>"Bien", "3" => "Más o menos", "4"=> "Mal");
}








?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<style type="text/css" media="screen">
		.jqm-content {
			padding-right: 25%;
			padding-left: 25%;
		}
</style>
<title>Nuevo Levantamiento</title>
</head>
<body>


<div data-role="page" id="pregunta">
	<div data-role="header" data-theme="b">
	    <a href="#" id="backbutton" data-icon="arrow-l">atrás</a>
	    <h1 id ="empresanombre"> </h1>
	    <a href="#" id="usernamebutton" data-icon="check" class="ui-btn-right"></a>
	</div>
	
	<div data-role="content">
		<h1><?php echo $pregunta?></h1>
		<div data-role="collapsible-set" data-theme="c" data-content-theme="d" data-iconpos="right">
		    <? foreach($respuestas as $key => $respuesta) : ?>
		    	<div data-id=<?php echo $key?> class="answer" data-role="button" data-iconpos="top">
					<h3><?php echo $respuesta?></h3>
				</div>
			<? endforeach ?>
		<fieldset class="ui-grid-a">
		                    <div class="ui-block-a"><button data-theme="d">Pregunta anterior</button></div>
		                    <div class="ui-block-b"><button data-theme="d">Abandonar</button></div>
		 </fieldset>
		</div>
		
	
	
	
	</div>
	
	
</div>
<script src="js/responder.js" type="text/javascript"></script>
<script src="js/jquery.session.js" type="text/javascript"></script>
</body>
</html>