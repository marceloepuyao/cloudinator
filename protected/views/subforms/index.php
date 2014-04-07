<?php
/* @var $this SubformsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Subforms',
);

$this->menu=array(
	array('label'=>'Create Subforms', 'url'=>array('create')),
	array('label'=>'Manage Subforms', 'url'=>array('admin')),
);
?>

<h1>Subforms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
