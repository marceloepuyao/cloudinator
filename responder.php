<?php
require_once('DB/db.php');
require_once('lib.php');
session_start();

//checkiamos si las sessions están settiadas
if(checkSession($_SESSION['ultimoacceso'], $_SESSION['usuario'], $_SESSION['empresa'], $_SESSION['idioma'])){
	$_SESSION['ultimoacceso'] = time();
}

//obetenemos el lenguaje de la página.
$lang = getLang();

//obtenemos el usuario
$USER = DBQueryReturnArray("SELECT * FROM users WHERE email = '$_SESSION[usuario]'");

//comprobar que las variables estén bien
if(isset($_GET['idlev']) && isset($_GET['idsubform'])){
	//Obtengo el id del subform que estoy completanto
	$idsubform = (int)$_GET['idsubform'];
	//Obtengo el id del levantamiento.
	$idlevantamiento = (int)$_GET['idlev'];

}else{
	header( 'Location: notfound.html' ) ;
}


//obtenemos el subformulaio, si está incompleto devuelve false
if(!$subform = getSubForm($idsubform)){
	die("El subformulario está incompleto, por favor avisar a administrador del sistema");
}
//get empresa
$empresa = getEmpresaByLevantamientoId($idlevantamiento);

//veo cual fue la última pregunta respondida (según levantamiento y subform). si no hay, tomo la primera.
$questionandanswers = getQuestionAnswers($idsubform, $idlevantamiento);

extract($questionandanswers); //devuelve $pregunta, $respuestas, $ultimavisita, $completitud

//si no hay pregunta es por que se ha llegado a final, se muestra resumen de respuestas.
if($pregunta == null){
	
	$tablaresumen = getResumenSubform($idsubform, $idlevantamiento);
	
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
<title>Responder Subformulario</title>
</head>
<body>


<div data-role="page" id="pregunta">
	
	<div data-theme="b" data-display="overlay" data-position="right" data-role="panel" id="mypanel">
		<h2 id="usernamebutton"><?php echo $USER[0]['name']." ".$USER[0]['lastname'];?></h2>
		<a href="#" id="cerrarsesion"><?php echo get_string("logout", $lang)?></a> <br>
		<a href="#" id="usuarios"><?php echo get_string("config", $lang)?></a><br>
		<a href="#header" data-rel="close"><?php echo get_string("close", $lang)?></a>
    <!-- panel content goes here -->
	</div><!-- /panel -->

	<div data-role="header" data-theme="b">
	    <a href="#" id="backbutton" data-emp="<?php echo $empresa['id']; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1> <?php echo $empresa['nombre']?></h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("config", $lang)?></a>
	</div>
	
	<div data-role="content">
		<?php if ($pregunta != null): ?>
		
		<h1><?php echo $pregunta['name']; ?></h1>
		<div data-role="collapsible-set" data-theme="c" data-content-theme="d" data-iconpos="right">
		    <?php foreach($respuestas as $key => $respuesta) : ?>
		    	<div data-idsubform="<?php echo $idsubform; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-idnode="<?php echo $respuesta['id']; ?>" data-idpregunta="<?php echo $pregunta['id']; ?>" class="answer" data-role="button" data-iconpos="top">
					<h3><?php echo $respuesta['name']; ?></h3>
				</div>
			<?php endforeach ?>
		<fieldset class="ui-grid-a">
		                    <div class="ui-block-a"><button id="responderback" data-idsubform="<?php echo $idsubform; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-theme="d">Pregunta anterior</button></div>
		                    <div class="ui-block-b"><button id="responderquit" data-emp="<?php echo $empresa['id']; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-theme="d">Abandonar</button></div>
		 </fieldset>
		</div>
		<?php endif; ?>
		
		<?php if ($pregunta == null): ?>
		<h2>Se ha llegado al fin</h2>
			
			
				
				
				
				
		<table data-role="table" id="table-custom-2" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">
	         <thead>
	           <tr class="ui-bar-d">
	             <th>Pregunta</th>
	             <th>Respuesta</th>
	             <th> Subrespuesta</th>
	           </tr>
	         </thead>
	         <tbody>
	         <?php foreach ($tablaresumen as $preguntas){?>
	         
	           <tr>
	             <th><a href="#"><?php echo getContentByNodeId($preguntas['preguntaid']); ?></a></th>
	             <td><?php echo getContentByNodeId($preguntas['respuestaid']); ?></td>
	             <td><?php echo $preguntas['respsubpregunta']; ?></td>
	           </tr>
	        <?php }?>
	           
	         </tbody>
       </table>
				
				
			<fieldset class="ui-grid-a">
                    <div class="ui-block-a"><button id="responderback" data-idsubform="<?php echo $idsubform; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-theme="d">Pregunta anterior</button></div>
                    <div class="ui-block-b"><button id="responderquit" data-emp="<?php echo $empresa['id']; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-theme="d">Continuar</button></div>
		 	</fieldset>
		<?php endif; ?>
		<div data-role="popup" id="popupSubpregunta" data-theme="a" class="ui-corner-all">
		    
		        <div id="formsubpregunta" style="padding:10px 20px;">
		            <h3 id="textopregunta"></h3>
		           <label id="textarea-label" for='textarea'>ingrese su respuesta</label>
					<textarea cols='40' rows='8' name='textarea' id='textarea'></textarea>
					
					<label id="select-choice-label" for="select-choice" class="select">Seleccione la respuesta</label>
					<select name="select-choice" id="select-choice">
					    <option value="">-</option>
					</select>
					
								
					<input type="hidden" name="idlev"  id="idlev"  value="<?php echo $idlevantamiento; ?>" >
					<input type="hidden" name="idsubform"  id="idsubform"  value="<?php echo $idsubform; ?>" >
					<input type="hidden" name="idpregunta" id="idpregunta"  value="<?php echo $pregunta['id']; ?>" >
					
					
					<button id="respondersubpregunta" type='submit' data-theme='b' data-icon='check'>Continuar</button>
		           
		        </div>
		   
		</div>
	</div>
	
</div>
<script src="js/responder.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>