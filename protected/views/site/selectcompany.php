<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
/* @var $companynames array */

$this->setPageTitle(Yii::app()->name);
/*
$this->breadcrumbs=array(
Yii::t('contentForm', 'home'),
);*/
?>



<h2 style="text-align: center" >
	<?php echo Yii::t('contentForm', 'selectcompany');?>
</h2>


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

	<table style="width: 100%; margin: 0 auto;">
		<tr>
			<td><?php echo $form->labelEx($model,'company'); ?>
			</td>
			<td>
				<div class="row">
				<?php echo $form->dropDownList($model, 'company', $companynames); ?>
				<?php echo $form->error($model,'company'); ?>
				</div>
			</td>
		</tr>
	</table>

	<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('contentForm', 'continue')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div>
<!-- form -->
