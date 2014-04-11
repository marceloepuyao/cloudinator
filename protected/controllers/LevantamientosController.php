<?php

class LevantamientosController extends Controller
{

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
				'actions'=>array('index', 'view', 'create','update', 'delete', 'reports', 'editmode', 'exiteditmode'),
				'users'=>array('@'),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(''),
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
		Yii::app()->user->setState('levantamientoid', $id);
		$model = $this->loadModel($id);
		Yii::app()->user->returnUrl = $this->createUrl('levantamientos/index', array('companyid'=>$model->empresaid));
		//get forms
		$in = "(";
		//$model->formsactivos = str_replace(array("[", "]", "\""), "",  $model->formsactivos  );
		$levantamientoarray = unserialize($model->formsactivos);
		foreach($levantamientoarray as $lev) {
			$in = $in.$lev.",";
		}
		
		$in = $in."-1)";
		$criteria = new CDbCriteria;  
		$criteria->addCondition('id IN '.$in);
		$forms = Forms::model()->findAll($criteria);
		
		
		$data = array();
		$cloned = array();
		foreach ($forms as $form){
			$data[$form['id']] = Subforms::model()->findAll("megatree = $form[id] AND (deleted = 0 OR 
											(deleted = 1 AND created < '$model->created' AND modified > '$model->created'))");
			$cloned[$form['id']] = Clones::model()->findAll("formid = $form[id] AND idlev  = $model->id");
		}

		//get subforms
		$criteria2 = new CDbCriteria;  
		$criteria2->addCondition('megatree IN '.$in);
		$criteria2->addCondition('ORDER by ID');
		//$subforms = Subforms::model()->findAll();
		
		$company = Companies::model()->find("id=".Yii::app()->user->getState('companyid'));
		$this->render('view',array(
			'model'=>$model,
			'forms'=>$forms,
			'data' => $data,
			'company' => $company,
			'clones'=> $cloned,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		Yii::app()->user->returnUrl = $this->createUrl('levantamientos/index', array('companyid'=>Yii::app()->user->getState('companyid')));
		$model=new Levantamientos;

		$forms = Forms::model()->findAll();
		$formsnames = array();
		foreach ($forms as $form){
			if($form['visible']==1 && $form['deleted']==0){
				$formsnames[$form['id']] = $form['name'];
			}
		}

		$users = Users::model()->findAll();
		$usersnames = array();
		foreach ($users as $user){
			$usersnames[$user['id']] = $user['email'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Levantamientos']))
		{
			$model->attributes=$_POST['Levantamientos'];
			 if($_POST['Levantamientos']['forms']!=='')
             	$model->formsactivos=serialize($_POST['Levantamientos']['forms']);//converting to string...
			
			$model->modified = date("Y-m-d H:i:s");
			$model->empresaid = Yii::app()->user->getState('companyid');
			
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}
		$company = Companies::model()->find("id=".Yii::app()->user->getState('companyid'));

		$this->render('create',array(
			'model'=>$model,
			'forms'=>$formsnames,
			'users' => $usersnames,
			'company' => $company,
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
		Yii::app()->user->returnUrl = $this->createUrl('levantamientos/index', array('companyid'=>$model->empresaid));
		
		
		$forms = Forms::model()->findAll();
		
		$formsnames = array();
		foreach ($forms as $form){
			if($form['visible']==1 && $form['deleted']==0){
				$formsnames[$form['id']] = $form['name'];
			}
		}

		$users = Users::model()->findAll();
		$usersnames = array();
		foreach ($users as $user){
			$usersnames[$user['id']] = $user['email'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Levantamientos']))
		{
			$model->attributes=$_POST['Levantamientos'];
			if($_POST['Levantamientos']['forms']!=='')
				$model->formsactivos = serialize($_POST['Levantamientos']['forms']);
			$model->modified = date("Y-m-d H:i:s");
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		$model->forms=unserialize($model->formsactivos);
		$company = Companies::model()->find("id=".Yii::app()->user->getState('companyid'));
		$this->render('update',array(
			'model'=>$model,
			'forms'=>$formsnames,
			'users' => $usersnames,
			'company' => $company,
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
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		$this->redirect(array('index', 'companyid'=>Yii::app()->user->getState('companyid')));
	}
	public function actionEditMode($id)
	{
		$model = $this->loadModel($id);

		Yii::app()->user->setState('editmode',1);
		$this->redirect(array('view', 'id'=>$id));
	}
	public function actionExitEditMode($id)
	{
		$model = $this->loadModel($id);

		Yii::app()->user->setState('editmode',0);
		$this->redirect(array('view', 'id'=>$id));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($companyid)
	{
		Yii::app()->user->returnUrl = $this->createUrl('site/index');
		$dataProvider=new CActiveDataProvider('Levantamientos', array(
		    'criteria'=>array(
		        'condition'=>"empresaid= $companyid",
		        'order'=>'created DESC',
		),
		    'countCriteria'=>array(
		        'condition'=>"empresaid= $companyid",
		// 'order' and 'with' clauses have no meaning for the count query
		),
		    'pagination'=>array(
		        'pageSize'=>20,
		),
		));
		
		$company = Companies::model()->find("id=".$companyid);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'company'=>$company,
		));
	}
	public function actionReports($id){
		$model=$this->loadModel($id);
		Yii::app()->user->returnUrl = $this->createUrl('levantamientos/'.$model->id);
		//get forms
		$levantamientoarray = unserialize($model->formsactivos);
		$in = "(".implode(",", $levantamientoarray).")";
		$criteria = new CDbCriteria;  
		$criteria->addCondition('id IN '.$in);
		$forms = Forms::model()->findAll($criteria);
		
		$this->render('reports',array(
			'model'=>$model,
			'forms'=>$forms,
		));
		
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Levantamientos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Levantamientos::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Levantamientos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='levantamientos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
