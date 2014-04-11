<?php
$this->setPageTitle(Yii::t('contentForm', 'reports'));

$this->breadcrumbs=array(
Yii::t('contentForm', 'recordlevantamientos') => array('index', 'companyid'=>Yii::app()->user->getState('companyid')),
Yii::t('contentForm', 'reports'),
);

foreach ($forms as $form){
	echo "<h2>".$form->name." </h2><br>";
	$subforms = Subforms::model()->findAll("megatree = ".$form->id);
	$cloned = Clones::model()->findAll("formid = ".$form->id." && idlev = ".$model->id);
	foreach($subforms as $subform){
		
		echo "<h3>->".$subform->name."</h3><br>";
		$sql="	SELECT 
							r.*,
							pregunta.name AS preguntaname, 
							respuesta.name AS respuestaname 
						FROM registropreguntas r 
							INNER JOIN nodos AS pregunta ON r.preguntaid = pregunta.id 
							INNER JOIN nodos AS respuesta ON r.respuestaid = respuesta.id
						WHERE r.levantamientoid = $model->id AND subformid = $subform->id";
			$dataProvider=new CSqlDataProvider($sql);
			$this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$dataProvider,
							'htmlOptions' => array("data-ajax"=>"false"),
							'columns'=>array(
								array(
						            'name'=>'Pregunta',
									'type'=>'raw',
									'value'=>'$data["preguntaname"]', 
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
							));
		
	}
	foreach ($cloned as $clone){
		
		echo "<h3>->".$clone->name."</h3><br>";
		$sql="	SELECT 
				r.*,
				pregunta.name AS preguntaname, 
				respuesta.name AS respuestaname 
			FROM registropreguntas r 
				INNER JOIN nodos AS pregunta ON r.preguntaid = pregunta.id 
				INNER JOIN nodos AS respuesta ON r.respuestaid = respuesta.id
			WHERE r.levantamientoid = $model->id AND clonedid = $clone->id";
		$dataProvider=new CSqlDataProvider($sql);
		
		$this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$dataProvider,
							'htmlOptions' => array("data-ajax"=>"false"),
							'columns'=>array(
								array(
						            'name'=>'Pregunta',
									'type'=>'raw',
									'value'=>'$data["preguntaname"]', 
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
							));
		
		
		
		
	}
	
}?>







<form action="<?php echo Yii::app()->user->returnUrl;?>" data-ajax="false">
	<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('contentForm', 'back')); ?>
	</div>
</form>
