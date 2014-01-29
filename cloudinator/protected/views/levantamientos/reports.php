<?php
$this->setPageTitle(Yii::t('contentForm', 'reports'));

$this->breadcrumbs=array(
Yii::t('contentForm', 'recordlevantamientos') => array('index', 'companyid'=>Yii::app()->user->getState('companyid')),
Yii::t('contentForm', 'reports'),
);

foreach ($forms as $form){
	echo "<h2>".$form->name." </h2><br>";
	$subforms = Subforms::model()->findAll("megatree = ".$form->id);
	foreach($subforms as $subform){
		
		$respuestas=new CActiveDataProvider('Respuestas', array(
				'criteria'=>array(
					'condition' => "levantamientoid=$model->id AND subformid=$subform->id ",
			),
			));
			
		if($respuestas->getItemCount() > 0){
			
			echo "<h3>->subform".$subform->name."</h3><br>";
			$this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$respuestas,
							'htmlOptions' => array("data-ajax"=>"false"),
							'columns'=>array(
								'preguntaid',
								'respuestaid',
								'respsubpregunta',
								'userid',
								'created',
								),
								));
		}
		
	}
}?>
<form action="<?php echo Yii::app()->user->returnUrl;?>" data-ajax="false">
	<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('contentForm', 'back')); ?>
	</div>
</form>
