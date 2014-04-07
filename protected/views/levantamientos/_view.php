<?php
/* @var $this LevantamientosController */
/* @var $data Levantamientos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('titulo')); ?>:</b>
	<?php echo CHtml::encode($data->titulo); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('empresaid')); ?>:</b>
	<?php echo CHtml::encode($data->empresaid); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('info')); ?>:</b>
	<?php echo CHtml::encode($data->info); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('formsactivos')); ?>:</b>
	<?php echo CHtml::encode($data->formsactivos); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('conctadopor')); ?>:</b>
	<?php echo CHtml::encode($data->conctadopor); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('areacontacto')); ?>:</b>
	<?php echo CHtml::encode($data->areacontacto); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('completitud')); ?>:</b>
	<?php echo CHtml::encode($data->completitud); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('deleted')); ?>:</b>
	<?php echo CHtml::encode($data->deleted); ?>
	<br />


</div>
