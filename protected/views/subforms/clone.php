<?php
/* @var $this SubformsController */
/* @var $model Subforms */
/* @var $modeltoclone Subforms */

$this->breadcrumbs=array(
	'Editor Formularios'=>array('editor/forms'),
	'Editor Producto'=>array('editor/subforms', 'id'=>$modeltoclone->megatree),
	'Clonar Producto: '.$modeltoclone->name,
);

?>
<h2>Clonar Producto: <?php echo $modeltoclone->name;?></h2>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>