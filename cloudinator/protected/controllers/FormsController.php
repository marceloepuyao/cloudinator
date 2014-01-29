<?php

class FormsController extends Controller
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

			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view', 'admin','delete', 'create','update', 'setvisible', 'setnovisible'),
				'users'=>array('admin'),
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
		$model=new Forms;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Forms']))
		{
			$model->attributes=$_POST['Forms'];
			$model->deleted = 0;
			$model->created = date("Y-m-d H:i:s");
			if($model->save())
				$this->redirect(array('editor/index'));
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

		if(isset($_POST['Forms']))
		{
			$model->attributes=$_POST['Forms'];
			if($model->save())
				$this->redirect(array('editor/index'));
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
		$form= $this->loadModel($id);
		Yii::app()->db->createCommand("UPDATE trees SET deleted = 1 WHERE megatree = $form->id")->execute();
		
		$form->attributes = array("deleted"=>1);
		
		if($form->save())
				$this->redirect(array('editor/forms'));
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Forms');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionSetVisible($id){
		$model = $this->loadModel($id);
		$model->attributes= array('visible'=>1);
			if($model->save())
				$this->redirect(array('editor/index'));
		
	}
	public function actionSetNoVisible($id){
		$model = $this->loadModel($id);
		$model->attributes= array('visible'=>0);
			if($model->save())
				$this->redirect(array('editor/index'));
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Forms('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Forms']))
			$model->attributes=$_GET['Forms'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Forms the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Forms::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Forms $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='forms-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
