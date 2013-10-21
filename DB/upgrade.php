<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cloudinator - Actualización</title>
</head>
<body>
<?php
require_once('db.php');

echo '<a href="../editor.html">Volver</a>';
echo '<center><br><h2>Actualización de la Base de Datos</h2><br>';

//si existe la tabla cloudinator saco la version de ahí si no la setteo 
try{
	try{
		$query = 'SELECT * FROM cloudinator_upgrades';
		$datos = DBQuery($query);
		$aux = $datos->fetch_assoc();
		$version = $aux['version'];
	}catch(Exception $e){
		DBQuery("CREATE TABLE cloudinator_upgrades (
				id int(100) not null auto_increment primary key,
				name varchar(50) NOT NULL,
				version varchar(25) NOT NULL,
				modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP) 
				ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		");

		DBQuery("INSERT INTO `cloudinator_upgrades` (`id`, `name`, `version`, `modified`) VALUES 
			(NULL, 'cloudinator', '2013082600', '".time()."');
			");

		echo '<hr>';
		echo 'Se ha creado la tabla cloudinator_upgrades';
		echo '</hr>';

		$version = 2013082600;
	}
}catch (Exception $e){
	echo '<hr>';
	echo "Error en actualización<br>$e<br>";
	echo '</hr>';
}


if($version < 2013082700){
	echo '<hr>';
	echo '<h4>Actualización N° 2013-08-27-00</h4>';
	try{
		//aqui se escribe el código
		DBQuery("INSERT INTO `users` (`id`, `email`, `name`, `lastname`, `password`, `firstaccess` , `lastaccess`, `lang`, `modified`) VALUES 
			(NULL, 'admin', 'Sr', 'Admin', 'pepito.P0', '".time()."', '".time()."' , 'es', '".time()."'  );
			");
		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013082700' WHERE id = 1");
		
		//mensaje:
		echo 'Se ha agregado un usuario para el navegador cloudinator';
		
	}catch (Exception $e){
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}


if($version <  2013092300){
	echo '<hr>';
	echo '<h4>Actualización N° 2013-09-23-00</h4>';
	try{
		//acá escribo el script de actualización

		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013092300' WHERE id = 1");
		
		//mensaje:
		echo 'Prueba de actualización';
		
	}catch (Exception $e){
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}


if($version <  2013092401){
	echo '<hr>';
	echo '<h4>Actualización N° 2013-09-24-01</h4>';
	try{
		//acá escribo el script de actualización
		DBQuery("CREATE TABLE levantamientos (
				id int(100) not null auto_increment primary key,
				titulo varchar(50) NOT NULL,
				empresaid int(50) NOT NULL,
				info varchar(25),
				formsactivos varchar(25) NOT NULL,
				conctadopor varchar(25),
				areacontacto varchar(25),
				completitud varchar(25),
				created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP) 
				ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		");
		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013092401' WHERE id = 1");
		
		//mensaje:
		echo 'Tabla levantamientos creada exitósamente';
		
	}catch (Exception $e){
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}


if($version <  2013093000){
	echo '<hr>';
	echo '<h4>Actualización N° 2013-09-30-00</h4>';
	try{
		//acá escribo el script de actualización
		DBQuery("CREATE TABLE registropreguntas (
				id int(100) not null auto_increment primary key,
				preguntaid int(100) NOT NULL,
				respuestaid int(100) NOT NULL,
				subformid int(100) NOT NULL,
				formid int(100),
				levantamientoid int(100) NOT NULL,
				userid int(100) NOT NULL,
				empresaid int(100) NOT NULL,
				created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP) 
				ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		");
		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013093000' WHERE id = 1");
		
		//mensaje:
		echo 'Creada tabla registropreguntas';
		
	}catch (Exception $e){
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}


if ($version < 2013102000) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-10-20-00</h4>';
	try {
		//acá escribo el script de actualización
		DBQuery("ALTER TABLE  `nodos` CHANGE  `name`  `name` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013102000' WHERE id = 1");

		//mensaje:
		echo 'Modificación a la cantidad de caracteres posibles en la tabla "nodos", columna "name", de 50 caracteres aumentó a 200';
		
	} catch (Exception $e) {
		echo 'Error en actualización<br>$e<br>';
	}
	echo '</hr>';
}


if ($version < 2013102001) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-10-20-01</h4>';
	try {
		//acá escribo el script de actualización
		DBQuery("ALTER TABLE  `levantamientos` CHANGE  `titulo`  `titulo` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
		CHANGE  `info`  `info` VARCHAR( 500 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
		CHANGE  `formsactivos`  `formsactivos` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
		CHANGE  `conctadopor`  `conctadopor` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
		CHANGE  `areacontacto`  `areacontacto` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
		CHANGE  `completitud`  `completitud` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");

		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013102000' WHERE id = 1");

		//mensaje:
		echo 'Modificación a la cantidad de caracteres posibles en la tabla "levantamientos", columnas: "titulo", "info", "formsactivos", "conctadopor", "areacontacto" y "completitud"';
		
	} catch (Exception $e) {
		echo 'Error en actualización<br>$e<br>';
	}
	echo '</hr>';
}


/*
//EJEMPLO: (RECUERDE CAMBIAR "AAAAMMDDNN" POR EL NUMERO DE ACTUALIZACION A = Año, M = Mes, D = Dia, N = Numero)

if ($version < AAAAMMDDNN) {
	echo '<hr>';
	echo '<h4>Actualización N° AAAA-MM-DD-NN</h4>';
	try {
		//acá escribo el script de actualización

		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = 'AAAAMMDDNN' WHERE id = 1");

		//mensaje:
		echo 'RESUMEN DE LOS CAMBIOS REALIZADOS';
		
	} catch (Exception $e) {
		echo 'Error en actualización<br>$e<br>';
	}
	echo '</hr>';
}

*/

echo '<hr>';
echo "<h3>Fin de la actualización</h3>";
echo '</hr></center>';
echo '<br><br><a href="../editor.html">Volver</a>';
?>
</body>