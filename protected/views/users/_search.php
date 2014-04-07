<?php
/* @var $this UsersController */
/* @var $model Users */
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
	<?php echo $form->label($model,'email'); ?>
	<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'lastname'); ?>
	<?php echo $form->textField($model,'lastname',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'firstaccess'); ?>
	<?php echo $form->textField($model,'firstaccess'); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'lastaccess'); ?>
	<?php echo $form->textField($model,'lastaccess'); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'lang'); ?>
	<?php echo $form->textField($model,'lang',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'modified'); ?>
	<?php echo $form->textField($model,'modified'); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'superuser'); ?>
	<?php echo $form->textField($model,'superuser'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
