<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

if(isset($_POST['type'])) {
	try {
		DBQuery("INSERT INTO `megatrees` (`id`, `name`, `chain`, `deleted`, `created`, `modified` ) VALUES 
			(NULL, '$_POST[name]', NULL, 0, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."' );
			");

		$data = array(
		'result' => 'true',
		);
		print($json->encode($data));
	
	} catch (Exception $e) {
		print($json->encode($e));
	}
	
}
else if(isset($_POST['clonename'])) {
	/* //segun vi, lo que se envia no es el nombre, es la id
	$sql = "SELECT id FROM trees WHERE name = '$_POST[clonename]'";
	$data1 = DBQuery($sql);
	$idclone = $data1->fetch_assoc()['id'];
	*/

	$idclone = $_POST['clonename'];

	$sql2 = "SELECT name, type, posx, posy FROM nodos WHERE tree = $idclone";
	$data2 = DBQuery($sql2);
	
	$sql3 = "SELECT id FROM nodos WHERE tree = $idclone";
	$data3 = DBQuery($sql3);
	$max = $data3->num_rows;
	
	DBQuery("INSERT INTO `trees` (`id`, `name`,`megatree`, `deleted`, `created`) VALUES 
			(NULL, '$_POST[name]', $_POST[to] ,0,'".date("Y-m-d H:i:s")."');
			");
	
	$sqlgettree = "SELECT id FROM trees WHERE name = '$_POST[name]'";
	$data4 = DBQuery($sqlgettree);
	$aux4 = $data4->fetch_assoc();
	$idnew = $aux4['id'];
	
	while ($fetch = $data2->fetch_assoc()) {
		$name = $fetch['name'];
		$type = $fetch['type'];
		$posx = $fetch['posx'];
		$posy = $fetch['posy'];
		$metaname = $fetch['metaname'];
		$metadata = $fetch['metadata'];
		$metatype = $fetch['metatype'];

		$query = "INSERT INTO `nodos` (`id`, `tree`, `name`, `type`, `posx`, `posy`, `metaname`, `metadata`, `metatype`) VALUES 
				(NULL, $idnew, '$name', '$type', '$posx', '$posy', '$metaname', '$metadata', '$metatype');
				";
		DBQuery($query);
	}

	$linksprevquery = "SELECT source, target FROM links WHERE tree = $idclone";
	$linksprev= DBQuery($linksprevquery);
	
	$countprevquery = "SELECT id FROM links WHERE tree = $idclone";
	$countprev = DBQuery($countprevquery);
	$maxlinks = $countprev->num_rows;

	while ($fetch = $linksprev->fetch_assoc()) {
		$targeta = $fetch['target'];
		$querytarget = "SELECT id
						FROM nodos
						WHERE name = (SELECT name FROM nodos WHERE id = $targeta ) order by id desc";
		$newtarget = DBQuery($querytarget);
		$aux = $newtarget->fetch_assoc();
		$idnewtarget = $aux['id'];
		
		$sourca = $fetch['source'];
		$querysource = "SELECT id
						FROM nodos
						WHERE name = (SELECT name FROM nodos WHERE id = $sourca ) order by id desc";
		$newsource = DBQuery($querysource);
		$aux = $newsource->fetch_assoc();
		$idnewsource = $aux['id'];
		
		
		$query = "INSERT INTO `links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
				(NULL, $idnew, '', '$idnewsource', '$idnewtarget');";
				
		DBQuery($query);
	}
	/* //ESTO SE DEBE BORRAR
	for ($i = 0; $i < $maxlinks; $i++) {
		$targeta = mysql_result($linksprev, $i, 'links.target');
		$querytarget = "select id
						from nodos
						where name= (select name from nodos where id = $targeta ) order by id desc";
		$newtarget = DBQuery($querytarget);
		$idnewtarget = mysql_result($newtarget, 0);
		
		$sourca = mysql_result($linksprev, $i, 'links.source');
		$querysource = "select id
						from nodos
						where name= (select name from nodos where id = $sourca ) order by id desc";
		$newsource = DBQuery($querysource);
		$idnewsource = mysql_result($newsource, 0);
		
		
		$query = "INSERT INTO `links` (`id`, `tree`, `name`, `source`, `target`) VALUES 
				(NULL, $idnew, '', '$idnewsource', '$idnewtarget');";
				
		DBQuery($query);
		
	}
	*/
	
	$data = array(
		'result' => 'true',
	);
	print($json->encode($data));
	
	
}else if (isset($_POST['name'])) {
	try {
		DBQuery("INSERT INTO `trees` (`id`, `name`, `megatree`,`deleted`, `created`) VALUES 
			(NULL, '$_POST[name]',$_POST[megatree] ,0, '".date("Y-m-d H:i:s")."');
			");
		$data = array(
			'result' => 'true',
		);
		print($json->encode($data));

		//$data = DBQuery("SELECT id FROM trees WHERE name = '$_POST[name]'");
		//print($json->encode(mysql_result($data, 0)));
	} catch (Exception $e) {
		print($e);
	}
}else if(isset($_POST['action'])){
	
	try {
		DBQuery("DELETE FROM links WHERE tree = $_POST[tree]");
		DBQuery("DELETE FROM nodos WHERE tree = $_POST[tree]");
		DBQuery("DELETE FROM trees WHERE id = $_POST[tree]");
		$data = array(
			'result' => 'true',
		);
		print($json->encode($data));
	}catch (Exception $e){
		print($e);
	}

	

}else if(isset($_POST['nuevonombre'])){
	try {
		DBQuery("UPDATE trees SET name = '$_POST[nuevonombre]' WHERE id = $_POST[tree]");
		$data = array(
			'result' => 'true',
		);
		print($json->encode($data));
	}catch (Exception $e){
		print($e);
	}
	
	
}else{


	try {	
		$query = 'SELECT * FROM trees WHERE deleted = 0';
		$datos = DBQueryReturnArray($query);
		$salida = $json->encode($datos);

	} catch (Exception $e) {
		print('ERROR! '.$e);
	}

	print($salida);
}

?> 