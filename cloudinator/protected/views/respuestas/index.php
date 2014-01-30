<?php
/* @var $this RespuestasController */
/* @var $dataProvider CActiveDataProvider */
/* 'levantamiento' => $levantamiento,
				'subform' => $subform,*/

$this->breadcrumbs=array(
	Yii::t('contentForm', 'recordlevantamientos')=>array('levantamientos/index', 'companyid'=>$levantamiento->empresaid),
	$levantamiento->titulo=> array('levantamientos/view', 'id'=>$levantamiento->id),
	$subform->name,
);
?>

<h3>Subformulario: <?php echo $subform->name?></h3>
<?php
			$this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$dataProvider,
							'htmlOptions' => array("data-ajax"=>"false"),
							'columns'=>array(
								array(
						            'name'=>'preguntaname',
									'type'=>'raw',
						            
						        ),
						        array(
						            'name'=>'respuestaname',
						            
						        ),
								'respsubpregunta',
						         array(
						            'name'=>'userid',
						        ),
								'created',
								),
							));?>
								
	<div class="row buttons">
	<?php echo CHtml::button(Yii::t('contentForm', 'back'),array(
                          'submit'=>$this->createUrl('levantamientos/view',array('id'=>$levantamiento->id))
                          )); ?>
	</div>

