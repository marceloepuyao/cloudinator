<?php
/* @var $this RespuestasController */
/* @var $model Respuestas */

$this->breadcrumbs=array(
	'Respuestas'=>array('index'),
	$model->id,
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
