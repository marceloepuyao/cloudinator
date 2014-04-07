<?php
/* @var $this LevantamientosController */
/* @var $model Levantamientos */
/* @var $forms array */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'levantamientos-form',
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
		<?php echo Yii::t('contentForm', 'fieldrequired');?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php echo $form->labelEx($model,'titulo'); ?>
	<?php echo $form->textField($model,'titulo',array('size'=>60,'maxlength'=>150)); ?>
	<?php echo $form->error($model,'titulo'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'info'); ?>
	<?php echo $form->textField($model,'info',array('size'=>60,'maxlength'=>500)); ?>
	<?php echo $form->error($model,'info'); ?>
	</div>


	
	<div class="row">
	<?php echo $form->labelEx($model,'conctadopor'); ?>
	<?php echo $form->dropDownList($model, 'conctadopor', $users, array('empty'=>Yii::t('contentForm', 'contactedby'))); ?>
	<?php echo $form->error($model,'conctadopor'); ?>
	</div>
			



	<div class="row">
	<?php echo $form->labelEx($model,'areacontacto'); ?>
	<?php echo $form->textField($model,'areacontacto',array('size'=>60,'maxlength'=>100)); ?>
	<?php echo $form->error($model,'areacontacto'); ?>
	</div>

	<div class="row">
		<fieldset data-role="controlgroup">
		<?php echo $form->labelEx($model,'forms'); ?>
		<?php echo $form->checkBoxList($model, 'forms', $forms); ?>
		<?php echo $form->error($model,'forms'); ?>
		</fieldset>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('contentForm', 'create'): Yii::t('contentForm', 'save'), array("data-theme"=>"b")); ?>
	</div>
	<div class="row buttons">
		<a data-role="button" href="<?php echo Yii::app()->request->baseUrl."/levantamientos?companyid=".Yii::app()->user->getState("companyid");?>" rel="external" data-theme="c"><?php echo Yii::t('contentForm', 'cancel');?></a>
	</div>
	<?php $this->endWidget(); ?>

</div>
<!-- form -->
