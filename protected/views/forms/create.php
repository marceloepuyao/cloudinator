<?php
/* @var $this FormsController */
/* @var $model Forms */

$this->breadcrumbs=array(
	'Editor Formularios'=>array('editor/forms'),
	'Nuevo Formulario',
);

?>

<h2>Nueva Propuesta Tipo</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>