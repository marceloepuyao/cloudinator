<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->breadcrumbs=array(
	Yii::t('contentForm', 'managingcompanies')=>array('index'),
	Yii::t('contentForm', 'newcompany'),
);
?>

<h2><?php echo Yii::t('contentForm', 'newcompany');?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>