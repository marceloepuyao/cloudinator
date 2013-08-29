<?php
// if data are received via POST, with index of 'test'
/*
if (isset($_POST['test'])) {
    $str = $_POST['test'];             // get data
    echo "The string: '<i>".$str."</i>' contains ". strlen($str). ' characters and '. str_word_count($str, 0). ' words.';
}

if (isset($_GET[''])){

}
*/

//Creo en objeto

require_once('JSON.php');
require_once('DB/db.php');

$json = new Services_JSON();

try {	
	$query = 'SELECT * FROM nodos';
	$datos = DBquery2($query);
	$salida = $json->encode($datos);

} catch (Exception $e) {
	print('ERROR! '.$e);
}

print($salida);

?> 