<?php
require_once('DB/db.php');
require_once('lib.php');
session_start();

//checkiamos si las sessions están settiadas
if(isset($_SESSION['ultimoacceso']) && isset($_SESSION['usuario']) && isset($_SESSION['idioma'])){
	if(checkSession($_SESSION['ultimoacceso'], $_SESSION['usuario'], $_SESSION['idioma'])){
		$_SESSION['ultimoacceso'] = time();
	}else{
		header( 'Location: index.php' );
	}
}else{
	header( 'Location: index.php' );
}

//obetenemos el lenguaje de la página.
$lang = getLang();

//obtenemos el usuario
$USER = DBQueryReturnArray("SELECT * FROM users WHERE email = '$_SESSION[usuario]'");

//comprobar que las variables estén bien
if(isset($_GET['idlev']) ){
	$idlevantamiento = (int)$_GET['idlev'];
}
if(isset($_GET['idsubform'])){	
	$idsubform = (int)$_GET['idsubform'];
	$idclone = 0;
	$subform = getSubForm($idsubform);
}else if(isset($_GET['idclone'])){
	$idclone = (int)$_GET['idclone'];
	$idsubform = 0;
	$subform = getSubFormByCloneId($idclone);
}else{
	header( 'Location: notfound.html' ) ;
}

//si se quiere revisar una pregunta pasada se pasa por la URL
if(isset($_GET['idpreg'])){
	$idpregunta = (int)$_GET['idpreg'];
}else{
	$idpregunta = 0;
}

//obtenemos el subformulaio, si está incompleto devuelve false
if(!$subform){
	die("El subformulario está incompleto, por favor avisar al administrador del sistema");
}
//get empresa
$empresa = getEmpresaByLevantamientoId($idlevantamiento);

//si esta consultando por una pregunta ya respondida
if($idpregunta){
	//obtengo la info de la pregunta por id
	$questionandanswers = getQuestionById($idsubform, $idlevantamiento, $idpregunta, $idclone);
	extract($questionandanswers); //devuelve $pregunta, $respuestas, $ultimavisita, $completitud
	$registroanterior = getRegistroAteriorConRegistroID($idregistro, $idsubform, $idlevantamiento);
	$registroanteriorid = $registroanterior['id'];
	
	
}else{
	//veo cual fue la última pregunta respondida (según levantamiento y subform). si no hay, tomo la primera.
	$questionandanswers = getQuestionAnswers($idsubform, $idlevantamiento, $idclone);
	
	extract($questionandanswers); //devuelve $pregunta, $respuestas, $ultimavisita, $completitud, $idregistro
	$registroanteriorid = $idregistro;
}

//si no hay pregunta es por que se ha llegado a final, se muestra resumen de respuestas.
if($pregunta == null){
	$tablaresumen = getResumenSubform($idsubform, $idlevantamiento, $idclone);
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
	
	<?php echo print_panel($USER,$lang);?>

	<div data-role="header" data-theme="b">
	    <a href="#" class="backtoRecorrer" data-form= "<?php echo $subform['megatree'];?>" data-emp="<?php echo $empresa['id']; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1> <?php echo $empresa['nombre']?></h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("options", $lang)?></a>
	</div>
	
	<div data-role="content">
	
		<?php echo print_navbar(0, $empresa['id'], $idlevantamiento, $subform['megatree'], $idsubform, $lang);?>
		
		<?php if ($pregunta != null){ ?>
		
		<h1><?php echo $pregunta['name']; ?></h1>
		<div data-role="collapsible-set" data-theme="c" data-content-theme="d" data-iconpos="right">
		    <?php foreach($respuestas as $key => $respuesta){ 
				$tipo = "c";	
		    	if($idpregunta){
						if($registro['respuestaid'] == $respuesta['id']){
							$tipo = "b";
						}
					}?>
				    	<div  data-userid="<?php echo $USER[0]['id'];?>" data-idclone="<?php echo $idclone; ?>" data-idsubform="<?php echo $idsubform; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-idnode="<?php echo $respuesta['id']; ?>" data-idpregunta="<?php echo $pregunta['id']; ?>" class="answer" data-theme="<?php echo $tipo;?>" data-role="button" data-iconpos="top">
							<h3><?php echo $respuesta['name']; ?></h3>
						</div>
			<?php } ?>
		<fieldset class="ui-grid-a">
        	<div class="ui-block-a"><button id="responderback" data-idreg ="<?php echo $registroanteriorid;?>" data-idclone="<?php echo $idsubform; ?>" data-idsubform="<?php echo $idsubform; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-theme="d"><?php echo get_string('lastquestion', $lang);?></button></div>
           	<div class="ui-block-b"><button id="responderquit" data-emp="<?php echo $empresa['id']; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-theme="d"><?php echo get_string('quit', $lang);?></button></div>
		 </fieldset>
		</div>
		<?php } ?>
		
		<?php if ($pregunta == null): ?>
		<h2><?php echo get_string('endreached', $lang);?></h2>
		
		<table data-role="table" id="movie-table" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive">
	         <thead>
	           <tr class="ui-bar-d">
	             <th><?php echo get_string('question', $lang);?></th>
	             <th><?php echo get_string('answer', $lang);?></th>
	             <th><?php echo get_string('subanswer', $lang);?></th>
	             <th><?php echo get_string('date', $lang);?></th>
	             <th><?php echo get_string('interviewer', $lang);?></th>
	             
	           </tr>
	         </thead>
	         <tbody>
	         <?php foreach ($tablaresumen as $preguntas){?>
	         
	           <tr>
	             <th><a class="gobacktoquestion" data-idlev="<?php echo $idlevantamiento;?>" data-idclone="<?php echo $idclone;?>" data-idsubform="<?php echo $idsubform;?>" data-id="<?php echo $preguntas['id'];?>" href="#"><?php echo getContentByNodeId($preguntas['preguntaid']); ?></a></th>
	             <td><?php echo getContentByNodeId($preguntas['respuestaid']); ?></td>
	             <td><?php echo $preguntas['respsubpregunta']; ?></td>
	             <td><?php echo $preguntas['created']; ?></td>
	             <td><?php echo getNameByUserId($preguntas['userid']); ?></td>
	           </tr>
	           
	        <?php $lastregistro = $preguntas['id'];}?>
	           
	         </tbody>
       </table>
				
				
			<fieldset class="ui-grid-a">
                    <div class="ui-block-a"><button id="responderback" data-idreg="<?php echo $lastregistro;?>" data-idsubform="<?php echo $idsubform; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-theme="d"><?php echo get_string('lastquestion', $lang);?></button></div>
                    <div class="ui-block-b"><button id="responderquit" data-emp="<?php echo $empresa['id']; ?>" data-idlev="<?php echo $idlevantamiento; ?>" data-theme="d"><?php echo get_string('continue', $lang);?></button></div>
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
					<input type="hidden" name="idclone"  id="idclone"  value="<?php echo $idclone; ?>" >
					<input type="hidden" name="idpregunta" id="idpregunta"  value="<?php echo $pregunta['id']; ?>" >
					
					
					<button id="respondersubpregunta" type='submit' data-theme='b' data-icon='check'>Continuar</button>
		            <button id="omitirsubpregunta"  data-theme='c'  data-icon='delete'>Omitir</button>
		        </div>
		   
		</div>
	</div>
	
</div>
<script src="js/responder.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>