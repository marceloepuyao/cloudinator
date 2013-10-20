<?php
require_once('DB/db.php');

/** obtenemos el formulario, pero primero revisamos si está SANO:
 *  1.- solo hay un nodo que no tiene padres (este nodo es pregunta)
 *  2.- solo hay un nodo que no tiene hijos  (es nodo fin)
 *  si no lo está esta función devuelve FALSE
 */
function getSubForm($idsubform){
	
	//check if the subform is OK
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
	//se obtiene la pregunta que viene... si no hay datos: la primera.
	if($preguntas != null){
		
		//ver en el registro la ultima pregunta respondida, ver su respuesta y sacar la pregunta que viene:
		$idrespuesta = $preguntas[0]["respuestaid"];
		
		$pregunta = DBQueryReturnArray("SELECT k.* 
										FROM nodos k
										WHERE k.tree = $idsubform AND k.type = 'condition' AND  k.id IN(
											SELECT l.target
											FROM links l
											WHERE l.source = $idrespuesta
										)");
		if($pregunta != null){
		
			$respuestas = DBQueryReturnArray("SELECT n.*
											FROM nodos n
											WHERE n.id IN(
											SELECT l.target
											FROM  links l
											WHERE l.source = ".$pregunta[0]['id'].")");
		}else{
			
			return array("pregunta" =>null, "respuestas" => null, "ultimavisita"=>$preguntas[0]["created"], "completitud"=>100);
			
		}
		
		return array("pregunta" =>$pregunta[0], "respuestas" => $respuestas, "ultimavisita"=>$preguntas["created"], "completitud"=>0);
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
	
	//TODO: calcular completitud
	$completitud = 0;
		
	return array("pregunta" =>$pregunta[0], "respuestas" => $respuestas, "ultimavisita"=>"nunca", "completitud"=>$completitud);
	
}
function getEmpresaByLevantamientoId($idlevantamiento){
	$queryempresa = "select *
					from empresas
					where id IN( select empresaid from levantamientos where id = $idlevantamiento)";
	$empresa = DBQueryReturnArray($queryempresa);
	
	return $empresa[0];
	
}