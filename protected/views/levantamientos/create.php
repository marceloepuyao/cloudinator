<?php
/* @var $this LevantamientosController */
/* @var $model Levantamientos */
/* @var $forms array */
/* @var $users array */
/* @var $company array */

$this->setPageTitle($company['nombre']." - ".Yii::t('contentForm', 'newlevantamiento'));

$this->breadcrumbs=array(
	Yii::t('contentForm', 'recordlevantamientos')=>array('index', 'id'=>$model->id),
	Yii::t('contentForm', 'newlevantamiento'),
);

?>

<h2>
<?php echo Yii::t('contentForm', 'newlevantamiento');?>
</h2>

<?php $this->renderPartial('_form', array('model'=>$model, 'forms'=>$forms, 'users'=>$users)); ?>