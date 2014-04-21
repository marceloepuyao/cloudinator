<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name;
/*
$this->breadcrumbs=array(
	Yii::t('contentForm', 'login'),
);*/
?>

<h2>
<?php echo Yii::t('contentForm', 'login');?>
</h2>

<p>
<?php echo Yii::t('contentForm', 'pleaselogin');?>
</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
    'clientOptions'=>array(
    	'validateOnSubmit'=>true,
   	),  
	'htmlOptions' => array("data-ajax"=>"false"),
)); ?>
	<p class="note">
		<span class="required">*</span>
		<?php echo Yii::t('contentForm', 'fieldrequired');?>.
	</p>

	<div class="row">
	<?php echo $form->labelEx($model,'username'); ?>
	<?php echo $form->textField($model,'username'); ?>
	<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	</div>
	<br></br>
	<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('contentForm', 'login')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div>
<!-- form -->

<script type="text/javascript">
<!--
$( document ).ready(function() {
	
});

//-->
</script>
