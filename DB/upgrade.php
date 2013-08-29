<?php

require_once('../JSON.php');
require_once('db.php');

echo '<a href="../index.html">Volver</a>';
echo '<center><br><h2>Upgrade Base de datos</h2><br>';

//si existe la tabla cloudinator saco la version de ahí si no la setteo 
try{
	try{
		$query = 'SELECT * FROM cloudinator';
		$datos = DBQuery($query);
		$version = mysql_result($datos, 0, 'cloudinator.version');
	}catch(Exception $e){
		DBQuery("	CREATE TABLE cloudinator (
					id int(100) not null auto_increment primary key,
					name varchar(50) NOT NULL,
					version varchar(25) NOT NULL,
					modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP) 
					ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		");

		DBQuery("INSERT INTO `cloudinator`.`cloudinator` (`id`, `name`, `version`, `modified`) VALUES 
			(NULL, 'cloudinator', '2013082600', '".time()."');
			");
		echo '<hr>';
		echo 'Se ha creado base tabla cloudinator';
		echo '</hr>';
		
		$version = 2013082600;
	}
}catch (Exception $e){
	echo "Error en actualización<br>";
}


if($version < 2013082700){
	try{
		//aqui se escribe el código
		DBQuery("INSERT INTO `cloudinator`.`users` (`id`, `email`, `name`, `lastname`, `password`, `firstaccess` , `lastaccess`, `lang`, `modified`) VALUES 
			(NULL, 'admin', 'Sr', 'Admin', 'pepito.P0', '".time()."', '".time()."' , 'es', '".time()."'  );
			");
		//actualiazo la versión
		DBQuery("UPDATE cloudinator SET version = '2013082700' WHERE id = 1");
		
		echo '<hr>';
		echo 'Se ha agregado un usuario para el navegador cloudinator';
		echo '</hr>';
		
	}catch (Exception $e){
		echo "Error en actualización<br>";
	}
}

if($version <  2013082701){
	try{
		//acá escribo el script de actualización
		
		//actualiazo la versión
		DBQuery("UPDATE cloudinator SET version = '2013082701' WHERE id = 1");
		
		//dejo mensaje
		echo '<hr>';
		echo 'prueba de actualización';
		echo '</hr>';
		
	}catch (Exception $e){
		echo "Error en actualización<br>";
	}
}

echo '<hr>';
echo "Todos los cambios han sido realizados";
echo '</hr></center>';
echo '<br><br><a href="../index.html">Volver</a>';