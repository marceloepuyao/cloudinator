<?php
/* @var $this RespuestasController */
/* @var $dataProvider CActiveDataProvider */
/* 'levantamiento' => $levantamiento,
				'subform' => $subform,
				'cloneid' => $cloneid,*/

$this->breadcrumbs=array(
	Yii::t('contentForm', 'recordlevantamientos')=>array('levantamientos/index', 'companyid'=>$levantamiento->empresaid),
	$levantamiento->titulo=> array('levantamientos/view', 'id'=>$levantamiento->id),
	$subform->name,
);
?>

<h3>Producto: <?php echo $subform->name?></h3>
<?php
			$this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$dataProvider,
							'htmlOptions' => array("data-ajax"=>"false"),
							'columns'=>array(
								array(
						            'name'=>'Pregunta',
									'type'=>'raw',
									'value'=>'CHtml::link($data["preguntaname"], array("respuestas/index",
                                         "subformid"=>"'.$subform->id.'",
                                         "levantamientoid"=>"'.$levantamiento->id.'",
                                         "cloneid"=>"'.$cloneid.'",
                                         "pregid"=> $data["preguntaid"] ))', 
						        ),
						        array(
						            'name'=>'Respuesta',
						        	'value'=>'$data["respuestaname"]',
						            
						        ),
						        array(
						            'name'=>'Respuesta Subpregunta',
						        	'value'=>'$data["respsubpregunta"]',
						            
						        ),
						         array(
						            'name'=>'userid',
						            'value'=>'$data["userid"]?(Users::model()->find("id=$data[userid]")->name." ".Users::model()->find("id=$data[userid]")->lastname):(0)'
						            
						        ),
								'created',
								),
							));?>
								
	<div class="row buttons">
	<?php echo CHtml::button(Yii::t('contentForm', 'back'),array(
                          'submit'=>$this->createUrl('levantamientos/view',array('id'=>$levantamiento->id))
                          )); ?>
	</div>
	


