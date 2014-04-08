
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cloudinator - Actualización</title>
</head>
<body>
<?php

echo '<a href="../editor/">Volver</a>';
echo '<center><br><h2>Actualización de la Base de Datos</h2><br>';

//si existe la tabla cloudinator saco la version de ahí si no la setteo 
try {
	$query = 'SELECT * FROM cloudinator_upgrades';
	$datos = Yii::app()->db->createCommand($query)->queryRow();
	$version = $datos['version'];
}catch (Exception $e){
	Yii::app()->db->createCommand("CREATE TABLE cloudinator_upgrades (
		id int(100) not null auto_increment primary key,
		name varchar(50) NOT NULL,
		version varchar(25) NOT NULL,
		modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP) 
		ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;")->execute();
	Yii::app()->db->createCommand("INSERT INTO `cloudinator_upgrades` (`id`, `name`, `version`, `modified`) VALUES 
	(NULL, 'cloudinator', '2013082600', '".time()."');
	")->execute();
	echo '<hr>';
	echo 'Se ha creado la tabla cloudinator_upgrades';
	echo '</hr>';

	$version = 2013082600;
}

if($version < 2013082700){
	echo '<hr>';
	echo '<h4>Actualización N° 2013-08-27-00</h4>';
	try{
		//aqui se escribe el código
		Yii::app()->db->createCommand("INSERT INTO `users` (`id`, `email`, `name`, `lastname`, `password`, `firstaccess` , `lastaccess`, `lang`, `modified`) VALUES 
			(NULL, 'admin', 'Sr', 'Admin', '".crypt('pepito.P0')."', '".time()."', '".time()."' , 'es', '".time()."'  )
			")->execute();;
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013082700' WHERE id = 1")->execute();
		
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
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013092300' WHERE id = 1")->execute();
		
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
		Yii::app()->db->createCommand("CREATE TABLE levantamientos (
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
		")->execute();
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013092401' WHERE id = 1")->execute();
		
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
		Yii::app()->db->createCommand("CREATE TABLE registropreguntas (
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
		")->execute();
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013093000' WHERE id = 1")->execute();
		
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
		Yii::app()->db->createCommand("ALTER TABLE  `nodos` CHANGE  `name`  `name` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL")->execute();

		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013102000' WHERE id = 1")->execute();

		//mensaje:
		echo 'Modificación a la cantidad de caracteres posibles en la tabla "nodos", columna "name", de 50 caracteres aumentó a 200';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}


if ($version < 2013102000) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-10-20-01</h4>';
	try {
		//acá escribo el script de actualización
		Yii::app()->db->createCommand("ALTER TABLE  `levantamientos` CHANGE  `titulo`  `titulo` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
		CHANGE  `info`  `info` VARCHAR( 500 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
		CHANGE  `formsactivos`  `formsactivos` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
		CHANGE  `conctadopor`  `conctadopor` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
		CHANGE  `areacontacto`  `areacontacto` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
		CHANGE  `completitud`  `completitud` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL")->execute();

		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013102000' WHERE id = 1")->execute();

		//mensaje:
		echo 'Modificación a la cantidad de caracteres posibles en la tabla "levantamientos", columnas: "titulo", "info", "formsactivos", "conctadopor", "areacontacto" y "completitud"';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}

if ($version < 2013102900) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-10-29-00</h4>';
	try {
		//acá escribo el script de actualización
		Yii::app()->db->createCommand("ALTER TABLE levantamientos
		ADD deleted tinyint(1) NOT NULL")->execute();
		
		Yii::app()->db->createCommand("ALTER TABLE registropreguntas
		ADD respsubpregunta VARCHAR( 500 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL")->execute();
				
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013102900' WHERE id = 1")->execute();

		//mensaje:
		echo 'Agregado campo para guardar respuesta de subpregunta en los registros y campo para saber si está eliminado en levantamientos';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}

if ($version < 2013110300) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-11-03-00</h4>';
	try {
		//acá escribo el script de actualización
		Yii::app()->db->createCommand("ALTER TABLE trees ADD released tinyint(1) NOT NULL DEFAULT 0")->execute();
		Yii::app()->db->createCommand("ALTER TABLE megatrees ADD visible tinyint(1) NOT NULL DEFAULT 0")->execute();
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013110300' WHERE id = 1")->execute();

		//mensaje:
		echo 'Se agregó el campo "released" y "visible" para la implementación de la caracteristica de los Formularios "publicados"';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}

if ($version < 2013111700) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-11-17-00</h4>';
	try {
		//acá escribo el script de actualización
		Yii::app()->db->createCommand("ALTER TABLE users ADD superuser tinyint(1) NOT NULL DEFAULT 0")->execute();
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013111700' WHERE id = 1")->execute();

		//mensaje:
		echo 'Se agrega columna superuser a tabla users ';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}
if ($version < 2013112200) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-11-22-00</h4>';
	try {
		Yii::app()->db->createCommand("UPDATE users SET superuser = 1")->execute();

		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013112200' WHERE id = 1")->execute();

		//mensaje:
		echo 'Admin con capacidad de superusuario';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}
if ($version < 2013112500) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-11-25-00</h4>';
	try {
		Yii::app()->db->createCommand("UPDATE users SET password = '".crypt("pepito.P0")."' WHERE email = 'admin'")->execute();

		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013112500' WHERE id = 1")->execute();

		//mensaje:
		echo 'Encriptación de contraseñas';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}
if ($version < 2013121800) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-12-18-00</h4>';
	try {
		//cambio nombre columna
		Yii::app()->db->createCommand("ALTER TABLE empresas CHANGE infolevantamiento info char(50);")->execute();
		//borro columna contactado y areacontacto
		Yii::app()->db->createCommand("ALTER TABLE empresas DROP COLUMN contactado")->execute();
		Yii::app()->db->createCommand("ALTER TABLE empresas DROP COLUMN areacontacto")->execute();
		
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013121800' WHERE id = 1")->execute();

		//mensaje:
		echo 'Actualización nombres de columnas tabla empresas';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}

if ($version < 2013121900) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-12-19-00</h4>';
	try {
		//acá escribo el script de actualización
		Yii::app()->db->createCommand("ALTER TABLE empresas CHANGE info info VARCHAR(500);")->execute();
		Yii::app()->db->createCommand("ALTER TABLE empresas CHANGE nombre nombre VARCHAR(500);")->execute();
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013121900' WHERE id = 1")->execute();

		//mensaje:
		echo 'Más capacidad de carácteres para columnas tabla empresas';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}
if ($version < 2013122700) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-12-27-00</h4>';
	try {
		//acá escribo el script de actualización
		Yii::app()->db->createCommand("CREATE TABLE cloned (
		id int(100) not null auto_increment primary key,
		idlev int(50) NOT NULL,
		name varchar(50) NOT NULL,
		subformid int(50) NOT NULL,
		modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	")->execute();
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013122700' WHERE id = 1")->execute();

		//mensaje:
		echo 'Creado tabla para guardar información de respuestas de subformularios clonados';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}

if ($version < 2013122701) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-12-27-01</h4>';
	try {
		//acá escribo el script de actualización
		Yii::app()->db->createCommand("ALTER TABLE registropreguntas ADD clonedid int(50) NULL")->execute();
		Yii::app()->db->createCommand("ALTER TABLE registropreguntas MODIFY COLUMN subformid int(100) NULL")->execute();
		
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013122701' WHERE id = 1")->execute();

		//mensaje:
		echo 'Modificación de registro de respuestas para que lea subformularios clonados';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}
if ($version < 2013122702) {
	echo '<hr>';
	echo '<h4>Actualización N° 2013-12-27-02</h4>';
	try {
		//acá escribo el script de actualización
		Yii::app()->db->createCommand("ALTER TABLE cloned ADD formid int(50) NULL")->execute();
		
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2013122702' WHERE id = 1")->execute();

		//mensaje:
		echo 'Modificación tabla cloned';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}
if ($version < 2014012200) {
	echo '<hr>';
	echo '<h4>Actualización N° 2014-01-22-00</h4>';
	try {
		//acá escribo el script de actualización
		$levantamientos = Yii::app()->db->createCommand("SELECT * FROM levantamientos")->queryAll();
		foreach ($levantamientos as $levantamiento){
			$formsactivos = str_replace(array("[", "]", "\""), "",  $levantamiento['formsactivos']  );
			Yii::app()->db->createCommand("UPDATE levantamientos SET formsactivos = '$formsactivos' WHERE id = ".$levantamiento['id'])->execute();
		}
		
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2014012200' WHERE id = 1")->execute();

		//mensaje:
		echo 'cambio forma de guardar formularios activos en los levantamientos';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}
if ($version < 2014012400) {
	echo '<hr>';
	echo '<h4>Actualización N° 2014-01-24-00</h4>';
	try {
		//acá escribo el script de actualización
		$empresas = Yii::app()->db->createCommand("SELECT * FROM empresas")->queryAll();
		foreach ($empresas as $empresa){
			$industria =  $empresa['industria'];
			
			 $industria = str_replace(
		        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		        $industria
		    );
		
		    $industria = str_replace(
		        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		        $industria
		    );
		
		    $industria = str_replace(
		        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		        $industria
		    );
		
		    $industria = str_replace(
		        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
		        $industria
		    );
		
		    $industria = str_replace(
		        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		        $industria
		    );
		    
		    $industria=str_replace("Ã±","ñ",$industria);
			$industria=str_replace("Ã¡","a",$industria);
			$industria=str_replace("Ã©","e",$industria);
			$industria=str_replace("Ã‘","Ñ",$industria);
			$industria=str_replace("Ã³","o",$industria);
			$industria=str_replace("Ã­","i",$industria);
			$industria=str_replace("Ãº","u",$industria);
			
			
			Yii::app()->db->createCommand("UPDATE empresas SET industria = '$industria' WHERE id = ".$empresa['id'])->execute();
		}
		
		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2014012400' WHERE id = 1")->execute();

		//mensaje:
		echo 'eliminados caracteres extraños de la base de datos';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}

if ($version < 2014012700) {
	echo '<hr>';
	echo '<h4>Actualización N° 2014-01-27-00</h4>';
	try {
		//acá escribo el script de actualización

		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2014012700' WHERE id = 1")->execute();

		//mensaje:
		echo 'Prueba de Actualalización con Yii Framework';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}

if ($version < 2014012701) {
	echo '<hr>';
	echo '<h4>Actualización N° 2014-01-27-01</h4>';
	try {
		//acá escribo el script de actualización

		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2014012701' WHERE id = 1")->execute();

		//mensaje:
		echo 'Prueba de Actualalización II con Yii Framework';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}
if ($version < 2014040800) {
	echo '<hr>';
	echo '<h4>Actualización N° 2014-04-08-00</h4>';
	try {
		//acá escribo el script de actualización
		$levantamientos = Yii::app()->db->createCommand("SELECT * FROM levantamientos")->queryAll();
		foreach ($levantamientos as $lv){
			$array = explode(",", $lv['formsactivos']);
			Yii::app()->db->createCommand("UPDATE levantamientos SET formsactivos = '".serialize($array)."' WHERE id = ".$lv['id'])->execute();
			
		}

		//actualiazo la versión
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = '2014040800' WHERE id = 1")->execute();

		//mensaje:
		echo 'formactivos de leventamientos serializado';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
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
		Yii::app()->db->createCommand("UPDATE cloudinator_upgrades SET version = 'AAAAMMDDNN' WHERE id = 1")->execute();

		//mensaje:
		echo 'RESUMEN DE LOS CAMBIOS REALIZADOS';
		
	} catch (Exception $e) {
		echo "Error en actualización<br>$e<br>";
	}
	echo '</hr>';
}

*/

echo '<hr>';
echo "<h3>Fin de la actualización</h3>";
echo '</hr></center>';
echo '<br><br><a href="../editor/">Volver</a>';
?>
</body>



