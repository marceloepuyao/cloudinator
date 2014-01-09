<?php
define('APPLICATION_PATH', realpath(dirname(__FILE__)));
require_once('DB/db.php');
//TODO: INTERNAL OR DIE
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
function getSubFormByCloneId($cloneid){
	$cloned = DBQueryReturnArray("SELECT * FROM cloned WHERE id = $cloneid");
	return getSubForm($cloned[0]['subformid']);
	
}

function getQuestionAnswers($idsubform, $idlevantamiento, $clonedid = 0){
	//se obtienen la última pregunta hecha.
	if($clonedid){
		$cloned = DBQueryReturnArray("SELECT * FROM cloned WHERE id = $clonedid");
		$idsubform = $cloned[0]['subformid'];
		$queryregistro = "SELECT * FROM registropreguntas WHERE levantamientoid = $idlevantamiento AND clonedid = $clonedid order by created DESC limit 1";
	}else{
		$queryregistro = "SELECT * FROM registropreguntas WHERE levantamientoid = $idlevantamiento AND subformid = $idsubform order by created DESC limit 1";
	}	
	$registro = DBQueryReturnArray($queryregistro);
	//se obtiene la pregunta que viene... si no hay datos: la primera.
	
	//calcular completitud
	if($clonedid){
		$registrototal = DBQueryReturnArray("SELECT * FROM registropreguntas WHERE levantamientoid = $idlevantamiento AND clonedid = $clonedid");
	}else{
		$registrototal = DBQueryReturnArray("SELECT * FROM registropreguntas WHERE levantamientoid = $idlevantamiento AND subformid = $idsubform");
	}
	$preguntascontestadas = count($registrototal);
	$minimopreguntas = calcularMinimoPreguntas($idsubform);
	$maximopreguntas = calcularMaximoPreguntas($idsubform);
	
	//TODO: completitud máxima no se está ocupando y está mal calculada
	$completitudminima = round(($preguntascontestadas / $minimopreguntas )*100, 1);
	if($completitudminima > 100){
		$completitudminima = 100;
	}
	$completitudmaxima = round(($preguntascontestadas/$maximopreguntas)*100, 1);
	
	if($completitudmaxima == $completitudminima ){
		$completitud = $completitudminima."%";
	}else{
		$completitud = $completitudmaxima."% - ".$completitudminima."%";
	}
	$lang = $_SESSION['idioma'];
	
	if($registro != null){
		//ver en el registro la ultima pregunta respondida, ver su respuesta y sacar la pregunta que viene:
		$idrespuesta = $registro[0]["respuestaid"];
		
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
			
			return array("pregunta" =>$pregunta[0], "respuestas" => $respuestas, "ultimavisita"=>floor((time()-strtotime($registro[0]['created']))/(60*60*24)).' '.get_string('daysago', $lang), "completitud"=>$completitud, "idregistro"=> $registro[0]['id']);
		}else{
			
			return array("pregunta" =>null, "respuestas" => null, "ultimavisita"=>floor((time()-strtotime($registro[0]["created"]))/(60*60*24)).' '.get_string('daysago', $lang), "completitud"=>$completitud, "idregistro"=> $registro[0]['id']);
			
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
		
	return array("pregunta" =>$pregunta[0], "respuestas" => $respuestas, "ultimavisita"=>get_string('never', $lang), "completitud"=>$completitud, "idregistro"=> null);
	
}
function calcularMinimoPreguntas($idsubform){
	
	
	$preguntainicial = DBQueryReturnArray("SELECT k.* from nodos k
										WHERE k.tree = $idsubform AND k.type = 'condition' AND  k.id NOT IN(
										SELECT n.id
										FROM nodos n, links l
										WHERE n.tree = $idsubform AND n.type = 'condition' AND n.id =l.target)");
	$nodofinal = DBQueryReturnArray("SELECT * FROM nodos WHERE tree = $idsubform AND type='end'");
	$preguntas = DBQueryReturnArray("SELECT * FROM nodos WHERE tree = $idsubform AND type='condition'");
	$maximoiteraciones = count($preguntas);
	
	$nodos_con = $nodofinal[0]['id'];
	
	for ($i = 0; $i < $maximoiteraciones; $i++) {
		
		$newcon = "0";
		foreach ($preguntas as $pregunta){
			
			
			$link= DBQueryReturnArray("	SELECT * FROM links 
										WHERE target IN ($nodos_con) 
										AND tree = '$idsubform' 
										AND source IN (SELECT target FROM links WHERE tree = '$idsubform' AND source = '$pregunta[id]')");
			if(count($link) > 0){
				$newcon .= ",".$pregunta['id'];
				if($pregunta['id'] == $preguntainicial[0]['id']){
					return $i+1;
				}
				
			}
			
		}
		$nodos_con = $newcon;
		$preguntas = DBQueryReturnArray("SELECT * FROM nodos WHERE tree = $idsubform AND type='condition' AND id NOT IN($nodos_con)");
		
		
	}
	
	return "error";
}

function calcularMaximoPreguntas($idsubform){
	$preguntas = DBQueryReturnArray("SELECT * FROM nodos WHERE tree = $idsubform AND type='condition'");
	
	return count($preguntas);
	
}

function getQuestionById($idsubform, $idlevantamiento, $registroid, $idclone){
	
	if($idclone){
		$cloned = DBQueryReturnArray("SELECT * FROM cloned WHERE id = $idclone");
		$idsubform = $cloned[0]['subformid'];
		$queryregistro = "SELECT * FROM registropreguntas WHERE levantamientoid = $idlevantamiento AND clonedid = $idclone AND id = $registroid";
	}else{
		$queryregistro = "SELECT * FROM registropreguntas WHERE levantamientoid = $idlevantamiento AND subformid = $idsubform AND id = $registroid";
	}
	$registro = DBQueryReturnArray($queryregistro);
	
	$idpregunta = $registro[0]["preguntaid"];
		
	$pregunta = DBQueryReturnArray("SELECT k.* 
									FROM nodos k
									WHERE k.tree = $idsubform AND k.type = 'condition' AND  k.id  = $idpregunta");
	
	$respuestas = DBQueryReturnArray("SELECT n.*
											FROM nodos n
											WHERE n.id IN(
											SELECT l.target
											FROM  links l
											WHERE l.source = $idpregunta)");
	return array("registro"=>$registro[0],"pregunta" =>$pregunta[0], "respuestas" => $respuestas, "ultimavisita"=>'Hace '.floor((time()-strtotime($registro[0]['created']))/(60*60*24)).' Días.', "completitud"=>0, "idregistro"=>$registro[0]['id']);
}

function getRegistroAteriorConRegistroID($registroid, $idsubform, $idlev){
	
	$superquery = "	SELECT r.*
					FROM registropreguntas r
					WHERE r.subformid = $idsubform AND r.levantamientoid =$idlev  AND r.respuestaid IN (select l.source 
										FROM links l
										WHERE l.target = (SELECT rr.preguntaid FROM registropreguntas rr WHERE rr.id = $registroid))";
	$registroanterior = DBQueryReturnArray($superquery);
	
	return $registroanterior[0];
	
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
	
	if(count($levantamiento[0])>0){
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

	$lang = ""; //predeterminado

	//se revisa que hay en la sesion
	if(isset($_SESSION['idioma'])){
		$lang = $_SESSION['idioma'];
		return $lang;
	}
	
	//se revisa que hay en la URL
	if($lang == "" || $lang == null){
		if(isset($_GET['lang'])){
			if($_GET['lang'] == "es" ||  $_GET['lang'] == "en"  || $_GET['lang'] == "pt" ){
				$lang = $_GET['lang'];
				return $lang;
			}
		}
	}
	$lang = "es"; //predeterminado
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
function getResumenSubform($idsubform, $idlevantamiento, $idclone){
	
	if($idclone){
		$queryresumen = "SELECT rp.*, n.metaname as subpregunta FROM registropreguntas rp, nodos n where rp.clonedid = $idclone AND rp.levantamientoid = $idlevantamiento AND rp.respuestaid = n.id ORDER BY rp.created";
	}else{
		$queryresumen = "SELECT rp.*, n.metaname as subpregunta  FROM registropreguntas rp, nodos n where rp.subformid = $idsubform AND rp.levantamientoid = $idlevantamiento AND rp.respuestaid = n.id  ORDER BY rp.created";
	}
	$resumen = DBQueryReturnArray($queryresumen);
	return $resumen;
	
}

function getContentByNodeId($nodeID){
	
	$querycontent = "SELECT * FROM nodos where id = $nodeID";
	$content = DBQueryReturnArray($querycontent);
	return $content[0]['name'];
	
}

function checkSession($lastaccess, $usuario,$idioma){
	
	//si esta vacio el usario devolver false
	if($usuario == ""){
		return false;
	}
	//si el tiempo del último acceso es mayor que el tiempo de ahora en 20 minunos devuelve false
	$time = time(); 
	if($lastaccess){
		//Aquí es donde se settea el tiempo de las session, ahora está en 20 min
		if(($time - $lastaccess)  < 20*60){
			return true;
		}else{
			//se eliminan las cookies y se devuelve false
			$_SESSION = array();
			return false;
		}
		
	}else{
		return true;
	}
	
	
}
function getSubFormsbyFormId($formid, $levantamientocreated){
	$querysubformularios = "SELECT * FROM trees 
									WHERE released = 1 
									AND megatree = $formid
									AND (deleted = 0 OR 
											(deleted = 1 AND modified > '$levantamientocreated')); ";
	
	$subformularios = DBQueryReturnArray($querysubformularios);
	return $subformularios;
}
function getClonedSubFormByFormId($formid, $levantamientoid){
	$queryclonedsubform = "SELECT * FROM cloned WHERE formid = $formid AND idlev  = $levantamientoid";
	$subformularios = DBQueryReturnArray($queryclonedsubform);
	return $subformularios;
	
}
function getNameByUserId($userid){
	
	$query = "SELECT * FROM users WHERE id = $userid";
	$user = DBQueryReturnArray($query);
	if(count($user)<1){
		return "-";
	}else{
		return $user[0]['name']." ".$user[0]['lastname'];
	}
}

function getCategories(){

	$categories = array('industria_pesada', 
						'siderúrgicas',
						'metalúrgicas',
						'cementeras', 
						'químicas_de_base',
						'petroquímicas',
						'automovilística',
						'industria_ligera',
						'alimentación',
						'textil',
						'farmacéutica',
						'agroindustria',
						'armamentística',
						'industria_punta',
						'robótica',
						'informática',
						'astronáutica',
						'mecánica',
						'educacionales',
						'gubernamentales',
						'otras');	
	return $categories;
}

function print_panel($USER, $lang, $edit= 0, $modeedittext = null){
	
	if($edit){
		$edithtml = "<a href='#' class='edicion'>$modeedittext</a><br>";
	}else{
		$edithtml  = "";
	}
	if($USER[0]['superuser']){
		$superuserhtml = "	<a href='#' class='editor'>".get_string('editor', $lang)."</a><br>
							<a href='#' class='gestionempresas'>".get_string('managingcompanies', $lang)."</a><br>
			";
	}else{
		$superuserhtml = "";
	}
	
	$panel=  "<div data-theme='b' data-display='overlay' data-position='right' data-role='panel' id='mypanel'>
		<h2>".$USER[0]['name']." ".$USER[0]['lastname']."</h2>
		
		".$edithtml.$superuserhtml."
		<a href='#' class='usuarios'>".get_string('managingusers', $lang)."</a><br>
		<a href='#' class='cerrarsesion'> ".get_string('logout', $lang)."</a> <br>
		<a href='#header' data-rel='close'>".get_string("close", $lang)."</a>
	     </div><!-- /panel -->";
	
	return $panel;
}
function print_navbar($toindex, $idemp, $idlevantamiento, $idform, $idsubform, $lang ){
	$navbar = '<a href="#" class="backtoIndex" data-icon="arrow-l">'.get_string('home', $lang).'</a>';
	
	if($toindex){
		$navbar .= ' >'.get_string('listlevantamientos', $lang);
		return $navbar;
	}
	$navbar .= ' > <a href="#" class="backtoLevantamiento" data-idemp="'.$idemp.'" data-icon="arrow-l">'.get_string('listlevantamientos', $lang).'</a>';
	
	if($idsubform == 0){
		
		$levantamiento = getLevantamientobyId($idlevantamiento);
		$navbar .= ' > '.$levantamiento['titulo'];
		return $navbar;
	}
	
	$levantamiento = getLevantamientobyId($idlevantamiento);	
	$subform = getSubForm($idsubform);
	$navbar .= ' > <a href="#" class="backtoRecorrer" data-idlev="'.$idlevantamiento.'" data-idform="'.$idform.'" data-icon="arrow-l">'.$levantamiento['titulo'].'</a>';
	
	$navbar .= ' > '.$subform['name'];
	return $navbar;
	
	
}

function print_navbar_config($text, $lang){
	$navbar = '<a href="#" class="backtoIndex" data-icon="arrow-l">'.get_string('home', $lang).'</a> > '.$text;
	return $navbar;
}

function addProductMagento($name){
	$config = parse_ini_file(dirname(__FILE__)."/config.ini", true);
	$connconf = $config["magento"];
	
	$proxy = new SoapClient($connconf['magento_url']);
	$sessionId = $proxy->login($connconf['magento_user'], $connconf['magento_pass']);
	if($sessionId){
		//si la conexión es posible agregar
		$attributeSets = $proxy->call($sessionId, 'product_attribute_set.list');
		$set = current($attributeSets);
		$newProductData = array(
		    'name'              => $name,
		     // websites - Array of website ids to which you want to assign a new product
		    'websites'          => array(1), // array(1,2,3,...)
		    'short_description' => 'short description',
		    'description'       => 'description',
		    'status'            => 1,
		    'weight'            => 0,
		    'tax_class_id'      => 1,
		    'categories'    	=> array(3),    //3 is the category id
		    'price'             => 12.05
		);
		
		// Create new product
		$proxy->call($sessionId, 'product.create', array('simple', $set['set_id'], $name, $newProductData));
		$proxy->call($sessionId, 'product_stock.update', array($name, array('qty'=>50, 'is_in_stock'=>1)));
		return true;
	}else{
		return false;
	}			
	
}

	
	
