<?php
/* @var $this SubformsController */
/* @var $model Subforms */
/* @var $modeltoclone Subforms */

$this->breadcrumbs=array(
	'Editor Formularios'=>array('editor/forms'),
	'Editor Subformularios'=>array('editor/subforms', 'id'=>$modeltoclone->megatree),
	'Clonar Subformulario: '.$modeltoclone->name,
);

?>
<h2>Clonar Subformulario: <?php echo $modeltoclone->name;?></h2>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>