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


//si no existen error
if(isset($_GET['emp']) || isset($_GET['idlev'])){
	//id de la empresa
	$idempresa = (int)$_GET['emp'];
	//id del levantamiento
	$idlevantamiento = (int)$_GET['idlev'];
}else{
	//header( 'Location: notfound.html' ) ;
}

//saco info de la empresa
$queryempresa="SELECT * FROM empresas WHERE id = $idempresa";
$empresa = DBQueryReturnArray($queryempresa);	
if(count($empresa) == 0){
	//header( 'Location: notfound.html' );
}
$nombre = $empresa[0]['nombre'];
//saco info del levantamiento

$querylevantamiento = "SELECT * FROM levantamientos WHERE id = $idlevantamiento AND empresaid = $idempresa";
$levantamiento = DBQueryReturnArray($querylevantamiento);
if($levantamiento ==null){
	header( 'Location: notfound.html' ) ;
}

$levantamientoarray = json_decode($levantamiento[0]['formsactivos']);
$titulo = $levantamiento[0]['titulo'];
$info = $levantamiento[0]['info'];

//saco info de los formularios que están en el levantamiento
$in = "(";
foreach($levantamientoarray as $lev) {
	$in = $in.$lev.",";
}
$in = $in."-1)";
$queryformularios = "SELECT * FROM megatrees WHERE id IN $in";
$formularios = DBQueryReturnArray($queryformularios);

//saco info de los subformularios que están en los formularios que están en el levantamiento


?>
<!DOCTYPE html>
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

<div id="recorrer" data-role="page" >


	<div data-theme="b" data-display="overlay" data-position="right" data-role="panel" id="mypanel">
		<h2 id="usernamebutton"><?php echo $USER[0]['name']." ".$USER[0]['lastname'];?></h2>
		<a href="#" id="cerrarsesion"><?php echo get_string("logout", $lang)?></a> <br>
		<a href="#" id="usuarios"><?php echo get_string("config", $lang)?></a><br>
		<a href="#header" data-rel="close"><?php echo get_string("close", $lang)?></a>
    <!-- panel content goes here -->
	</div><!-- /panel -->

	<div data-role="header" data-theme="b">
	    <a href="#" id="backbutton2" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1 id ="empresanombre"><?php echo $nombre; ?>	</h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("config", $lang)?></a>
	</div>
	
	<div data-role="content">
		<h1><?php echo $titulo; ?></h1>
		<p><?php echo $info; ?></p>
		<div data-role="collapsible-set" data-theme="b" data-content-theme="d">
			<?php foreach($formularios as $key => $formulario) {
			
				//get all the subform
				$querysubformularios = "SELECT * FROM trees 
									WHERE released = 1 
									AND megatree = ".$formulario['id']." 
									AND (deleted = 0 OR 
											(deleted = 1 AND modified > '".$levantamiento[0]['created']."')); ";
				$subformularios = DBQueryReturnArray($querysubformularios);
				$total = count($subformularios);
			?>
			<div data-role="collapsible">
				<h2><?php echo $formulario['name']; ?></h2>
				<ul data-role="listview" data-theme="d" data-divider-theme="d">
					<li data-role="list-divider"><?php echo get_string("subforms", $lang)?><span class="ui-li-count"><?php echo $total; ?></span></li>
					<?php foreach($subformularios as $key2 => $subformulario) {
							if(getSubForm($subformulario['id'])){
								$questionandanswers = getQuestionAnswers($subformulario['id'], $idlevantamiento);
								extract($questionandanswers); //devuelve $pregunta, $respuestas $ultimavisita, $completitud
								if($pregunta == null){
									$pregunta = array("name"=>"se ha llegado al fin");
								}
								$class = "goto";
							}else{
								$pregunta['name'] = "Formulario incompleto, comuniquese con el administrador ";
								$ultimavisita = "nunca";
								$completitud = 0;
								$class = "dontgoto";
							}							
						?>
						<li class="<?php echo $class; ?>" data-subform="<?php echo $subformulario['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>"><a href="#">
				    		<h3><?php echo $subformulario['name']; ?></h3>
			                <p><strong><?php echo get_string("lastvisit", $lang)?>: <?php echo $ultimavisita; ?></strong></p>
			                <p><?php echo get_string("nextquestion", $lang)?>: <?php echo $pregunta['name']; ?></p>
			                <p class="ui-li-aside"><strong><?php echo get_string("completeness", $lang)?>: <?php echo $completitud; ?>%</strong></p>
		            	</a></li>
					<?php } ?>
		        </ul>
	    	</div>
		    	
			<?php } ?>
	</div>
	</div>
	
	
	
</div>
<script src="js/levantamiento.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>
