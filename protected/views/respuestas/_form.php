<?php
/* @var $this RespuestasController */
/* @var $model Respuestas */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'respuestas-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'preguntaid'); ?>
		<?php echo $form->textField($model,'preguntaid'); ?>
		<?php echo $form->error($model,'preguntaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'respuestaid'); ?>
		<?php echo $form->textField($model,'respuestaid'); ?>
		<?php echo $form->error($model,'respuestaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subformid'); ?>
		<?php echo $form->textField($model,'subformid'); ?>
		<?php echo $form->error($model,'subformid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formid'); ?>
		<?php echo $form->textField($model,'formid'); ?>
		<?php echo $form->error($model,'formid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'levantamientoid'); ?>
		<?php echo $form->textField($model,'levantamientoid'); ?>
		<?php echo $form->error($model,'levantamientoid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userid'); ?>
		<?php echo $form->textField($model,'userid'); ?>
		<?php echo $form->error($model,'userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'empresaid'); ?>
		<?php echo $form->textField($model,'empresaid'); ?>
		<?php echo $form->error($model,'empresaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'respsubpregunta'); ?>
		<?php echo $form->textField($model,'respsubpregunta',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'respsubpregunta'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clonedid'); ?>
		<?php echo $form->textField($model,'clonedid'); ?>
		<?php echo $form->error($model,'clonedid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->