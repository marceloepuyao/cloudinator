<?php
/* @var $this RespuestasController */
/* @var $data Respuestas */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('preguntaid')); ?>:</b>
	<?php echo CHtml::encode($data->preguntaid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('respuestaid')); ?>:</b>
	<?php echo CHtml::encode($data->respuestaid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subformid')); ?>:</b>
	<?php echo CHtml::encode($data->subformid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formid')); ?>:</b>
	<?php echo CHtml::encode($data->formid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('levantamientoid')); ?>:</b>
	<?php echo CHtml::encode($data->levantamientoid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userid')); ?>:</b>
	<?php echo CHtml::encode($data->userid); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('empresaid')); ?>:</b>
	<?php echo CHtml::encode($data->empresaid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('respsubpregunta')); ?>:</b>
	<?php echo CHtml::encode($data->respsubpregunta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clonedid')); ?>:</b>
	<?php echo CHtml::encode($data->clonedid); ?>
	<br />

	*/ ?>

</div>