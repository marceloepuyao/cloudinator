<?php
require_once('db.php');

echo '<center><br><h2>Instalacion de datos</h2><br>';
echo '<hr>';
//borrar tablas si existen
echo '<h4>Creando datos en "nodes"</h3>';
try {
	DBquery3("INSERT INTO `cloudinator`.`nodos` (`id`, `name`, `type`, `posx`, `posy`) VALUES 
		(NULL, '¿Qué servicio desea probar sobre Cloud?', 'condition', 10, 200),
		(NULL, '¿Cómo se desea comunicar entre su POC y su Cloud?', 'condition', 500, 200),
		(NULL, '¿Qué tipo de conexión desea?', 'condition', 1000, 200),
		(NULL, '¿Cuentas IPs públicas?', 'condition', 1500, 200),
		(NULL, '¿Qué ancho de banda?', 'condition', 2000, 200),
		(NULL, 'Web', 'end', 250, 60),
		(NULL, 'App', 'end', 250, 130),
		(NULL, 'BBDD', 'end', 250, 200),
		(NULL, 'TS', 'end', 250, 270),
		(NULL, 'FServer', 'end', 250, 350);
		");
	echo 'Se han creado datos en "nodos" exitosamente';
} catch (Exception $e) {
	echo $e;
}
echo '<hr>';
echo '<h4>Creando datos en "links"</h3>';
try {
	DBquery3("INSERT INTO `cloudinator`.`links` (`id`, `name`, `source`, `target`) VALUES 
		(NULL, '', 1, 6),
		(NULL, '', 1, 7),
		(NULL, '', 1, 8),
		(NULL, '', 1, 9),
		(NULL, '', 1, 10);
		");
	echo 'Se han creado datos en "links" exitosamente';
} catch (Exception $e) {
	echo $e;
}
echo '<hr><br>';
echo '<h2>La instalacion a finalizado</h2></center>';
?>