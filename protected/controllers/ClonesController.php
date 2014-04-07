<?php

class ClonesController extends Controller
{
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
				'actions'=>array('create','update', 'delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id, $levid)
	{
		$model=new Clones;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$subform = Subforms::model()->find("id = $id");
		$levantamiento = Levantamientos::model()->find("id = $levid");

		if(isset($_POST['Clones']))
		{
			$model->attributes=$_POST['Clones'];
			$model->subformid = $id;
			$model->idlev = $levid;
			$model->formid = $subform->megatree;
			$model->modified = date("Y-m-d H:i:s");
			if($model->save()){
				$registros = Respuestas::model()->findAll("subformid = $id AND levantamientoid = $levid");
				foreach ($registros as $registro){
					$nuevo = new Respuestas();
					$nuevo->attributes  = $registro->attributes;
					$nuevo->clonedid = $model->id;
					$nuevo->created = date("Y-m-d H:i:s");
					$nuevo->save();
				}
				
				$this->redirect(array('levantamientos/view','id'=>$levid));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'subform'=>$subform,
			'levantamiento' => $levantamiento,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$respuestas = Respuestas::model()->deleteAll(array("condition"=> "clonedid = $id"));
		
		$clone = $this->loadModel($id);
		$levantamientoid = $clone->idlev;
		$clone->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(array('levantamientos/view','id'=>$levantamientoid));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Clones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Clones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Clones']))
			$model->attributes=$_GET['Clones'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Clones the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Clones::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Clones $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='clones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
