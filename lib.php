<?php
require_once('db/db.php');

/** obtenemos el formulario, pero primero revisamos si está SANO:
 *  1.- solo hay un nodo que no tiene padres (este nodo es pregunta)
 *  2.- solo hay un nodo que no tiene hijos  (es nodo fin)
 *  si no lo está esta función devuelve FALSE
 */
function getSubForm($idsubform){
	
	//TODO: check if the subform is OK
	$primerapregunta = DBQueryReturnArray("SELECT k.* from nodos k
											WHERE k.tree = $idsubform AND  k.id NOT IN(
											SELECT n.id
											FROM nodos n, links l
											WHERE n.tree = $idsubform AND n.id =l.target)");
	if(count($primerapregunta) > 1 || count($primerapregunta)==0){
		return false;
	}else if($primerapregunta[0]['type'] != "condition"){
		return false;
	}
	
	$fin = DBQueryReturnArray("SELECT k.* from nodos k
								WHERE k.tree = $idsubform AND  k.id NOT IN(
								SELECT n.id
								FROM nodos n, links l
								WHERE n.tree = $idsubform AND n.id =l.source)");
	if(count($fin) > 1 || count($fin)==0){
		return false;
	}else if($fin[0]['type'] != "end"){
		return false;
	}
	
	$querysubformularios = "SELECT * FROM trees WHERE id = ".$idsubform;
	$subformularios = DBQueryReturnArray($querysubformularios);
	
	return $subformularios[0];
	
}

function getQuestionAnswers($idsubform, $idlevantamiento){
	//se obtienen la última pregunta hecha.
	$querypreguntas = "SELECT * FROM registropreguntas WHERE levantamientoid = $idlevantamiento AND subformid = $idsubform order by created DESC limit 1";
	$preguntas = DBQueryReturnArray($querypreguntas);
	//se obtiene la pregunta que viene, si no la primera.
	if($preguntas != null){
		
	}else{
		$pregunta = DBQueryReturnArray("SELECT k.* from nodos k
										WHERE k.tree = $idsubform AND k.type = 'condition' AND  k.id NOT IN(
										SELECT n.id
										FROM nodos n, links l
										WHERE n.tree = $idsubform AND n.type = 'condition' AND n.id =l.target)");
		
		$respuestas = DBQueryReturnArray("SELECT n.*
										FROM nodos n
										WHERE n.id IN(
										SELECT l.target
										FROM  links l
										WHERE l.source = ".$pregunta[0]['id'].")");
	}
		
	return array("pregunta" =>$pregunta[0], "respuestas" => $respuestas);
	
}