<?php
/* @var $this SubformsController */
/* @var $model Subforms */

$this->breadcrumbs=array(
	'Editor Formularios'=>array('editor/forms'),
	'Editor Productos'=>array('editor/subforms','id'=>$model->megatree),
	'Actualizar '.$model->name,
);
?>
<h2> Actualizar <?php echo $model->name;?> </h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>