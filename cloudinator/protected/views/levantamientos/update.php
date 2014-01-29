<?php
/* @var $this LevantamientosController */
/* @var $model Levantamientos */
/* @var $forms array */
/* @var $company array */

$this->setPageTitle($company['nombre']." - ".$model->titulo);
$this->breadcrumbs=array(
	'Levantamientos'=>array('index', 'companyid'=>$model->empresaid),
	$model->titulo=>array('view','id'=>$model->id),
	Yii::t('contentForm', 'edit'),
);

$this->menu=array(
array('label'=>'List Levantamientos', 'url'=>array('index')),
array('label'=>'Create Levantamientos', 'url'=>array('create')),
array('label'=>'View Levantamientos', 'url'=>array('view', 'id'=>$model->id)),
array('label'=>'Manage Levantamientos', 'url'=>array('admin')),
);
?>

<h1>
	Update Levantamientos
	<?php echo $model->id; ?>
</h1>

	<?php $this->renderPartial('_form', array('model'=>$model,  'forms'=>$forms, 'users'=>$users)); ?>