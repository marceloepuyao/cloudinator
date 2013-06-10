<?php
require_once('db.php');

echo '<center><br><h2>Instalacion de la base de datos</h2><br>';
echo '<hr>';
//borrar tablas si existen
echo '<h3>Borrando DB "cloudinator"</h3>';
try {
	DBquery3('DROP DATABASE cloudinator');
	echo 'Se ha borrado la database "cloudinator" exitosamente';
} catch (Exception $e) {
	echo 'Se intento borrar la database "cloudinator", pero probablemente no existia, ignore este error<br>';
	echo $e;
}
echo '<hr>';
//crear database "cloudinator"
echo '<h3>Creando DB "cloudinator"</h3>';
try {
	DBquery3('CREATE DATABASE cloudinator CHARACTER SET utf8 COLLATE utf8_general_ci');
	echo 'Base de datos "cloudinator" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear la base de datos "cloudinator", por favor creela manualmente<br>';
	echo $e;
}
echo '<hr>';
//crear tabla "nodos"
echo '<h3>Creando Tabla "nodos"</h3>';
try {
	DBquery4("CREATE TABLE nodos (
		id int(55) not null auto_increment primary key,
		tree int(55) NOT NULL,
		name varchar(55) NOT NULL,
		type varchar(20) NOT NULL,
		posx float(50) NOT NULL,
		posy float(50) NOT NULL,
		modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	");
	echo 'Tabla "nodos" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "nodos"<br>';
	echo $e;
}
echo '<hr>';
//crear tabla "links" id, name, source, target
echo '<h3>Creando Tabla "links"</h3>';
try {
	DBquery4("CREATE TABLE links (
		id int(55) not null auto_increment primary key,
		tree int(55) NOT NULL,
		name varchar(55),
		source varchar(20),
		target varchar(50),
		modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	");
	echo 'Tabla "links" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "links"<br>';
	echo $e;
}
echo '<hr>';
//crear tabla "trees" id, name, source, target
echo '<h3>Creando Tabla "trees"</h3>';
try {
	DBquery4("CREATE TABLE IF NOT EXISTS `trees` (
		`id` int(55) NOT NULL AUTO_INCREMENT,
		`name` varchar(55) NOT NULL,
		`deleted` tinyint(1) NOT NULL,
		`created` datetime NOT NULL,
		`modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	");
	echo 'Tabla "trees" creada exitosamente';
} catch (Exception $e) {
	echo 'Error al crear tabla "trees"<br>';
	echo $e;
}
echo '<hr><br>';
echo '<h2>La instalacion a finalizado</h2></center>';
?>