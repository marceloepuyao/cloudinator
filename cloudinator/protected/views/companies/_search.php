<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
	<?php echo $form->label($model,'id'); ?>
	<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'nombre'); ?>
	<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'industria'); ?>
	<?php echo $form->textField($model,'industria',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'info'); ?>
	<?php echo $form->textField($model,'info',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'modified'); ?>
	<?php echo $form->textField($model,'modified'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
