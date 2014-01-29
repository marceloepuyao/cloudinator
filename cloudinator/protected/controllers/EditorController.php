<?php

class EditorController extends Controller
{
	function init()
	{
		

		Yii::app()->user->setState('mobile', false);
		$this->layout='main';
		Yii::app()->language = "es";
		parent::init();
	
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
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','forms', 'subforms','upgrade', 'cloudinator'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionForms()
	{
		$formvisibles =new CActiveDataProvider('Forms', array(
				'criteria'=>array(
					'condition' => "visible=1 AND deleted = 0",
			),
			));
		$formnovisibles = new CActiveDataProvider('Forms', array(
				'criteria'=>array(
					'condition' => "visible=0 AND deleted = 0",
			),
			));
		$this->render('forms',array(
			'formvisibles'=>$formvisibles,
			'formnovisibles'=>$formnovisibles,
		));
		
	}

	public function actionIndex()
	{
		$this->redirect(array('forms'));
	}
	
	public function actionCloudinator($id)
	{
		$subformulario = Subforms::model()->find("id = $id");
		$this->renderPartial('cloudinator',array(
			'subformulario'=>$subformulario,
		));
	}

	public function actionSubforms($id)
	{
		$formulario = Forms::model()->find("id = $id");
		$subformpublicados =new CActiveDataProvider('Subforms', array(
				'criteria'=>array(
					'condition' => "released=1 AND megatree = $formulario->id AND deleted = 0",
			),
			));
		$subformnopublicados = new CActiveDataProvider('Subforms', array(
				'criteria'=>array(
					'condition' => "released=0 AND megatree = $formulario->id AND deleted = 0",
			),
			));
		$this->render('subforms',array(
			'formulario' => $formulario,
			'subformpublicados'=>$subformpublicados,
			'subformnopublicados'=>$subformnopublicados,
		));
	}
	public function actionUpgrade()
	{
		$this->renderPartial('upgrade');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}*/

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

}