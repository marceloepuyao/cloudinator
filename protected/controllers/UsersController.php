<?php

class UsersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


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
				'actions'=>array('index', 'view'),
				'users'=>array('@'),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete', 'create', 'update'),
				'roles'=>array("admin"),
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
		Yii::app()->user->returnUrl = $this->createUrl('users/index');
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
		Yii::app()->user->returnUrl = $this->createUrl('users/index');
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$model->modified = date("Y-m-d H:i:s");
			
			if($model->validate()){
				$model->password = crypt($model->password);
				$model->confirmpassword = $model->password;
				if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		Yii::app()->user->returnUrl = $this->createUrl('users/index');
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$model->modified = date("Y-m-d H:i:s");
			if($model->newpassword == "" && $model->confirmpassword == ""){
				$model->confirmpassword = $model->password;
				$model->newpassword = $model->password;
			}else{
				$model->password = crypt($model->newpassword);
				//$model->confirmpassword = sha1($model->confirmpassword);
			}
			
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}
			/*
			if($model->newpassword == "" && $model->confirmpassword == ""){
				if($model->save()){
					$this->redirect(array('view','id'=>$model->id));
				}
			}else if($model->newpassword == $model->confirmpassword){
				$model->password = sha1($model->newpassword);	
				if($model->save()){
					$this->redirect(array('view','id'=>$model->id));
				}
			}*/
			
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		$this->redirect(array('index'));
	}

	/**
	 * Lists and manage all models.
	 */
	public function actionIndex()
	{
		Yii::app()->user->returnUrl = $this->createUrl('site/index');
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users'])){
			$model->attributes=$_GET['Users'];
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
