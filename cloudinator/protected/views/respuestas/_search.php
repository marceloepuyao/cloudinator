<?php
/* @var $this RespuestasController */
/* @var $model Respuestas */
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
		<?php echo $form->label($model,'preguntaid'); ?>
		<?php echo $form->textField($model,'preguntaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'respuestaid'); ?>
		<?php echo $form->textField($model,'respuestaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subformid'); ?>
		<?php echo $form->textField($model,'subformid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'formid'); ?>
		<?php echo $form->textField($model,'formid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'levantamientoid'); ?>
		<?php echo $form->textField($model,'levantamientoid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userid'); ?>
		<?php echo $form->textField($model,'userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'empresaid'); ?>
		<?php echo $form->textField($model,'empresaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'respsubpregunta'); ?>
		<?php echo $form->textField($model,'respsubpregunta',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clonedid'); ?>
		<?php echo $form->textField($model,'clonedid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->