<?php
/* @var $this SubformsController */
/* @var $model Subforms */
/*'form' => $form,*/

$this->breadcrumbs=array(
	'Editor Formularios'=>array('editor/forms'),
	'Editor Producto'=>array('editor/subforms', 'id'=>$form->id),
	'Nuevo Producto',
);

?>

<h2>Nuevo Producto</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>