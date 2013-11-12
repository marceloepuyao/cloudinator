﻿<?php
require_once('DB/db.php');
require_once('lib.php');

//TODO: Comprobar si se es superusuario

$queryusuarios = "SELECT * FROM users";
$usuarios = DBQueryReturnArray($queryusuarios);


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
<title>Usuarios</title>
</head>
<body class="api jquery-mobile home blog single-autho">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	
<div id="users" data-role="page" >
	<div data-theme="b" data-display="overlay" data-position="right" data-role="panel" id="mypanel">
		<h2 id="usernamebutton"></h2>
		<a href="#" id="cerrarsesion">Cerrar Sesión</a> <br>
		<a href="#" id="usuarios">Usuarios</a><br>
		<a href="#header" data-rel="close">Cerrar</a>
    <!-- panel content goes here -->
	</div><!-- /panel -->

	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#" id="backbutton" data-icon="arrow-l">Atrás</a>
	    <h1>Usuarios</h1>
	    <a href="#mypanel" data-icon="bars">config</a>
	</div>
	
	<div data-role="content" class="container"> 
		<h2>Lista de Usuarios</h2>

		<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
		     <thead>
		       <tr>
		       	<th>Nombre</th>
		       	<th>Apellidos</th>
		         <th >email</th>
		         <th data-priority="4"><abbr title="Info">Último Acceso</abbr></th>
		         <th data-priority="5"><abbr title="Info">Idioma</abbr></th>
		          <th data-priority="6">Borrar</th>
		          <th data-priority="7">Editar</th>
		       </tr>
		     </thead>
		     <tbody>
		      	<?php foreach($usuarios as $key => $usuario) { ?>
			    	<tr>
			    	<td><?php echo $usuario['name']; ?></td>
			         <td><?php echo $usuario['lastname']; ?></td>
			         <td><?php echo $usuario['email']; ?></td>
			         <td><?php echo $usuario['lastaccess']; ?></td>
			         <td><?php echo $usuario['lang']; ?></td>
			         <td><a class="deletuser" data-iduser="<?php echo $usuario['id']; ?>" href="#"><i class="fa fa-trash-o"></i></a></td>
			         <td><a class="edituser" data-iduser="<?php echo $usuario['id']; ?>" href="#"><i class="fa fa-pencil"></i></a></td>
			       </tr>
				<?php } ?>		       
		     </tbody>
		   </table>


		<div data-role="controlgroup">
		    <a href="#newuser" data-role="button">Agregar nuevo usuario</a>
		</div>
	</div><!-- /content -->
</div>
<div id="newuser" data-role="page" >

	<div data-theme="b" data-display="overlay" data-position="right" data-role="panel" id="mypanel">
		<h2 id="usernamebutton"></h2>
		<a href="#" id="cerrarsesion">Cerrar Sesión</a> <br>
		<a href="#" id="usuarios">Usuarios</a><br>
		<a href="#header" data-rel="close">Cerrar</a>
    <!-- panel content goes here -->
	</div><!-- /panel -->

	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#users"  data-icon="arrow-l">Atrás</a>
	    <h1>Usuarios</h1>
	    <a href="#mypanel" data-icon="bars">config</a>
	</div>
	


	<div data-role="content" class="container"> 
		<h2>Nuevo Usuario</h2>
		    <ul data-role="listview" data-inset="true">
		        <li data-role="fieldcontain">
		            <label for="nombres">Nombres</label>
		            <input name="nombres" id="nombres" value="" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="apellidos">Apellidos</label>
 					<input name="apellidos" id="apellidos" value="" data-clear-btn="true" type="text">	        
 				</li>
 				
 				<li data-role="fieldcontain">
		            <label for="email-empresarial">Email Empresarial</label>
 					<input name="email-empresarial" id="email-empresarial" value="" data-clear-btn="true" type="text">		        
 				</li>
 				
 				<li data-role="fieldcontain">
		            <label for="password">Contraseña</label>
 					<input name="password" id="password" value="" data-clear-btn="true" type="password">		        
 				</li>
 				

		        <li data-role="fieldcontain">
		        	<label for="idioma" class="select">Idioma</label> 
		        	<select name="idioma" id="idioma">
		        	<option value="es">es</option>
		        	<option value="br">br</option>
		        	<option value="en">en</option>
				</select>
				</li>
				
				<li class="ui-body ui-body-b">
		            <fieldset class="ui-grid-a">
		                    <div class="ui-block-a"><a href="#users"><button id="canceluser" data-theme="d">Cancelar</button></a></div>
		                    <div class="ui-block-b"><button data-theme="b">Continuar</button></div>
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