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
array('label'=>'Update Companies', 'url'=>array('update', 'id'=>$model->id)),
array('label'=>'Delete Companies', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Companies', 'url'=>array('admin')),
);
?>

<h2>
	<?php echo $model->nombre; ?>
</h2>

	<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		'industria',
		'info',
		'modified',
	),
	)); ?>
	
	<form action="<?php echo Yii::app()->user->returnUrl;?>" data-ajax="false">
		<div class="row buttons">
			<?php echo CHtml::submitButton(Yii::t('contentForm', 'back')); ?>
		</div>
	</form>
	
