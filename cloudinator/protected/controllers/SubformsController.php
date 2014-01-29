<?php

class SubformsController extends Controller
{
	function init()
	{
		parent::init();
	
		Yii::app()->language = "es";
		Yii::app()->user->setState('mobile', false);
		$this->layout='main';
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
			/*
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),*/
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view', 'create','update', 'admin','delete', 'release'),
				'users'=>array('admin'),
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
	public function actionCreate($id)
	{
		$model=new Subforms;
		$form = Forms::model()->find("id=$id");

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Subforms']))
		{
			$model->attributes=$_POST['Subforms'];
			$model->megatree = $form->id;
			$model->created = date("Y-m-d H:i:s");
			$model->modified = date("Y-m-d H:i:s");
			if($model->save())
				$this->redirect(array('editor/subforms','id'=>$model->megatree));
		}

		$this->render('create',array(
			'model'=>$model,
			'form'=>$form,
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

		if(isset($_POST['Subforms']))
		{
			$model->attributes=$_POST['Subforms'];
			$model->modified = date("Y-m-d H:i:s");
			if($model->save())
				$this->redirect(array('editor/subforms','id'=>$model->megatree));
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
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		$model->attributes = array('deleted'=>1);
		
		if($model->save())
			$this->redirect(array('editor/subforms','id'=>$model->megatree));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Subforms');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionRelease($id)
	{
		$model = $this->loadModel($id);
		$model->attributes= array('released'=>1);
			if($model->save())
				$this->redirect(array('editor/subforms', 'id'=>$model->megatree));
	}
	



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Subforms the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Subforms::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Subforms $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='subforms-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
