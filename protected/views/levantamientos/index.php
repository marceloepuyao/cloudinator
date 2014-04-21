<?php
/* @var $this LevantamientosController */
/* @var $dataProvider CActiveDataProvider */
/* @var $company */

$this->setPageTitle($company['nombre']);

$this->breadcrumbs=array(
Yii::t('contentForm', 'recordlevantamientos')." - ".$company['nombre'],
);

/*
 $this->menu=array(
 array('label'=>'Create Levantamientos', 'url'=>array('create')),
 array('label'=>'Manage Levantamientos', 'url'=>array('admin')),
 );*/
?>

<h2>
<?php echo Yii::t('contentForm', 'recordlevantamientos');?>
</h2>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'levantamientos-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
				array(
		            'name'=>'titulo',
					'type'=>'raw',
		            'value'=>'CHtml::link($data->titulo,array("levantamientos/$data->id"))',
		        ),
				'modified',
				'info',
				array(
					'class'=>'CButtonColumn',
					'template'=>'{view} {update} {delete}  ',
					'buttons' => array(
							'view'=>array(
									'label'=>'Recorrer',
									'imageUrl' => Yii::app()->baseUrl.'/images/play-icon.png',
									'htmlOptions' => array("data-ajax"=>"false", 'class' => 'grid-view rounded'),
									),
					),
				),
	),
)); ?>
<form action="<?php Yii::app()->request->baseUrl;?>levantamientos/create" data-ajax="false">
	<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('contentForm', 'newlevantamiento')); ?>
	</div>
</form>



