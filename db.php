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

	static function DBquery($sql_query){
		$connection = DBconnect();
		// Execute query
		try{
			return mysqli_query($connection,$sql);
		}catch(Exception $e){
			throw $e;
		}
  		DBclose_connection($connection);
	}

	static function DBconnect($mysql_host = "mysql3.000webhost.com", $mysql_database = "a5397912_cloud", $mysql_user = "a5397912_root", $mysql_password = "pepito.P0"){

		// Create connection
		$con = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);

		// Check connection
		if (mysqli_connect_errno($con))
  		{
  			throw new Exception("Failed to connect to MySQL", 1);
  		}else{
  			return $con
  		}
	}

	static function DBclose_connection($con){
		mysqli_close($con);
	}

?>