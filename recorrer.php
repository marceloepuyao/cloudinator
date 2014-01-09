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


//si no existen error
if(isset($_GET['idlev'])){
	//id del levantamiento
	$idlevantamiento = (int)$_GET['idlev'];
}else{
	header( 'Location: notfound.html' ) ;
}

$modeedit = 0;
$modeedittext = get_string('editmode', $lang);
if(isset($_SESSION['edit'])){
	if($_SESSION['edit'] == 1){
		$modeedit = 1;
		$modeedittext = get_string('exiteditmode', $lang);
	}else{
		$modeedit = 0;
	}
}


//saco info del levantamiento
$levantamiento = getLevantamientobyId($idlevantamiento);
if($levantamiento ==null){
	header( 'Location: notfound.html' ) ;
}

//saco info de la empresa
$idempresa = $levantamiento['empresaid'];
$queryempresa="SELECT * FROM empresas WHERE id = $idempresa";
$empresa = DBQueryReturnArray($queryempresa);	
if(count($empresa) == 0){
	header( 'Location: notfound.html' );
}
$nombre = $empresa[0]['nombre'];

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
	    <a href="#" class ="backtoLevantamiento" data-idemp="<?php echo $empresa[0]['id'];?>" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1 id ="empresanombre"><?php echo $nombre; ?>	</h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("options", $lang)?></a>
	</div>
	
	<div data-role="content">
	<?php echo print_navbar(0, $empresa[0]['id'], $idlevantamiento, 0, 0, $lang);?>
	<!-- pop up dialogo -->
		<h1><?php echo $titulo; ?></h1>
		<p><?php echo $info; ?></p>
		<div data-role="collapsible-set" data-theme="b" data-content-theme="d" >
			<?php foreach($formularios as $key => $formulario) {

				//get all the subform
				$subformularios = getSubFormsbyFormId($formulario['id'], $levantamiento['created']);
				$subformcloned = getClonedSubFormByFormId($formulario['id'], $levantamiento['id']);
				$total = count($subformularios) + count($subformcloned);
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
									$completitud = "100%";
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
						<li class="<?php echo $class; ?>" data-idclone="<?php echo 0; ?>"  data-subform="<?php echo $subformulario['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>">
							<a href="#popupMenu<?php echo $subformulario['id'];?>" data-rel="popup"  data-inline="true" data-transition="slideup" data-icon="gear" data-theme="e">
					    		<h3><?php echo $subformulario['name']; ?> </h3>
				                <p><strong><?php echo get_string("lastvisit", $lang)?>: <?php echo $ultimavisita; ?></strong></p>
				                <p><?php echo get_string("nextquestion", $lang)?>: <?php echo $pregunta['name']; ?></p>
				                <p class="ui-li-aside"><strong><?php echo get_string("completeness", $lang)?>: <?php echo $completitud; ?></strong></p>
			            	</a>
		            	</li>
		            	<?php if($modeedit == 1){?>
						    <div data-role="popup" id="popupMenu<?php echo $subformulario['id'];?>" data-theme="d">
						        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d">
						            <li><a class="<?php echo $class2;?>" data-subform="<?php echo $subformulario['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>" href="#"><?php echo get_string('gothrough', $lang);?></a></li>
						            <li><a class="cloneanswers" data-oldname="<?php echo $subformulario['name'];?>" data-idform="<?php echo $subformulario['megatree'];?>" data-subform="<?php echo $subformulario['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>" href="#"><?php echo get_string('clonesubform', $lang);?></a></li>
						            <li><a class="deleteanswers" data-idclone="<?php echo 0;?>" data-idform="<?php echo $subformulario['megatree'];?>" data-idsubform="<?php echo $subformulario['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>" href="#"><?php echo get_string("deleteanswers", $lang);?></a></li>
						        </ul>
							</div>	
					<?php }} ?>
					
					
					
					
					<?php //Acá van los clonados 
					foreach($subformcloned as $key2 => $subclone) {
							if(getSubForm($subclone['subformid'])){
								$questionandanswers = getQuestionAnswers($subclone['subformid'], $idlevantamiento, $subclone['id']);
								extract($questionandanswers); //devuelve $pregunta, $respuestas $ultimavisita, $completitud
								if($pregunta == null){
									$pregunta = array("name"=>get_string('endreached', $lang));
									$completitud = "100%";
								}
								$class = "gotoclone";
								$class2 = "goto";
							}else{
								$pregunta['name'] = get_string('incompleteform', $lang);
								$ultimavisita = "nunca";
								$completitud = 0;
								$class = "dontgoto";
								$class2 = "dontgoto";
							}
							if($modeedit == 1){
								$class = "dontgotoclone";
							}
							
						?>
						<li class="<?php echo $class; ?>" data-cloneid="<?php echo $subclone['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>">
							<a href="#popupMenuClone<?php echo $subclone['id'];?>" data-rel="popup"  data-inline="true" data-transition="slideup" data-icon="gear" data-theme="e">
					    		<h3><?php echo $subclone['name']; ?> </h3>
				                <p><strong><?php echo get_string("lastvisit", $lang)?>: <?php echo $ultimavisita; ?></strong></p>
				                <p><?php echo get_string("nextquestion", $lang)?>: <?php echo $pregunta['name']; ?></p>
				                <p class="ui-li-aside"><strong><?php echo get_string("completeness", $lang)?>: <?php echo $completitud; ?></strong></p>
			            	</a>
		            	</li>
		            	<?php if($modeedit == 1){?>
						    <div data-role="popup" id="popupMenuClone<?php echo $subclone['id'];?>" data-theme="d">
						        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d">
						            <li><a class="<?php echo $class2;?>" data-idclone="<?php echo $subclone['id']; ?>" data-subform="<?php echo 0; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>" href="#"><?php echo get_string('gothrough', $lang);?></a></li>
						            <li><a class="deleteanswers"  data-idform="<?php echo $subclone['formid'];?>" data-idsubform="<?php echo 0; ?>" data-idclone="<?php echo $subclone['id']; ?>" data-levantamiento="<?php echo $idlevantamiento; ?>" href="#"><?php echo get_string('deleteanswers', $lang);?></a></li>
						            <li><a class="deleteclone" data-idform="<?php echo $subclone['formid'];?>"  data-levantamiento="<?php echo $idlevantamiento; ?>" data-idclone="<?php echo $subclone['id']; ?>"><?php echo get_string("delete", $lang);?></a></li>
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
	<?php echo print_panel($USER,$lang, 1, $modeedittext);?>

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
				
				$tablaresumen = getResumenSubform($subformulario['id'], $idlevantamiento, 0);
				
				if(count($tablaresumen)>0){

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
				}else{
					echo "Subformulario no respondido";	
				}
			}	
			
			$cloneds = getClonedSubFormByFormId($form['id'], $levantamiento['id']);
			foreach($cloneds as $clone) {
				//$form = getSubFormByCloneId($clone['id']);
										
				echo "<h3 > Clonado: ".$form['name']."-".$subformulario['name']."</h3>";
			
				
				$tablaresumen = getResumenSubform($subformulario['id'], $idlevantamiento, $clone['id']);
				
				if(count($tablaresumen)>0){

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
				}else{
					echo "Subformulario no respondido";	
				}
			}	
			
			
			
			
			
			
			
		}?>
	</div>

</div>

<script src="js/levantamiento.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>
