<?php
/* @var $this UsersController */
/* @var $model Users */
$this->setPageTitle(Yii::t('contentForm', 'managingusers')." - ".$model->name." ".$model->lastname);

$this->breadcrumbs=array(
	Yii::t('contentForm', 'managingusers')=>array('index'),
	$model->name." ".$model->lastname,
);
?>

<h2>
	<?php echo $model->name." ".$model->lastname;?>
</h2>

	<?php $this->renderPartial('_form', array('model'=>$model)); ?>