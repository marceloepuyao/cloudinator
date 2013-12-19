<?php
require_once('DB/db.php');
require_once('lib.php');
session_start();
//checkiamos si las sessions están settiadas
if(checkSession($_SESSION['ultimoacceso'], $_SESSION['usuario'], $_SESSION['idioma'])){
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
	header( 'Location: notfound.html' ) ;
}

$modeedit = 0;
$modeedittext = get_string('editmode', $lang);
if(isset($_GET['edit'])){
	if($_GET['edit'] == 1){
		$modeedit = 1;
		$modeedittext = get_string('exiteditmode', $lang);
	}
}

//saco info de la empresa
$queryempresa="SELECT * FROM empresas WHERE id = $idempresa";
$empresa = DBQueryReturnArray($queryempresa);	
if(count($empresa) == 0){
	//header( 'Location: notfound.html' );
}
$nombre = $empresa[0]['nombre'];
//saco info del levantamiento
$levantamiento = getLevantamientobyId($idlevantamiento);
if($levantamiento ==null){
	header( 'Location: notfound.html' ) ;
}

$levantamientoarray = json_decode($levantamiento['formsactivos']);
$titulo = $levantamiento['titulo'];
$info = $levantamiento['info'];

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
<title>Formularios</title>
</head>
<body>

<div id="recorrer" data-role="page" >

	<?php echo print_panel($USER,$lang, 1, $modeedittext);?>
	
	<div data-role="header" data-theme="b">
	    <a href="#" class ="backtoLevantamieto" data-idemp="<?php echo $empresa[0]['id'];?>" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1 id ="empresanombre"><?php echo $nombre; ?>	</h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("options", $lang)?></a>
	</div>
	<div data-role="content">
	<!-- pop up dialogo -->
		<h1><?php echo $titulo; ?></h1>
		<p><?php echo $info; ?></p>
		<div data-role="collapsible-set" data-theme="b" data-content-theme="d" >
			<?php foreach($formularios as $key => $formulario) {

				//get all the subform
				$subformularios = getSubFormsbyFormId($formulario['id'], $levantamiento['created']);
				$total = count($subformularios);
				$datacollapsed = "";
				if(isset($_GET['idform'])){
					if($_GET['idform'] == $formulario['id']){
						$datacollapsed = 'data-collapsed="false"';
					}
				}
				
			?>
			<div data-role="collapsible" <?php echo $datacollapsed;?>>
				<h2><?php echo $formulario['name'];?></h2> 
				<ul data-role="listview" data-theme="d"  data-divider-theme="d">
					<li data-role="list-divider"><?php echo get_string("subforms", $lang);?><span class="ui-li-count"><?php echo $total; ?></span></li>
					<?php foreach($subformularios as $key2 => $subformulario) {
							if(getSubForm($subformulario['id'])){
								$questionandanswers = getQuestionAnswers($subformulario['id'], $idlevantamiento);
								extract($questionandanswers); //devuelve $pregunta, $respuestas $ultimavisita, $completitud
								if($pregunta == null){
									$pregunta = array("name"=>get_string('endreached', $lang));
								}
								$class = "goto";
								$class2 = "goto";
							}else{
								$pregunta['name'] = get_string('incompleteform', $lang);
								$ultimavisita = "nunca";
								$completitud = 0;
								$class = "dontgoto";
								$class2 = "dontgoto";
							}
							if($modeedit == 1){
								$class = "dontgoto";
							}
							
						?>
						<li class="<?php echo $class; ?>" data-subform="<?php echo $subformulario['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>">
							<a href="#popupMenu" data-rel="popup"  data-inline="true" data-transition="slideup" data-icon="gear" data-theme="e">
					    		<h3><?php echo $subformulario['name']; ?> </h3>
				                <p><strong><?php echo get_string("lastvisit", $lang)?>: <?php echo $ultimavisita; ?></strong></p>
				                <p><?php echo get_string("nextquestion", $lang)?>: <?php echo $pregunta['name']; ?></p>
				                <p class="ui-li-aside"><strong><?php echo get_string("completeness", $lang)?>: <?php echo $completitud; ?>%</strong></p>
			            	</a>
		            	</li>
		            	<?php if($modeedit == 1){?>
						    <div data-role="popup" id="popupMenu" data-theme="d">
						        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d">
						            <li><a class="<?php echo $class2;?>" data-subform="<?php echo $subformulario['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>" href="#">Ir</a></li>
						            <li><a href="#">Clonar</a></li>
						            <li><a class="deleteanswers" data-subform="<?php echo $subformulario['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>" href="#">Borrar Respuestas</a></li>
						            <li><a href="#"><?php echo get_string("delete", $lang)?></a></li>
						        </ul>
							</div>	
		            	
		            	
					<?php }} ?>
		        </ul>
	    	</div>
	    	
			<?php } ?>
			
			
			<div data-role="controlgroup">
		    <a id="report" href="#report" data-role="button"><?php echo get_string('reports', $lang)?></a>
			</div>
			
	</div>
	
	</div>
	
	
	
</div>

<div id="report" data-role="page" >
	<div data-theme="b" data-display="overlay" data-position="right" data-role="panel" id="mypanel">
		<h2 id="usernamebutton"><?php echo $USER[0]['name']." ".$USER[0]['lastname'];?></h2>
		<a href="#" id="cerrarsesion"><?php echo get_string("logout", $lang)?></a> <br>
		<a href="#" id="usuarios"><?php echo get_string("options", $lang)?></a><br>
		<a href="#header" data-rel="close"><?php echo get_string("close", $lang)?></a>
    <!-- panel content goes here -->
	</div><!-- /panel -->

	<div data-role="header" data-theme="b">
	    <a href="#recorrer" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1 id ="empresanombre"><?php echo $nombre; ?>	</h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("config", $lang)?></a>
	</div>
	
	<div data-role="content">
		<h1>Reporte Levantamiento : <?php echo $levantamiento['titulo'];?></h1>
		
		<?php foreach ($formularios as $form){ 
				
			
			$subformularios = getSubFormsbyFormId($form['id'], $levantamiento['created']);
			?>
			
			<?php foreach($subformularios as $subformulario) {?>
				<h3><?php echo $form['name']."-".$subformulario['name'];?></h3>
				<?php 
				
				$tablaresumen = getResumenSubform($subformulario['id'], $idlevantamiento);

				?> 
				<table data-role="table" id="movie-table" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive">
			         <thead>
			           <tr class="ui-bar-d">
			             <th>Pregunta</th>
			             <th>Respuesta</th>
			             <th> Subrespuesta</th>
			             <th>Fecha</th>
			           </tr>
			         </thead>
			         <tbody>
			         <?php foreach ($tablaresumen as $preguntas){?>
			         
			           <tr>
			             <th><?php echo getContentByNodeId($preguntas['preguntaid']); ?></th>
			             <td><?php echo getContentByNodeId($preguntas['respuestaid']); ?></td>
			             <td><?php echo $preguntas['respsubpregunta']; ?></td>
			             <td><?php echo $preguntas['created']; ?></td>
			           </tr>
			           
			        <?php $lastregistro = $preguntas['id'];}?>
			           
			         </tbody>
		       </table>
				<?php 	
			}	
		}?>
	</div>

</div>

<script src="js/levantamiento.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>
