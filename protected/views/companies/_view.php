<?php
/* @var $this CompaniesController */
/* @var $data Companies */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('industria')); ?>:</b>
	<?php echo CHtml::encode($data->industria); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('info')); ?>:</b>
	<?php echo CHtml::encode($data->info); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />


</div>
