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
	$idpregunta = (int)$_POST['idpregunta'];
	$userid = (int)$_POST['iduser'];
	$idempresa= (int)$_POST['idempresa'];

	DBQuery("INSERT INTO `registropreguntas` (`id`, `preguntaid`, `respuestaid`, `subformid`,`formid`, `levantamientoid`, `userid`, `empresaid`, `created`) VALUES 
			(NULL, $idpregunta , $idnode, $idsubform ,'',$idlev, $userid,$idempresa,'".date("Y-m-d H:i:s")."' );
			");
	
	$data = array(
			'result' => true
			);
	print($json->encode($data));

} catch (Exception $e) {
	$db->rollback();
	$db->close();
	$data = array(
		'result' => false,
		'exception' => $e
		);
	print($json->encode($data));
}
