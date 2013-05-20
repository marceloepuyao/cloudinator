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



//Creo el objeto $json para codificar datos mas adelante
require_once('JSON.php');
$json = new Services_JSON();

require_once('db.php');
$result = DBquery('SELECT name FROM test');
//print $json->encode($result);


//$link = mysql_connect('mysql3.000webhost.com', 'a5397912_root', 'pepito.P0');
//mysql_select_db('a5397912_cloud');

//$query = 'SELECT * FROM "test"';
//$result = mysql_query($query) ;



$datos = array();

//lleno el array $datos con el resultado de la consulta a MySQL:
while ($line = mysqli_fetch_array($result)) {
$datos[]=$line;
}

print $json->encode($datos);



//mysql_free_result($result);
//mysql_close($link);




/*
//Creo en objeto

require_once('JSON.php');

$json = new Services_JSON();

// Armo un array con varios datos

$datos = array(1, 2, 'foo');

$salida = $json->encode($datos);

print($salida);

*/

?> 