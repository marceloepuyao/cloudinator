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
try {
	echo var_dump(DBquery('SELECT * FROM nodes'));
} catch (Exception $e) {
	echo 'ERROR! '.$e;
}


function DBquery($sql_query){
	$connection = DBconnect();
	// Execute query
	try{
		return mysqli_query($connection, $sql_query);
	}catch(Exception $e){
		throw $e;
	}

	DBclose_connection($connection);
}
function DBconnect($mysql_host = "localhost", $mysql_user = "root", $mysql_password = "", $mysql_database = "cloudinator"){

	// Create connection
	$con = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);

	// Check connection
	if (mysqli_connect_errno($con)){
		throw new Exception("Failed to connect to MySQL", 1);
	}else{
		return $con;
	}
}

function DBclose_connection($con){
	mysqli_close($con);
}

?>