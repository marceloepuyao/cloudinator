<?php

class CompaniesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	function init()
	{
		parent::init();
		$app = Yii::app();
		if (isset(Yii::app()->user->lang))
		{
			$app->language = Yii::app()->user->lang;
		}

		Yii::app()->user->setState('mobile', true);
	}

	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update', 'index','view', 'delete' ),
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
		Yii::app()->user->returnUrl = $this->createUrl('companies/index');
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
		Yii::app()->user->returnUrl = $this->createUrl('companies/index');
		Yii::app()->language = Yii::app()->user->lang;
		$model=new Companies;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Companies']))
		{
			$model->attributes=$_POST['Companies'];
			$model->modified = date("Y-m-d H:i:s");
			if($model->save())
			{
				Yii::app()->user->setState('companyid', $model->id);
				$this->redirect($this->createUrl('levantamientos/index', array('companyid'=>$model->id)));
			}
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
		Yii::app()->user->returnUrl = $this->createUrl('companies/index');
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Companies']))
		{
			$model->attributes=$_POST['Companies'];
			$model->modified = date("Y-m-d H:i:s");
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete(); //TODO: delete levantamientos, registro de pregutnas

		if(!isset($_GET['ajax']))
		$this->redirect($this->createUrl('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		Yii::app()->user->returnUrl = $this->createUrl('site/index');
		$model=new Companies('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Companies'])){
			$model->attributes=$_GET['Companies'];
		}
		$this->render('index',array(
			'model'=>$model,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Companies the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Companies::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Companies $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='companies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}