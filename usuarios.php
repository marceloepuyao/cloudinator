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

if($USER[0]['superuser'] == 1){
	$queryusuarios = "SELECT * FROM users";
}else{
	$queryusuarios = "SELECT * FROM users WHERE email = '".$USER[0]['email']."';";
}
$usuarios = DBQueryReturnArray($queryusuarios);

//vemos si estamos editando o ingresando un usuario nuevo
if(isset($_GET['edit'])){
	$iduseredit = (int)$_GET['edit'];
	$usertoedit = DBQueryReturnArray("SELECT * FROM users WHERE id = $iduseredit");
}else{
	$iduseredit = 0;
}


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
	
	<?php echo print_panel($USER,$lang);?>

	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#" id="backbutton" data-icon="arrow-l"><?php echo get_string("back", $lang);?></a>
	    <h1><?php echo get_string("users", $lang); ?>	</h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("config", $lang);?></a>
	</div>

	
	<div data-role="content" class="container"> 
		<h2><?php echo get_string("userslist", $lang); ?>	</h2>

		<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
		     <thead>
		       <tr>
		       	<th><?php echo get_string("firstname", $lang); ?></th>
		       	<th><?php echo get_string("lastname", $lang); ?></th>
		         <th ><?php echo get_string("email", $lang) ?></th>
		         <th data-priority="4"><abbr title="Info"><?php echo get_string("lastaccess", $lang); ?></abbr></th>
		         <th data-priority="5"><abbr title="Info"><?php echo get_string("language", $lang); ?></abbr></th>
		         <th data-priority="6"><?php echo get_string("superuser", $lang); ?></th>
		         <?php if($USER[0]['superuser']==1){?>
		          <th data-priority="7"><?php echo get_string("delete", $lang); ?></th>
		          <th data-priority="8"><?php echo get_string("edit", $lang); ?></th>
		          <?php }?>
		       </tr>
		     </thead>
		     <tbody>
		      	<?php 
		      	
		      	foreach($usuarios as $key => $usuario) { ?>
			    	<tr>
			    	<td><?php echo $usuario['name']; ?></td>
			         <td><?php echo $usuario['lastname']; ?></td>
			         <td><?php echo $usuario['email']; ?></td>
			         <td><?php echo $usuario['lastaccess']; ?></td>
			         <td><?php echo $usuario['lang']; ?></td>
			         <td><?php echo $usuario['superuser']==1?"SI":"NO"; ?></td>
			         <?php if($USER[0]['superuser']){?>
			         <td><a class="deleteuser" data-iduser="<?php echo $usuario['id']; ?>" href="#"><i class="fa fa-trash-o"></i></a></td>
			         <td><a class="edituser" data-iduser="<?php echo $usuario['id']; ?>" href="#"><i class="fa fa-pencil"></i></a></td>
			       	<?php }?>
			       </tr>
				<?php } ?>		       
		     </tbody>
		   </table>

		<?php if($USER[0]['superuser']){?>
		<div data-role="controlgroup">
		    <a href="#" id="tonewuser" data-role="button"><?php echo get_string("addnewuser", $lang); ?></a>
		</div>
		<?php } ?>
	</div><!-- /content -->
</div>
<div id="newuser" data-role="page" >

	<?php echo print_panel($USER,$lang);?>

	<div data-role="header" class="header" data-position="fixed" role="banner" data-theme="b">
	    <a href="#users"  data-icon="arrow-l"><?php echo get_string("back", $lang);?></a>
	    <h1><?php echo get_string("users", $lang); ?></h1>
	    <a href="#mypanel" data-icon="bars"><?php echo get_string("config", $lang);?></a>
	</div>

	<div data-role="content" class="container"> 
		<h2><?php echo $iduseredit!=0?$usertoedit[0]["name"]." ".$usertoedit[0]["lastname"]:get_string("addnewuser", $lang);?></h2>
		    <ul data-role="listview" data-inset="true">
		        <li data-role="fieldcontain">
		            <label for="nombres"><?php echo get_string("firstname", $lang); ?></label>
		            <input name="nombres" id="nombres" value="<?php echo $iduseredit!=0?$usertoedit[0]["name"]:"";?>" data-clear-btn="true" type="text">
		        </li>
		        <li data-role="fieldcontain">
		            <label for="apellidos"><?php echo get_string("lastname", $lang); ?></label>
 					<input name="apellidos" id="apellidos" value="<?php echo $iduseredit!=0?$usertoedit[0]["lastname"]:"";?>" data-clear-btn="true" type="text">	        
 				</li>
 				
 				<li data-role="fieldcontain">
		            <label for="email-empresarial"><?php echo get_string("email", $lang); ?></label>
 					<input name="email-empresarial" id="email-empresarial" value="<?php echo $iduseredit!=0?$usertoedit[0]["email"]:"";?>" data-clear-btn="true" type="text">		        
 				</li>
 				
 				<li data-role="fieldcontain">
		            <label for="password"><?php echo $iduseredit!=0?get_string('newpass', $lang):get_string("password", $lang); ?></label>
 					<input name="password" id="password" value="<?php echo $iduseredit!=0?"nochange":"";?>" data-clear-btn="true" type="password">		        
 				</li>
 				
 				<li data-role="fieldcontain">
		            <label for="repassword"><?php echo get_string("repeatpassword", $lang); ?></label>
 					<input name="repassword" id="repassword" value="<?php echo $iduseredit!=0?"nochange":"";?>" data-clear-btn="true" type="password">		        
 				</li>
 				

		        <li data-role="fieldcontain">
		        	<label for="idioma" class="select"><?php echo get_string("language", $lang); ?></label> 
		        	<select name="idioma" id="idioma">
			        	<option value="es"  <?php echo $iduseredit!=0?$usertoedit[0]["lang"]=="es"?"selected":"":"";?>>Español</option>
			        	<option value="pt" <?php echo $iduseredit!=0?$usertoedit[0]["lang"]=="pt"?"selected":"":"";?>>Português</option>
			        	<option value="en" <?php echo $iduseredit!=0?$usertoedit[0]["lang"]=="en"?"selected":"":"";?>>English</option>
					</select>
				</li>
				
				<li data-role="fieldcontain">
				    <label for="superuser"><?php echo get_string("superuser", $lang); ?>:</label>
				    <select name="superuser" id="superuser">
				        <option value=0 <?php echo $iduseredit!=0?$usertoedit[0]["superuser"]==0?"selected":"":"";?>>No</option>
				        <option value=1 <?php echo $iduseredit!=0?$usertoedit[0]["superuser"]==1?"selected":"":"";?>>Si</option>
				    </select>
				</li>
				
				<li class="ui-body ui-body-b">
		            <fieldset class="ui-grid-a">
		                    <div class="ui-block-a"><a href="#users"><button id="canceluser" data-theme="d"><?php echo get_string("cancel", $lang); ?></button></a></div>
		                    <div class="ui-block-b"><button id="acceptnewuser"  data-editto="<?php echo $iduseredit!=0?$usertoedit[0]["id"]:0;?>" data-theme="b">Continuar</button></div>
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