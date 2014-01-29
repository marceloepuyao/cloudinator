<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->setPageTitle(Yii::t('contentForm', 'managingcompanies')." - ".$model->nombre);
$this->breadcrumbs=array(
	Yii::t('contentForm', 'managingcompanies')=>array('index'),
	$model->nombre,
);

$this->menu=array(
array('label'=>'List Companies', 'url'=>array('index')),
array('label'=>'Create Companies', 'url'=>array('create')),
array('label'=>'View Companies', 'url'=>array('view', 'id'=>$model->id)),
array('label'=>'Manage Companies', 'url'=>array('admin')),
);
?>

<h2>
	<?php echo $model->nombre; ?>
</h2>

	<?php $this->renderPartial('_form', array('model'=>$model)); ?>