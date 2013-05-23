<?php
$mysql_host = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "cloudinator";

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
function DBconnect(){

	// Create connection
	$con = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);

	// Check connection

	return $con;

}

function DBclose_connection($con){
	mysqli_close($con);
}

function DBquery2($query){
	$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);

	mysql_select_db($mysql_database);

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
	$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);

	if(!mysql_query($query)){
		throw new Exception("Error Processing Query", 1);
	}

	mysql_close($link);
}
function DBquery4($query){
	$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);

	mysql_select_db($mysql_database);

	if(!mysql_query($query)){
		throw new Exception("Error Processing Query", 1);
	}

	mysql_close($link);
}
?>