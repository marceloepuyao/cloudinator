<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'companies-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'focus'=>array($model,'titulo'),
	'clientOptions'=>array(
        'validateOnSubmit'=>true,       
	),
    'htmlOptions' => array (
		"data-ajax"=>"false",
      ),
)); ?>

	<p class="note">
		<span class="required">*</span>
		<?php echo Yii::t('contentForm', 'fieldrequired');?>
		.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php echo $form->labelEx($model,'nombre'); ?>
	<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>500)); ?>
	<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'industria'); ?>
	<?php echo $form->textField($model,'industria',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'industria'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'info'); ?>
	<?php echo $form->textArea($model,'info',array('size'=>60,'maxlength'=>500)); ?>
	<?php echo $form->error($model,'info'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('contentForm', 'create'): Yii::t('contentForm', 'save'), array("data-theme"=>"b")); ?>
	</div>
	<div class="row buttons">
		<a data-role="button" href="<?php echo Yii::app()->request->baseUrl."/companies/index";?>" rel="external" data-theme="c"><?php echo Yii::t('contentForm', 'cancel');?></a>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- form -->
