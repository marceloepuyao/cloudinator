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


$json = new Services_JSON();

/* esto no funciona )=
require_once('db.php');
$datos = DBquery('select * from test');
*/


// Armo un array con varios datos
$subdatos = array('1','2',3);
$datos = array('asdf', 'feo', $subdatos);

$salida = $json->encode($datos);

print($salida);

?> 