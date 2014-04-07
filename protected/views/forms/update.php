<?php
/* @var $this FormsController */
/* @var $model Forms */

$this->breadcrumbs=array(
	'Editor Formularios'=>array('editor/forms'),
	'Actualizar '.$model->name,
);

?>
<h2>Actualizar <?php echo $model->name;?>.<?php echo $model->id; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>