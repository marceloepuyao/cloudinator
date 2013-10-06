<?php
require_once('../JSON.php');
require_once('../DB/db.php');

$json = new Services_JSON();

try {
	$db = DBConnect();
	$db->autocommit(FALSE);
	$idlev = (int)$_POST['idlev'];
	$idsubform = (int)$_POST['idsubform'];
	$idnode = (int)$_POST['idnode'];

	$query = "";
	
	$data = array(
			'result' => 'true',
			);
	print($json->encode($data));

} catch (Exception $e) {
	$db->rollback();
	$db->close();
	throw new Exception("Error Processing Query", 1);
}
