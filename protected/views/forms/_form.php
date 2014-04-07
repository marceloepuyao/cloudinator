<?php
/* @var $this FormsController */
/* @var $model Forms */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forms-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'focus'=>array($model,'name'),
)); ?>

	<p class="note"><span class="required">*</span> Campo Requerido.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visible'); ?>
		<?php echo $form->radioButton($model,'visible'); ?>
		<?php echo $form->error($model,'visible'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
		<?php echo CHtml::button('Cancelar', array('submit' => array('editor/forms'))); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->