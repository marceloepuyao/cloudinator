<?php
//gestion de empresas
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

//si no es admin -> fuera
if(!$USER[0]['superuser']){
	header( 'Location: notfound.html' );
}

//vemos que la URL este la variable emp
if(isset($_GET['emp'])){
	$idempresa = (int)$_GET['emp'];
}else{
	$idempresa = 0;
}
//si se da id específico de empresa se muestra tabla de edición, sino se obtienen todas las empresas.
if($idempresa){
	$empresaedit = DBQueryReturnArray("SELECT * FROM empresas WHERE id = $idempresa");
	
}else{
	$empresas = DBQueryReturnArray("SELECT * FROM empresas");
}


//desplegar tabla 


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
<title>Gestión de Empresas</title>
</head>
<body class="api jquery-mobile home blog single-autho">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	
<div data-role="page" id="empresas">

	<?php echo print_panel($USER,$lang);?>

	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#" id="backbutton" data-icon="arrow-l"><?php echo get_string("back", $lang)?></a>
	    <h1><?php echo "Gestión de Empresas"; ?>	</h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("config", $lang)?></a>
	</div>
	<div class="container">
		<?php if($idempresa){?>
			
		<?php }else{?>
			<h2><?php echo "Lista de Empresas" ?>	</h2>

			<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
			     <thead>
			       <tr>
			       	<th><?php echo "Nombre"; ?></th>
			       	<th><?php echo "Industria"; ?></th>
			         <th ><?php echo "Contactado Por"?></th>
			         <th data-priority="4"><abbr title="Info"><?php echo "Información Adicional"; ?></abbr></th>
			         <th data-priority="5"><abbr title="Info"><?php echo "Área de Contacto";?></abbr></th>
			          <th data-priority="7"><?php echo get_string("delete", $lang); ?></th>
			          <th data-priority="8"><?php echo get_string("edit", $lang); ?></th>
			       </tr>
			     </thead>
			     <tbody>
			      	<?php 
			      	
			      	foreach($empresas as $key => $empresa) { ?>
				    	<tr>
				    	<td><?php echo $empresa['nombre']; ?></td>
				         <td><?php echo $empresa['industria']; ?></td>
				         <td><?php echo $empresa['contactado']; ?></td>
				         <td><?php echo substr($empresa['infolevantamiento'],0,45)."..."; ?></td>
				         <td><?php echo $empresa['areacontacto']; ?></td>
				         <td><a class="deletecompany" data-idcompany="<?php echo $empresa['id']; ?>" href="#"><i class="fa fa-trash-o"></i></a></td>
				         <td><a class="editcompany" data-idcompany="<?php echo $empresa['id']; ?>" href="#"><i class="fa fa-pencil"></i></a></td>
				       </tr>
					<?php } ?>		       
			     </tbody>
			   </table>
		<?php }?>
	</div>
</div>
<script src="js/levantamiento.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>
