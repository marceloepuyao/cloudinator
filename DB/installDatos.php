<?php
require_once('db.php');
echo '<a href="../index.html">Volver</a>';
echo '<center><br><h2>Instalacion de datos</h2><br>';
echo '<hr>';
//borrar tablas si existen
echo '<h4>Creando datos en "nodes"</h3>';
try {
	DBQuery("INSERT INTO `nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`, `metaname`, `metadata`, `metatype`) VALUES 
		(NULL, 1, '¿Qué servicio desea probar sobre Cloud?', 'condition', 10, 200, null, null, null),
		(NULL, 1, '¿Cómo se desea comunicar entre su POC y su Cloud?', 'condition', 500, 200, null, null, null),
		(NULL, 1, '¿Qué tipo de conexión desea?', 'condition', 1000, 200, null, null, null),
		(NULL, 1, '¿Cuentas IPs públicas?', 'condition', 1500, 200, null, null, null),
		(NULL, 1, '¿Qué ancho de banda?', 'condition', 2000, 200, null, null, null),
		(NULL, 1, 'Web', 'end', 250, 60, null, null, null),
		(NULL, 1, 'App', 'end', 250, 130, null, null, null),
		(NULL, 1, 'BBDD', 'end', 250, 200, null, null, null),
		(NULL, 1, 'TS', 'end', 250, 270, null, null, null),
		(NULL, 1, 'FServer', 'end', 250, 350, null, null, null);
		");
	echo 'Se han creado datos en "nodos" exitosamente';
} catch (Exception $e) {
	echo $e;
}
echo '<hr>';
echo '<h4>Creando datos en "links"</h3>';
try {
	DBQuery("INSERT INTO `links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
		(NULL, 1, '', 1, 6),
		(NULL, 1, '', 1, 7),
		(NULL, 1, '', 1, 8),
		(NULL, 1, '', 1, 9),
		(NULL, 1, '', 1, 10);
		");
	echo 'Se han creado datos en "links" exitosamente';
} catch (Exception $e) {
	echo $e;
}
echo '<hr>';
echo '<h4>Creando datos en "trees"</h3>';
try {
	DBQuery("INSERT INTO `trees` (`id`, `name`, `deleted`, `created`) VALUES 
		(NULL, 'POC', 0, '".date("Y-m-d H:i:s")."'),
		(NULL, 'ej. grafo 1', 0, '".date("Y-m-d H:i:s")."'),
		(NULL, 'ej. grafo 2', 0, '".date("Y-m-d H:i:s")."'),
		(NULL, 'ej. grafo 3', 0, '".date("Y-m-d H:i:s")."'),
		(NULL, 'ej. grafo 4', 0, '".date("Y-m-d H:i:s")."');
		");
	echo 'Se han creado datos en "trees" exitosamente';
} catch (Exception $e) {
	echo $e;
}
echo '<hr><br>';
echo '<h2>La instalacion a finalizado</h2></center>';
echo '<a href="../index.html">Volver</a>';
?>