<?php
class MyUtils {

        public static function getLastQuestionBySubform($idsubform, $idlevantamiento)
	{
		$criteria = new CDbCriteria;  
		$criteria->addCondition('subformid = '.$idsubform);
		$criteria->addCondition('levantamientoid = '.$idlevantamiento);
		$criteria->order = 'created DESC';
		$registro =  Respuestas::model()->find($criteria);
		
		
		//CALCULO DE COMPLETITUD
		$preguntascontestadas = count($registro);
		$minimopreguntas = MyUtils::calcularMinimoPreguntas($idsubform);
		$maximopreguntas = MyUtils::calcularMaximoPreguntas($idsubform);
		
		
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
		//FIN CALCULO DE COMPLETITUD
		
		if($registro !== NULL){
			//ver en el registro la ultima pregunta respondida, ver su respuesta y sacar la pregunta que viene:
			$idrespuesta = $registro->respuestaid;
			
			//esta es la pregunta que viene
			$pregunta = Yii::app()->db->createCommand("SELECT k.* 
											FROM nodos k
											WHERE k.tree = $idsubform AND k.type = 'condition' AND  k.id IN(
												SELECT l.target
												FROM links l
												WHERE l.source = $idrespuesta
											)")->queryRow();
			if($pregunta !== false){
			
				$respuestas = Yii::app()->db->createCommand("SELECT n.*
												FROM nodos n
												WHERE n.id IN(
												SELECT l.target
												FROM  links l
												WHERE l.source = '$pregunta[id]');")->queryAll();
				
				return array("pregunta" =>$pregunta, "respuestas" => null, "ultimavisita"=>floor((time()-strtotime($registro->created))/(60*60*24))==0?"today":floor((time()-strtotime($registro->created))/(60*60*24))."days ago", "completitud"=>$completitud, "idregistro"=> $registro->id);
			}else{
				
				return array("pregunta" =>null, "respuestas" => null, "ultimavisita"=>floor((time()-strtotime($registro->created))/(60*60*24))==0?"today":floor((time()-strtotime($registro->created))/(60*60*24))."days ago", "completitud"=>"100%", "idregistro"=> $registro->id);
				
			}
			
			
		}else{
			$pregunta = Yii::app()->db->createCommand("SELECT k.* from nodos k
											WHERE k.tree = $idsubform AND k.type = 'condition' AND  k.id NOT IN(
											SELECT n.id
											FROM nodos n, links l
											WHERE n.tree = $idsubform AND n.type = 'condition' AND n.id =l.target)")->queryRow();
			
			$respuestas = Yii::app()->db->createCommand("SELECT n.*
											FROM nodos n
											WHERE n.id IN(
											SELECT l.target
											FROM  links l
											WHERE l.source = '".$pregunta['id']."');")->queryAll();
		}
		return array("pregunta" =>$pregunta, "respuestas" => $respuestas, "ultimavisita"=>Yii::t('contentForm', 'never'), "completitud"=>"0%", "idregistro"=> null);
		
	}
	
	public static function getLastRegistrosByLevantamiendoId($levid){
		
		/*SELECT m.name,  t.*, r.preguntaid, r.created, n.name
		FROM trees t,registropreguntas r, megatrees m, nodos n
		WHERE m.id = t.megatree AND   r.subformid = t.id  AND n.id = r.preguntaid AND r.id= (SELECT id FROM registropreguntas WHERE  subformid = t.id AND levantamientoid = 67 ORDER BY created DESC limit 1) 
	*/
	}
	
	public static function checkSubForm($idsubform){
	
		//check if the subform is OK
		$primerapregunta = Yii::app()->db->createCommand("SELECT k.* from nodos k
												WHERE k.tree = $idsubform AND  k.id NOT IN(
												SELECT n.id
												FROM nodos n, links l
												WHERE n.tree = $idsubform AND n.id =l.target)")->queryAll();
		if(count($primerapregunta) > 1 || count($primerapregunta)==0){
			return false;
		}else if($primerapregunta[0]['type'] != "condition"){
			return false;
		}
		
		$fin = Yii::app()->db->createCommand("SELECT k.* from nodos k
									WHERE k.tree = $idsubform AND  k.id NOT IN(
									SELECT n.id
									FROM nodos n, links l
									WHERE n.tree = $idsubform AND n.id =l.source)")->queryAll();
		if(count($fin) > 1 || count($fin)==0){
			return false;
		}else if($fin[0]['type'] != "end"){
			return false;
		}
		return true;
	}
	private static function calcularMinimoPreguntas($idsubform){
		
		
		$preguntainicial = Yii::app()->db->createCommand("SELECT k.* from nodos k
											WHERE k.tree = $idsubform AND k.type = 'condition' AND  k.id NOT IN(
											SELECT n.id
											FROM nodos n, links l
											WHERE n.tree = $idsubform AND n.type = 'condition' AND n.id =l.target)")->queryRow();
		$nodofinal = Yii::app()->db->createCommand("SELECT * FROM nodos WHERE tree = $idsubform AND type='end'")->queryRow();
		$preguntas = Yii::app()->db->createCommand("SELECT * FROM nodos WHERE tree = $idsubform AND type='condition'")->queryAll();
		$maximoiteraciones = count($preguntas);
		
		$nodos_con = $nodofinal['id'];
		
		for ($i = 0; $i < $maximoiteraciones; $i++) {
			
			$newcon = "0";
			foreach ($preguntas as $pregunta){
				
				
				$link= Yii::app()->db->createCommand("	SELECT * FROM links 
											WHERE target IN ($nodos_con) 
											AND tree = '$idsubform' 
											AND source IN (SELECT target FROM links WHERE tree = '$idsubform' AND source = '$pregunta[id]')")->queryAll();
				if(count($link) > 0){
					$newcon .= ",".$pregunta['id'];
					if($pregunta['id'] == $preguntainicial['id']){
						return $i+1;
					}
					
				}
				
			}
			$nodos_con = $newcon;
			$preguntas = Yii::app()->db->createCommand("SELECT * FROM nodos WHERE tree = $idsubform AND type='condition' AND id NOT IN($nodos_con)")->queryAll();
			
			
		}
		
		return "error";
	}
	
	private static function calcularMaximoPreguntas($idsubform){
		$preguntas = Yii::app()->db->createCommand("SELECT * FROM nodos WHERE tree = $idsubform AND type='condition'")->queryAll();
		
		return count($preguntas);
		
	}

}
?>