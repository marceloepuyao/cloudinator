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

//obtener id de levantamiento
if(isset($_GET['id'])){
	$idlevantamiento = (int)$_GET['id'];
}else{
	header( 'Location: notfound.html' );
}
//obtener toda la info del levantamiento, sino existe tirar error.
if(!$levantamiento = getLevantamientobyId($idlevantamiento)){
	header( 'Location: notfound.html' );
}
$formsactivos = json_decode($levantamiento['formsactivos']);
//obtener empresa
$empresa = getEmpresaByLevantamientoId($idlevantamiento);

$formularios = getAllFormularios();

$queryusers = "SELECT * FROM users";
$users = DBQueryReturnArray($queryusers);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<style type="text/css" media="screen">
		.jqm-content {
			padding-right: 25%;
			padding-left: 25%;
		}
		.container {
			border-top: 1px solid #7ACEF4;
			margin: 0 auto;
			padding: 0 50px;
		}
</style>
<title>Editar Levantamiento</title>
</head>
<body class="api jquery-mobile home blog single-autho">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>

<div id="edit" data-role="page" >
	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#" id="backbutton2" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1 id ="empresanombre2"><?php echo $empresa['nombre']; ?>	</h1>
	    
	</div>
	
	<div data-role="content" class="container"> 
		<h2>Editar Levantamiento</h2>
		    <ul data-role="listview" data-inset="true">
		        <li data-role="fieldcontain">
		            <label for="titulo-levantamiento"><?php echo get_string("titlevisit", $lang)?>:</label>
		            <input name="titulo-levantamiento" maxlength="50" id="titulo-levantamiento" value="<?php echo $levantamiento['titulo']?>" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="info-levantamiento"><?php echo get_string("info", $lang)?>:</label>
 					<textarea cols="40" rows="8" maxlength="25" name="info-levantamiento"  id="info-levantamiento"><?php echo $levantamiento['info']?></textarea>		        
 				</li>
 				<li data-role="fieldcontain">
		        	<label for="contactado-por" class="select"><?php echo get_string("contactedby", $lang)?>:</label> 
		        	<select name="contactado-por" id="contactado-por">
		        	<option value=""><?php ?></option>
		        	<?php foreach($users as $key => $user) { 
		        		if($user['id'] == $levantamiento['conctadopor']){?>
							<option value="<?php echo $user['id']?>" selected><?php echo $user['email']?></option>
							<?php }else{?>
							<option value="<?php echo $user['id']?>"><?php echo $user['email']?></option>
					<?php }}?>
				</select>
				</li>
		        <li data-role="fieldcontain">
		            <label for="area-contacto"><?php echo get_string("contactedarea", $lang)?>:</label>
		            <input name="area-contacto" maxlength="25" id="area-contacto" value="<?php echo $levantamiento['areacontacto']?>" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="formularios"><?php echo get_string("forms", $lang)?>:</label>
		            	<fieldset data-role="controlgroup" id="formularios">
		            	<?php foreach($formularios as $key => $formulario) { 
		            		if (in_array($formulario['id'], $formsactivos)){ ?>
					    	<input name="<?php echo $formulario['id']; ?>" id="<?php echo $formulario['id']; ?>" checked="" type="checkbox">
					    	<?php }else{?>
					    	<input name="<?php echo $formulario['id']; ?>" id="<?php echo $formulario['id']; ?>" type="checkbox">
					    	<?php }?>
					    	<label for="<?php echo $formulario['id']; ?>"><?php echo $formulario['name']; ?></label>
						<?php } ?>
					</fieldset>  
		            <input id="formularios" type="hidden" value="My data"/>
		                      
		        </li>
		        <li class="ui-body ui-body-b">
		            <fieldset class="ui-grid-a">
		                    <div class="ui-block-a"><button id="cancel" data-theme="d"><?php echo get_string("cancel", $lang)?></button></div>
		                    <div class="ui-block-b"><button id="addlevantamiento" data-idlev="<?php echo $levantamiento['id']?>" data-theme="b"><?php echo get_string("continue", $lang)?></button></div>
		            </fieldset>
		        </li>
		    </ul>
		
	</div><!-- /content -->
</div>
<script src="js/levantamiento.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>