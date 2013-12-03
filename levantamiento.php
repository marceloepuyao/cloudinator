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

//vemos que la URL este la variable emp
if(isset($_GET['emp'])){
	$idempresa = (int)$_GET['emp'];
}else{
	header( 'Location: notfound.html' );
}

//sacamos la info de la empresa, si no existe se manda a not found
$queryempresa="SELECT * FROM empresas WHERE id = $idempresa";
$empresa = DBQueryReturnArray($queryempresa);	
if(count($empresa) == 0){
	header( 'Location: notfound.html' );
}
$nombre = $empresa[0]['nombre'];
$info = $empresa[0]['infolevantamiento'];


//obtenemos los levantamientos de la empresa
$querylevantamientos = "SELECT * FROM levantamientos WHERE empresaid = $idempresa";
$levantamientos = DBQueryReturnArray($querylevantamientos);

//obtenemos la lista de todos los usuarios.
$queryusers = "SELECT * FROM users";
$users = DBQueryReturnArray($queryusers);

//obtenemos todos los formularios
$formularios = getAllFormularios();

?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
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
<title>Nuevo Levantamiento</title>
</head>
<body class="api jquery-mobile home blog single-autho">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	
<div data-role="page" id="levantamiento">

	<div data-theme="b" data-display="overlay" data-position="right" data-role="panel" id="mypanel">
		<h2><?php echo $USER[0]['name']." ".$USER[0]['lastname'];?></h2>
		<a href="#" id="cerrarsesion"><?php echo get_string("logout", $lang)?></a> <br>
		<a href="#" id="usuarios"><?php echo get_string("config", $lang)?></a><br>
		<a href="#header" data-rel="close"><?php echo get_string("close", $lang)?></a>
    <!-- panel content goes here -->
	</div><!-- /panel -->

	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#" id="backbutton" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1 id ="empresanombre"><?php echo $nombre; ?>	</h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("config", $lang)?></a>
	</div>
	
	
	<div class="container">
		<h4><?php echo get_string("infocompany", $lang); ?></h4>

		<p id="infoempresa" > <?php echo $info; ?></p>
		<br>
		<?php if($levantamientos){?>
		
		<h4 ><?php echo get_string("recordlevantamientos", $lang)?></h4>
		
		<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
		     <thead>
		       <tr>	       
		       	<th><?php echo get_string("titlevisit", $lang)?></th>
		         <th data-priority="2"><?php echo get_string("lastmod", $lang)?></th>
		         <th data-priority="3"><abbr title="Info"><?php echo get_string("info", $lang)?></abbr></th>
		         <th><?php echo get_string("gothrough", $lang)?></th>
		          <th data-priority="5"><?php echo get_string("delete", $lang)?></th>
		          <th data-priority="6"><?php echo get_string("edit", $lang)?></th>
		       </tr>
		     </thead>
		     <tbody>
		      	<?php foreach($levantamientos as $key => $levantamiento) { ?>
			    	<tr>
			    	<td><?php echo $levantamiento['titulo']; ?></td>
			         <td><?php echo $levantamiento['modified'].' ('.floor((time()-strtotime($levantamiento['modified']))/(60*60*24)).' '.get_string('daysago', $lang).')';?></td>
			         <td><?php echo $levantamiento['info']; ?></td>
			         <td><a class="ira" data-empresa="<?php echo $idempresa; ?>" data-levantamiento="<?php echo $levantamiento['id']; ?>" href="#"><i class="fa fa-play"></i></a></td>
			         <td><a class="delete" data-levantamiento="<?php echo $levantamiento['id']; ?>" href="#"><i class="fa fa-trash-o"></i></a></td>
			         <td><a class="edit" data-id="<?php echo $levantamiento['id']; ?>" href="#"><i class="fa fa-pencil"></i></a></td>
			       </tr>
				<?php } ?>		       
		     </tbody>
		   </table>
		   
		   <?php }?>
		<br><br>
		<div data-role="controlgroup">
		    <a id="tonew" href="#new" data-role="button"><?php echo get_string("newlevantamiento", $lang)?></a>
		</div>
	</div>
</div>
<div id="new" data-role="page" >



	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#" id="backbutton2" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1 id ="empresanombre2"><?php echo $nombre; ?>	</h1>
	    
	</div>


	<div data-role="content" class="container"> 
		<h2><?php echo get_string("newlevantamiento", $lang)?></h2>
		    <ul data-role="listview" data-inset="true">
		        <li data-role="fieldcontain">
		            <label for="titulo-levantamiento"><?php echo get_string("titlevisit", $lang)?>:</label>
		            <input name="titulo-levantamiento" id="titulo-levantamiento" value="" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="info-levantamiento"><?php echo get_string("info", $lang)?>:</label>
 					<textarea cols="40" rows="8" name="info-levantamiento" id="info-levantamiento"></textarea>		        
 				</li>

		        <li data-role="fieldcontain">
		        	<label for="contactado-por" class="select"><?php echo get_string("contactedby", $lang)?>:</label> 
		        	<select name="contactado-por" id="contactado-por">
		        	<option value=""><?php ?></option>
		        	<?php foreach($users as $key => $user) { ?>
						<option value="<?php echo $user['id']?>"><?php echo $user['email']?></option>
					<?php }?>
				</select>
				</li>
		        
		        
		        <li data-role="fieldcontain">
		            <label for="area-contacto"><?php echo get_string("contactedarea", $lang)?>:</label>
		            <input name="area-contacto" id="area-contacto" value="" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="formularios"><?php echo get_string("forms", $lang)?>:</label>
		            	<fieldset data-role="controlgroup" id="formularios">
		            	<?php foreach($formularios as $key => $formulario) { 
		            			if($formulario['visible']== 1 ){?>
		            		
					    	<input name="<?php echo $formulario['id']; ?>" id="<?php echo $formulario['id']; ?>" checked="" type="checkbox">
					    	<label for="<?php echo $formulario['id']; ?>"><?php echo $formulario['name']; ?></label>
						<?php }} ?>
					</fieldset>  
		            <input id="formularios" type="hidden" value="My data"/>
		                      
		        </li>
		        <li class="ui-body ui-body-b">
		            <fieldset class="ui-grid-a">
		                    <div class="ui-block-a"><button id="cancel" data-theme="d"><?php echo get_string("cancel", $lang)?></button></div>
		                    <div class="ui-block-b"><button id="addlevantamiento"  data-theme="b"><?php echo get_string("continue", $lang)?></button></div>
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