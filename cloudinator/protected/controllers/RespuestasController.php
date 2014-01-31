<?php

class RespuestasController extends Controller
{
	
	function init()
	{
		parent::init();
		$app = Yii::app();
		if (isset($app->user->lang))
		{
			$app->language = Yii::app()->user->lang;
		}else{
			$app->language = 'es';
				
		}
		Yii::app()->user->setState('mobile', true);
	}
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view', 'create','update', 'preguntar', 'delete', 'subpregunta', 'deleterespuestas'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Respuestas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Respuestas']))
		{
			$model->attributes=$_POST['Respuestas'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Respuestas']))
		{
			$model->attributes=$_POST['Respuestas'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteRespuestas($subformid, $levantamientoid)
	{
		
		$preguntas = Respuestas::model()->findAll("subformid = $subformid AND levantamientoid = $levantamientoid");
		foreach ($preguntas as $pregunta){
			$pregunta->delete();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array('levantamientos/view', 'id'=>$levantamientoid));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($subformid, $levantamientoid, $respid= 0, $pregid=0)
	{
		//if envio solo pregunta, vuelvo atrás, y 
		
		$subform = Subforms::model()->find("id = $subformid");
		$levantamiento = Levantamientos::model()->find("id = $levantamientoid");
		

		
		if($respid == 0 && $pregid != 0){
					
			$record = Respuestas::model()->find("subformid=$subformid AND 
												levantamientoid = $levantamientoid AND
												preguntaid = $pregid");
			if($record['id']){
				$pregunta = Yii::app()->db->createCommand()->select('*')
														->from('nodos')
														->where('id=:id', array(':id'=>$record['preguntaid']))
														->queryRow(); 
				$respuestas = Yii::app()->db->createCommand()->select('*')
															->from('nodos')
															->where("id IN (SELECT target FROM links WHERE source =:source  )", array(':source'=>$pregunta['id']))
															->queryAll(); ;
				
															
				$this->render('preguntar',array(
					'pregunta'=>$pregunta,
					'respuestas'=>$respuestas,
					'subform'=>$subform, 
					'levantamiento'=>$levantamiento,
					'record'=>$record["respuestaid"],
					
				));
				Yii::app()->end();
			}
		}
		//if envio respuesta, respondo
		if($respid != 0 && $pregid != 0){
			
			//si el registro existe
			$record = Respuestas::model()->find("subformid=$subformid AND 
												levantamientoid = $levantamientoid AND
												preguntaid = $pregid");
			
			if($record['id']){
				//si la resupesta no camba, no se hace nada....//si la respuesta cambia se borra el registro y las respuestan que le siguen.
				if($record['respuestaid'] != $respid){
					
					$recordtodelete = Respuestas::model()->deleteAll(array("condition"=>"subformid=$subformid AND 
												levantamientoid = $levantamientoid AND
												id > ".$record['id']));
					$record = $this->loadModel($record['id']);
					$record->created = date("Y-m-d H:i:s");
					$record->respuestaid = $respid;
					if($record->save()){
						//$this->redirect(array('view','id'=>$registro->id));
						$this->redirect(array('index','subformid'=>$subformid, 'levantamientoid'=>$levantamientoid));
					}else{
						die(var_dump($record->getErrors()));
					}
				}
				
			}else{
			
				$registro = new Respuestas();
				$registro->attributes = array(	'preguntaid'=>$pregid,
												'respuestaid'=>$respid,
												'subformid'=>$subformid,
												'levantamientoid'=>$levantamientoid,
												'formid'=>0,
												'userid'=> Yii::app()->user->id,
												'empresaid'=> Yii::app()->user->getState('companyid'),
												'created'=> date("Y-m-d H:i:s"),
											);		
				$registro->validate();
				if($registro->save()){
					//$this->redirect(array('view','id'=>$registro->id));
					$this->redirect(array('index','subformid'=>$subformid, 'levantamientoid'=>$levantamientoid));
				}else{
					die(var_dump($registro->getErrors()));
				}
			}
		}
		
		Yii::app()->user->returnUrl = $this->createUrl('levantamientos/view', array('id'=>$levantamientoid));
		
		extract(MyUtils::getLastQuestionBySubform($subformid, $levantamientoid));
		
		if($pregunta != null){//si quedan preguntas por responder, manda a ActionResponder($id)

			//$model = $this->loadModel($id);
			$pregunta = Yii::app()->db->createCommand()->select('*')
														->from('nodos')
														->where('id=:id', array(':id'=>$pregunta['id']))
														->queryRow(); 
			$respuestas = Yii::app()->db->createCommand()->select('*')
														->from('nodos')
														->where("id IN (SELECT target FROM links WHERE source =:source  )", array(':source'=>$pregunta['id']))
														->queryAll(); ;
			
														
			$this->render('preguntar',array(
				'pregunta'=>$pregunta,
				'respuestas'=>$respuestas,
				'subform'=>$subform, 
				'levantamiento'=>$levantamiento,
				'record'=>0,
				
			));
	
		}else{//si no quedan, imprime todas las preguntas ya contestadas
			
			
			$sql="	SELECT 
						r.*,
						pregunta.name AS preguntaname, 
						respuesta.name AS respuestaname 
					FROM registropreguntas r 
						INNER JOIN nodos AS pregunta ON r.preguntaid = pregunta.id 
						INNER JOIN nodos AS respuesta ON r.respuestaid = respuesta.id
					WHERE r.levantamientoid = $levantamientoid AND subformid = $subformid";
			$dataProvider=new CSqlDataProvider($sql);
			/*
			$dataProvider=new CActiveDataProvider('Respuestas', array(
				'criteria'=>array(
					'condition' => "levantamientoid=$levantamientoid AND subformid=$subformid",
			),
			));*/
			
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'levantamiento' => $levantamiento,
				'subform' => $subform,
			));
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Respuestas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Respuestas']))
			$model->attributes=$_GET['Respuestas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionSubpregunta()
	{
	    $this->renderPartial('subpregunta',array('data'=>'Ur-data'),false,true);
	}
	
	/**
	 * Answer question
	 */
	public function actionResponder($idpregunta, $idrespuesta){
		
		$model->preguntaid = $idpregunta;
		$model->respiestaid = $idrespuesta;
		$model->subformid = 2;
		$model->levantamientoid = 2;
		$model->userid = Yii::app()->user->id;
		$model->empresaid = Yii::app()->getState('empresaid');
		
		if($model->save()){
				$this->redirect(array('index','id'=>$model->id));
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Respuestas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Respuestas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	

	/**
	 * Performs the AJAX validation.
	 * @param Respuestas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='respuestas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
