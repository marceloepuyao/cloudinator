<?php
require_once('db.php');

echo '<a href="../index.html">Volver</a>';
echo '<center><br><h2>Upgrade Base de datos</h2><br>';

echo '<hr>';
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

		echo 'Se ha creado la tabla cloudinator_upgrades';
		
		$version = 2013082600;
	}
}catch (Exception $e){
	echo "Error en actualización<br>$e<br>";
}
echo '</hr>';
echo '<hr>';
if($version < 2013082700){
	try{
		//aqui se escribe el código
		DBQuery("INSERT INTO `users` (`id`, `email`, `name`, `lastname`, `password`, `firstaccess` , `lastaccess`, `lang`, `modified`) VALUES 
			(NULL, 'admin', 'Sr', 'Admin', 'pepito.P0', '".time()."', '".time()."' , 'es', '".time()."'  );
			");
		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013082700' WHERE id = 1");
		
		//dejo mensaje
		echo 'Se ha agregado un usuario para el navegador cloudinator';
		
	}catch (Exception $e){
		echo "Error en actualización<br>$e<br>";
	}
}
echo '</hr>';
echo '<hr>';
if($version <  2013092300){
	try{
		//acá escribo el script de actualización

		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013092300' WHERE id = 1");
		
		//dejo mensaje
		echo 'Prueba de actualización';
		
	}catch (Exception $e){
		echo "Error en actualización<br>$e<br>";
	}
}
echo '</hr>';
echo '<hr>';
if($version <  2013092401){
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
		
		//dejo mensaje
		echo 'Tabla levantamientos creada exitósamente';
		
	}catch (Exception $e){
		echo "Error en actualización<br>$e<br>";
	}
}
echo '</hr>';
echo '<hr>';
if($version <  2013093000){
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
		
		//dejo mensaje
		echo 'Creada tabla registropreguntas';
		
	}catch (Exception $e){
		echo "Error en actualización<br>$e<br>";
	}
}
echo '</hr>';
echo '<hr>';
if ($version < 2013102000) {
	try {
		//acá escribo el script de actualización
		DBQuery("ALTER TABLE  `nodos` CHANGE  `name`  `name` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = '2013102000' WHERE id = 1");

		//dejo mensaje
		echo 'Modificación a la cantidad de caracteres posibles en la tabla "nodos", columna "name", de 50 caracteres aumentó a 200';
		
	} catch (Exception $e) {
		echo 'Error en actualización<br>$e<br>';
	}
}
echo '</hr>';
/*
//EJEMPLO: (RECUERDE CAMBIAR "AAAAMMDDNN" POR EL NUMERO DE ACTUALIZACION A = Año, M = Mes, D = Dia, N = Numero)
echo '<hr>';
if ($version < AAAAMMDDNN) {
	try {
		//acá escribo el script de actualización

		//actualiazo la versión
		DBQuery("UPDATE cloudinator_upgrades SET version = 'AAAAMMDDNN' WHERE id = 1");

		//dejo mensaje
		echo 'RESUMEN DE LOS CAMBIOS REALIZADOS';
		
	} catch (Exception $e) {
		echo 'Error en actualización<br>$e<br>';
	}
}
echo '</hr>';
*/

echo '<hr>';
echo "Todos los cambios han sido realizados";
echo '</hr></center>';
echo '<br><br><a href="../index.html">Volver</a>';
?>