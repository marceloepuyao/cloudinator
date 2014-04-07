<?php
/* @var $this UsersController */
/* @var $model Users */
$this->setPageTitle(Yii::t('contentForm', 'managingusers')." - ".$model->name." ".$model->lastname);

$this->breadcrumbs=array(
	Yii::t('contentForm', 'managingusers')=>array('index'),
$model->name." ".$model->lastname,
);

$this->menu=array(
array('label'=>'Manage Users', 'url'=>array('index')),
array('label'=>'Create Users', 'url'=>array('create')),
array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->id)),
array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h2>
	<?php echo $model->name." ".$model->lastname;	?>
</h2>

	<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email',
		'name',
		'lastname',
		'lang',
		'lastaccess',
		'firstaccess',
		'modified',
		 array(
            'name'=>'superuser',
            'filter'=>array('1'=>Yii::t('contentForm', 'yes'),'0'=>'No'),
            'value'=>($model->superuser=="1")?(Yii::t("contentForm", "yes")):("No"),
        ),
	),
	)); ?>
	
<form action="<?php echo Yii::app()->user->returnUrl?>" data-ajax="false">
	<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('contentForm', 'back')); ?>
	</div>
</form>
