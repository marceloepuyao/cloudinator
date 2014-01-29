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
						            'name'=>'preguntaid',
									'type'=>'raw',
						            'value'=>'CHtml::link(Nodos::model()->find("id=$data->preguntaid")->name, array("respuestas/index",
                                         "subformid"=>'.$subform->id.',
                                         "levantamientoid"=>'.$levantamiento->id.',
                                         "pregid"=>"$data->id"))',
						        ),
						        array(
						            'name'=>'respuestaid',
						            'value'=>'Nodos::model()->find("id=$data->respuestaid")->name'
						        ),
								'respsubpregunta',
						         array(
						            'name'=>'userid',
						            'value'=>'$data->userid?(Users::model()->find("id=$data->userid")->name." ".Users::model()->find("id=$data->userid")->lastname):(0)'
						        ),
								'created',
								),
								));?>
								
	<div class="row buttons">
	<?php echo CHtml::button(Yii::t('contentForm', 'back'),array(
                          'submit'=>$this->createUrl('levantamientos/view',array('id'=>$levantamiento->id))
                          )); ?>
	</div>

