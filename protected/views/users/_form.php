<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'focus'=>array($model,'email'),
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
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model, 'email'); ?>
	<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'lastname'); ?>
	<?php echo $form->textField($model,'lastname',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,$model->isNewRecord ? 'password':'newpassword'); ?>
	<?php echo $form->passwordField($model,$model->isNewRecord ? 'password':'newpassword',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,$model->isNewRecord ? 'password':'newpassword'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'confirmpassword'); ?>
	<?php echo $form->passwordField($model,'confirmpassword',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'confirmpassword'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'lang'); ?>
	<?php echo $form->dropDownList($model, 'lang', array('es'=>'es', 'pt'=>'pt', 'en'=>'en'));?>
	<?php echo $form->error($model,'lang'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'superuser'); ?>
	<?php echo $form->checkBox($model, 'superuser'); ?>
	<?php echo $form->error($model,'superuser'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('contentForm', 'create'): Yii::t('contentForm', 'save'), array("data-theme"=>"b")); ?>
	</div>
	<div class="row buttons">
		<a data-role="button" href="<?php echo Yii::app()->user->returnUrl;?>" rel="external" data-theme="c"><?php echo Yii::t('contentForm', 'cancel');?></a>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- form -->
