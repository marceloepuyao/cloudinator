<?php
define('APPLICATION_PATH', realpath(dirname(__FILE__)));
require_once('DB/db.php');

/**
 * Modo de uso:
 * <?php echo get_string($key, $lang);?>
 * siendo $key la palabra clave par el string que se busca y $lang el idioma que se requiere.
 */
function get_string($key, $lang) {
	require(APPLICATION_PATH . '/lang/' . $lang . '.php');
	if(isset($dicc[$key])){
		$translation = $dicc[$key];
	}else{
		$translation = 'Warning - The key word "'.$key.'" was not found in "/lang/'.$lang.'.php"';
	}
	
	return $translation;
}

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
			
			return array("pregunta" =>$pregunta[0], "respuestas" => $respuestas, "ultimavisita"=>'Hace '.floor((time()-strtotime($preguntas[0]['created']))/(60*60*24)).' Días.', "completitud"=>0);
		}else{
			
			return array("pregunta" =>null, "respuestas" => null, "ultimavisita"=>'Hace '.floor((time()-strtotime($preguntas[0]["created"]))/(60*60*24)).' Días.', "completitud"=>100);
			
		}
		
		
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
function getLevantamientobyId($idlevantamiento){
	$query = 	"select *
				from levantamientos
				where id = $idlevantamiento";
	$levantamiento = DBQueryReturnArray($query);
	
	if($levantamiento[0]){
		return $levantamiento[0];
	}else{
		return false;
	}
	
}

function getAllFormularios(){
	
	$queryformularios = "SELECT * FROM megatrees";
	$formularios = DBQueryReturnArray($queryformularios);
	return $formularios;
}

/**
 * 
 * esta función revisa si está en las variables $_GET definido el lang, si no por defecto devuelve es
 */
function getLang(){
	
	$lang = $_SESSION['idioma'];
	if($lang == "" || $lang == null){
		if(isset($_GET['lang'])){
			if($_GET['lang'] == "es" ||  $_GET['lang'] == "en"  || $_GET['lang'] == "pt" ){
				$lang = $_GET['lang'];
			}else{
				$lang = "es";
			}
		}else{
			$lang = "es";
		}
	}
	return $lang;
	
	

}

function getSession($sessionname){
	foreach ($_COOKIE as $keya=>$i){
      	foreach(explode(":", $keya, 3) as $namecookie){
      		if($namecookie == $sessionname){
      			return $i;
      		}
      	} 
	}
	return false;
	
}
function getResumenSubform($idsubform, $idlevantamiento){
	
	$queryresumen = "SELECT * FROM registropreguntas where subformid = $idsubform AND levantamientoid = $idlevantamiento ORDER BY created";
	$resumen = DBQueryReturnArray($queryresumen);
	return $resumen;
	
}

function getContentByNodeId($nodeID){
	
	$querycontent = "SELECT * FROM nodos where id = $nodeID";
	$content = DBQueryReturnArray($querycontent);
	return $content[0]['name'];
	
}

function checkSession($lastaccess, $usuario, $empresa,$idioma){
	
	$url = "index.php?lang=".getLang();
	if($usuario == ""){
		@header('Location: '.$url);
		return false;
	}
	
	if($empresa == ""){
		@header('Location: '.$url);
		return false;
	}
	
	
	$time = time(); 
	if($lastaccess){
		if(($time - $lastaccess)  < 5*60){
			return true;
		}else{
			$_SESSION = array();
			@header('Location: '.$url);
			return false;
		}
		
	}else{
		return true;
	}
	
	
}
