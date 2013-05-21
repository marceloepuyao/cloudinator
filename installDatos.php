<?php
require_once('db.php');

echo '<center><br><h2>Instalacion de datos</h2><br>';
echo '<hr>';
//borrar tablas si existen
echo '<h4>Creando datos en "nodes"</h3>';
try {
	DBquery3("INSERT INTO `cloudinator`.`nodos` (`id`, `name`, `type`, `posx`, `posy`) VALUES (NULL, 'pregunta 1', 'pregunta', '10', '10'), (NULL, 'respuesta 1', 'respuesta', '30', '30');");
	echo 'Se han creado datos en "nodos" exitosamente';
} catch (Exception $e) {
	echo $e;
}
echo '<hr>';
echo '<h4>Creando datos en "links"</h3>';
try {
	DBquery3("INSERT INTO `cloudinator`.`links` (`id`, `name`, `source`, `target`) VALUES (NULL, NULL, '1', '2');");
	echo 'Se han creado datos en "links" exitosamente';
} catch (Exception $e) {
	echo $e;
}
echo '<hr><br>';
echo '<h2>La instalacion a finalizado</h2></center>';
?>