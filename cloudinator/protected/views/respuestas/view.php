<?php
/* @var $this RespuestasController */
/* @var $model Respuestas */

$this->breadcrumbs=array(
	'Respuestases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Respuestas', 'url'=>array('index')),
	array('label'=>'Create Respuestas', 'url'=>array('create')),
	array('label'=>'Update Respuestas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Respuestas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Respuestas', 'url'=>array('admin')),
);
?>

<h1>View Respuestas #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'preguntaid',
		'respuestaid',
		'subformid',
		'formid',
		'levantamientoid',
		'userid',
		'empresaid',
		'created',
		'respsubpregunta',
		'clonedid',
	),
)); ?>
