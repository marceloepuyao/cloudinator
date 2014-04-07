<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cloudinator - Instalación</title>
</head>
<body>
<?php
$config = parse_ini_file(Yii::app()->basePath."/config/config.ini" , true);
$connconf = $config["mysql"];

echo '<a href="../editor.php">Volver</a>';
echo '<center><br><h2>Instalacion de la base de datos</h2><br>';
echo '<hr>';
//borrar tablas si existen
echo '<h3>Borrando DB "'.$connconf['mysql_database'].'"</h3>';
try {
	Yii::app()->db->createCommand('DROP DATABASE '.$connconf['mysql_database'])->execute();
	echo 'Se ha borrado la database "'.$connconf['mysql_database'].'" exitosamente';
} catch (Exception $e) {
	echo 'Se intento borrar la database "'.$connconf['mysql_database'].'", si esta es su primera instalacion ignore este error<br>';
	echo $e;
}
echo '<hr>';
//crear database "cloudinator"
echo '<h3>Creando DB "'.$connconf['mysql_database'].'"</h3>';
try {
	Yii::app()->db->createCommand('CREATE DATABASE '.$connconf['mysql_database'].' CHARACTER SET utf8 COLLATE utf8_general_ci')->execute();
	echo 'Base de datos "'.$connconf['mysql_database'].'" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear la base de datos "'.$connconf['mysql_database'].'", por favor creela manualmente<br>';
	echo $e;
}
echo '<hr>';
//crear tabla "nodos"
echo '<h3>Creando Tabla "nodos"</h3>';
try {
	Yii::app()->db->createCommand("CREATE TABLE nodos (
		id int(100) not null auto_increment primary key,
		tree int(50) NOT NULL,
		name varchar(50) NOT NULL,
		type varchar(25) NOT NULL,
		posx float(50) NOT NULL,
		posy float(50) NOT NULL,
		metaname varchar(50),
		metadata varchar(400),
		metatype varchar(25),
		modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	")->execute();
	echo 'Tabla "nodos" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "nodos"<br>';
	echo $e;
}
echo '<hr>';
//crear tabla "links" id, name, source, target
echo '<h3>Creando Tabla "links"</h3>';
try {
	Yii::app()->db->createCommand("CREATE TABLE links (
		id int(100) not null auto_increment primary key,
		tree int(50) NOT NULL,
		name varchar(50),
		source varchar(50),
		target varchar(50),
		modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	")->execute();
	echo 'Tabla "links" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "links"<br>';
	echo $e;
}
echo '<hr>';
//crear tabla "trees" id, name, source, target
echo '<h3>Creando Tabla "trees"</h3>';
try {
	Yii::app()->db->createCommand("CREATE TABLE IF NOT EXISTS `trees` (
		`id` int(100) NOT NULL AUTO_INCREMENT ,
		`name` varchar(50) NOT NULL,
		`megatree` int(100) NOT NULL,
		`deleted` tinyint(1) NOT NULL,
		`created` datetime NOT NULL,
		`modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	")->execute();
	echo 'Tabla "trees" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "trees"<br>';
	echo $e;
}
echo '<hr>';
//crear tabla "megatrees" id, name, source, target
echo '<h3>Creando Tabla "megatrees"</h3>';
try {
	Yii::app()->db->createCommand("CREATE TABLE IF NOT EXISTS `megatrees` (
		`id` int(100) NOT NULL AUTO_INCREMENT,
		`name` varchar(50) NOT NULL,
		`chain` varchar(1000),
		`deleted` tinyint(1) NOT NULL,
		`created` datetime NOT NULL,
		`modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	")->execute();
	echo 'Tabla "megatrees" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "megatrees"<br>';
	echo $e;
}
echo '<hr>';
//crear tabla "users"
echo '<h3>Creando Tabla "users"</h3>';
try {
	Yii::app()->db->createCommand("CREATE TABLE IF NOT EXISTS `users` (
		`id` int(100) NOT NULL AUTO_INCREMENT,
		`email` varchar(50) NOT NULL,
		`name` varchar(50),
		`lastname` varchar(50),
		`password` varchar(50),
		`firstaccess` datetime NOT NULL,
		`lastaccess` datetime NOT NULL,
		`lang` varchar(50),
		`modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	")->execute();
	echo 'Tabla "users" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "users"<br>';
	echo $e;
}
echo '<hr>';
//Crear tabla "empresas"
echo '<h3>Creando Tabla "empresas"</h3>';
try {
	Yii::app()->db->createCommand("CREATE TABLE IF NOT EXISTS `empresas` (
		`id` int(100) NOT NULL AUTO_INCREMENT,
		`nombre` varchar(50) NOT NULL,
		`industria` varchar(50),
		`contactado` varchar(50),
		`areacontacto` varchar(50),
		`infolevantamiento` varchar(5000),
		`modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	")->execute();
	echo 'Tabla "empresas" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "empresas"<br>';
	echo $e;
}
echo '<hr>';
echo '<h3>La instalacion a finalizado</h3>';
echo '<h2>Si la instalación fue exitosa, por favor instale las actualizaciones: <a href="upgrade.php">Instalar Actualizaciones</a></h2>';
echo '</center>';


echo '<a href="../editor.php">Volver</a>';
?>
</body>