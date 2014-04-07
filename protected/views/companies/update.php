<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->setPageTitle(Yii::t('contentForm', 'managingcompanies')." - ".$model->nombre);
$this->breadcrumbs=array(
	Yii::t('contentForm', 'managingcompanies')=>array('index'),
	$model->nombre,
);

?>
<h2>
	<?php echo $model->nombre; ?>
</h2>

	<?php $this->renderPartial('_form', array('model'=>$model)); ?>