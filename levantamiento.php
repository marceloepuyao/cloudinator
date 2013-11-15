<?php
	require_once('DB/db.php');
	require_once('lib.php');
if(isset($_GET['emp'])){
	$idempresa = (int)$_GET['emp'];
}else{
	header( 'Location: notfound.html' );
}

	
//sacar info de la empresa, si no existe se manda a not found
$queryempresa="SELECT * FROM empresas WHERE id = $idempresa";

$empresa = DBQueryReturnArray($queryempresa);	


$nombre = $empresa[0]['nombre'];
$info = $empresa[0]['infolevantamiento'];


$querylevantamientos = "SELECT * FROM levantamientos WHERE empresaid = $idempresa";
$levantamientos = DBQueryReturnArray($querylevantamientos);

$queryusers = "SELECT * FROM users";
$users = DBQueryReturnArray($queryusers);

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
		<h2 id="usernamebutton"></h2>
		<a href="#" id="cerrarsesion">Cerrar Sesión</a> <br>
		<a href="#" id="usuarios">Usuarios</a><br>
		<a href="#header" data-rel="close">Cerrar</a>
    <!-- panel content goes here -->
	</div><!-- /panel -->

	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#" id="backbutton" data-icon="arrow-l">Atrás</a>
	    <h1 id ="empresanombre"><?php echo $nombre; ?>	</h1>
	    <a href="#mypanel" data-icon="bars">config</a>
	</div>
	
	
	<div class="container">
		<h4>Información de la empresa</h4>
		<p id="infoempresa" > <?php echo $info; ?></p>
		<br>
		<?php if($levantamientos){?>
		
		<h4 >Historial de levantamientos</h4>
		
		<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
		     <thead>
		       <tr>
		       	<th>Título Visita</th>
		         <th data-priority="2">Última Modificación</th>
		         <th data-priority="3"><abbr title="Info">Información</abbr></th>
		         <th>Recorrer</th>
		          <th data-priority="5">Borrar</th>
		          <th data-priority="6">Editar</th>
		       </tr>
		     </thead>
		     <tbody>
		      	<?php foreach($levantamientos as $key => $levantamiento) { ?>
			    	<tr>
			    	<td><?php echo $levantamiento['titulo']; ?></td>
			         <td><?php echo $levantamiento['modified'].' (Hace '.floor((time()-strtotime($levantamiento['modified']))/(60*60*24)).' Días.)';?></td>
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
		    <a id="tonew" href="#new" data-role="button">Empezar Nuevo Levantamiento</a>
		</div>
	</div>
</div>
<div id="new" data-role="page" >
	<div data-role="header" data-theme="b">
	    <a href="#levantamiento" id="back" data-icon="arrow-l">Atrás</a>
	    <h1 id ="empresanombre2"><?php echo $nombre; ?>	</h1>
	    <a href="#" id="usernamebutton" data-icon="check" class="ui-btn-right"></a>
	</div><!-- /header -->
	
	<div data-role="content" class="container"> 
		<h2>Nuevo Levantamiento</h2>
		    <ul data-role="listview" data-inset="true">
		        <li data-role="fieldcontain">
		            <label for="titulo-levantamiento">Título Levantamiento:</label>
		            <input name="titulo-levantamiento" id="titulo-levantamiento" value="" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="info-levantamiento">Información de Levantamiento:</label>
 					<textarea cols="40" rows="8" name="info-levantamiento" id="info-levantamiento"></textarea>		        
 				</li>

		        <li data-role="fieldcontain">
		        	<label for="contactado-por" class="select">Contactado por:</label> 
		        	<select name="contactado-por" id="contactado-por">
		        	<option value=""><?php ?></option>
		        	<?php foreach($users as $key => $user) { ?>
						<option value="<?php echo $user['id']?>"><?php echo $user['email']?></option>
					<?php }?>
				</select>
				</li>
		        
		        
		        <li data-role="fieldcontain">
		            <label for="area-contacto">Área de Contacto:</label>
		            <input name="area-contacto" id="area-contacto" value="" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="formularios">Formularios:</label>
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
		                    <div class="ui-block-a"><button id="cancel" data-theme="d">Cancelar</button></div>
		                    <div class="ui-block-b"><button id="addlevantamiento"  data-theme="b">Continuar</button></div>
		            </fieldset>
		        </li>
		    </ul>
		
	</div><!-- /content -->
</div>
<script src="js/levantamiento.js" type="text/javascript"></script>
<script src="js/jquery.session.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>