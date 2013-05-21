<?php
	/*
	static function create_database($mysql_host, $mysql_user, $mysql_password){
		$con=mysqli_connect($mysql_host, $mysql_user, $mysql_password);
		// Check connection
		if (mysqli_connect_errno())
  		{
  			return "Failed to connect to MySQL: " . mysqli_connect_error();
  		}

		// Create database
		$sql="CREATE DATABASE cloudinator";
		if (mysqli_query($con, $sql))
  		{
		}
		else
  		{
  			return "Error creating database: " . mysqli_error($con);
  		}
	}
	*/

/* ejemplo al cargar db.php
try {
	require_once('JSON.php');
	$json = new Services_JSON();
	$resultado = DBquery('SELECT * FROM nodes');
	$salida = $json->encode($resultado);
	echo '<br>';
	echo $salida;
	echo '<hr>';
	foreach ($resultado as $key1 => $row) {
		echo '| ';
	 	foreach ($row as $key2 => $value) {
	 		echo $key1.'-'.$key2.': '.$value.' | ';
	 	}
	 	echo '<hr>';
	 }
} catch (Exception $e) {
	echo 'ERROR! '.$e;
}
*/

function DBquery($sql_query){
	$connection = DBconnect();
	// Execute query
	try{
		$result = mysqli_query($connection, $sql_query);
		return $result;
	}catch(Exception $e){
		throw $e;
	}

	DBclose_connection($connection);
}
function DBconnect($mysql_host = "localhost", $mysql_user = "root", $mysql_password = "", $mysql_database = "cloudinator"){

	// Create connection
	$con = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);

	// Check connection

	return $con;

}

function DBclose_connection($con){
	mysqli_close($con);
}

function DBquery2($query){
	$link = mysql_connect('localhost', 'root', '');

	mysql_select_db('cloudinator');

	$result = mysql_query($query);

	$datos = array();

	//lleno el array $datos con el resultado de la consulta a MySQL:

	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {

	$datos[]=$line;

	}
	
	mysql_free_result($result);

	mysql_close($link);

	return $datos;
}

function DBquery3($query){
	$link = mysql_connect('localhost', 'root', '');

	if(!mysql_query($query)){
		throw new Exception("Error Processing Query", 1);
	}

	mysql_close($link);
}
function DBquery4($query){
	$link = mysql_connect('localhost', 'root', '');

	mysql_select_db('cloudinator');

	if(!mysql_query($query)){
		throw new Exception("Error Processing Query", 1);
	}

	mysql_close($link);
}
?>