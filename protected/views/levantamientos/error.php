<?php

$this->setPageTitle($company['nombre']);
$this->breadcrumbs=array(
Yii::t('contentForm', 'recordlevantamientos')=>array('index', 'companyid'=>$model->empresaid),
$model->titulo,
);

?>
<h2>
<?php echo Yii::t('contentForm', 'recordlevantamientos');?>
</h2>

<p>No hay Propuestas Tipo seleccionados para este Levantamiento</p>
Seleccione Propuestas Tipo en <?php echo CHtml::link('Editar Levantamiento',array('levantamientos/update', 'id'=>$model->id)); ?>

<div class="row buttons">
	<?php echo CHtml::button("Volver", array("submit"=>$this->createUrl('levantamientos/index', array("companyid"=>$model->empresaid)), "data-ajax"=>"false")); ?>
	</div>