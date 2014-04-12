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
<?php 

		$names = array();
		$companynames[0] =  Yii::t('contentForm', 'newcompany');
		foreach ($companies as $company){
			$companynames[$company['id']] = $company['nombre'];
		}
 		//die(var_dump($companynames));

?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
        'clientOptions'=>array(
                'validateOnSubmit'=>true,
        ),  
	'htmlOptions' => array("data-ajax"=>"false", 'class' => 'grid-view rounded'),   
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
