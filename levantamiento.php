<?php
require_once('db/db.php');

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

$queryformularios = "SELECT * FROM megatrees";
$formularios = DBQueryReturnArray($queryformularios);

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

<div data-role="page" id="levantamiento">
	<div data-role="header" data-theme="b">
	    <a href="#" id="backbutton" data-icon="arrow-l">atrás</a>
	    <h1 id ="empresanombre"><?php echo $nombre; ?>	</h1>
	    <a href="#" id="usernamebutton" data-icon="check" class="ui-btn-right"></a>
	</div>
	<h4>información de la empresa</h4>
	<p id="infoempresa" > <?php echo $info; ?></p>
	<br>
	<h4>Historial de levantamientos</h4>
	
	<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
	     <thead>
	       <tr>
	       	<th>Título Visita</th>
	         <th data-priority="2">Fecha</th>
	         <th data-priority="3"><abbr title="Rotten Tomato Rating">Completitud</abbr></th>
	         <th>Recorrer</th>
	          <th data-priority="5">Borrar</th>
	          <th data-priority="6">Editar</th>
	       </tr>
	     </thead>
	     <tbody>
	      	<?php foreach($levantamientos as $key => $levantamiento) { ?>
		    	<tr>
		    	<td><?php echo $levantamiento['titulo']; ?></td>
		         <td><?php echo $levantamiento['created']; ?></td>
		         <td><?php echo $levantamiento['completitud']; ?>%</td>
		         <td><a class="ira" data-empresa="<?php echo $idempresa; ?>" data-levantamiento="<?php echo $levantamiento['id']; ?>" href="#">ir</a></td>
		         <td><a class="delete" data-id="1" href="#">X</a></td>
		         <td><a class="delete" data-id="1" href="#">editar</a></td>
		       </tr>
			<?php } ?>
	       
	     </tbody>
	   </table>
	<br><br>
	<div data-role="controlgroup">
	    <a id="tonew" href="#new" data-role="button">Empezar Nuevo Levantamiento</a>
	</div>

</div>
<div id="new" data-role="page" >
	<div data-role="header" data-theme="b">
	    <a href="#levantamiento" id="back" data-icon="arrow-l">atrás</a>
	    <h1 id ="empresanombre2"><?php echo $nombre; ?>	</h1>
	    <a href="#" id="usernamebutton" data-icon="check" class="ui-btn-right"></a>
	</div><!-- /header -->
	
	<div data-role="content">
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
		            <label for="contactado-por">Contactado por:</label>
		            <input name="contactado-por" id="contactado-por" value="" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="area-contacto">Área de Contacto:</label>
		            <input name="area-contacto" id="area-contacto" value="" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="formularios">Formularios:</label>
		            	<fieldset data-role="controlgroup" id="formularios">
		            	<?php foreach($formularios as $key => $formulario) { ?>
					    	<input name="<?php echo $formulario['id']; ?>" id="<?php echo $formulario['id']; ?>" checked="" type="checkbox">
					    	<label for="<?php echo $formulario['id']; ?>"><?php echo $formulario['name']; ?></label>
						<?php } ?>
					</fieldset>  
		            <input id="formularios" type="hidden" value="My data"/>
		                      
		        </li>
		        <li class="ui-body ui-body-b">
		            <fieldset class="ui-grid-a">
		                    <div class="ui-block-a"><button id="cancel" data-theme="d">Cancelar</button></div>
		                    <div class="ui-block-b"><button id="addlevantamiento" data-theme="b">Continuar</button></div>
		            </fieldset>
		        </li>
		    </ul>
		
	</div><!-- /content -->
</div>

<script src="js/levantamiento.js" type="text/javascript"></script>
<script src="js/jquery.session.js" type="text/javascript"></script>
</body>
</html>