<?php
/* @var $this LevantamientosController */
/* @var $model Levantamientos */
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
	<?php echo $form->label($model,'titulo'); ?>
	<?php echo $form->textField($model,'titulo',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'empresaid'); ?>
	<?php echo $form->textField($model,'empresaid'); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'info'); ?>
	<?php echo $form->textField($model,'info',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'formsactivos'); ?>
	<?php echo $form->textField($model,'formsactivos',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'conctadopor'); ?>
	<?php echo $form->textField($model,'conctadopor',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'areacontacto'); ?>
	<?php echo $form->textField($model,'areacontacto',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'completitud'); ?>
	<?php echo $form->textField($model,'completitud',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'created'); ?>
	<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'modified'); ?>
	<?php echo $form->textField($model,'modified'); ?>
	</div>

	<div class="row">
	<?php echo $form->label($model,'deleted'); ?>
	<?php echo $form->textField($model,'deleted'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
