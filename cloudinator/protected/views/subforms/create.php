<?php
/* @var $this SubformsController */
/* @var $model Subforms */
/*'form' => $form,*/

$this->breadcrumbs=array(
	'Editor Formularios'=>array('editor/forms'),
	'Editor Subformularios'=>array('editor/subforms', 'id'=>$form->id),
	'Nuevo Subformulario',
);

?>

<h2>Nuevo Subformulario</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>