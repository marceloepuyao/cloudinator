<?php
/* @var $this EditorController */
/*'subformpublicados'=>$subformpublicados,
 'subformnopublicados'=>$subformnopublicados,
 $formulario
 */

$this->breadcrumbs=array(
	'Editor Formularios'=>array('/editor'),
	'Editor Subformularios',
);
?>
<h2><?php echo "Formulario: ".$formulario->name; ?></h2>
<form style="text-align: right; vertical-align: top;" action="<?php echo Yii::app()->request->baseUrl."/subforms/create/id/".$formulario->id;?>" data-ajax="false">
	<div class="row buttons">
	<?php echo CHtml::submitButton("Nuevo Subformulario"); ?>
	</div>
</form>
<h2>Subformularios publicados</h2>
<?php $this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$subformpublicados,
							'htmlOptions' => array("data-ajax"=>"false"),
							'columns'=>array(
								array(
						            'name'=>'name',
								 	'type'=>'raw',
						            'value'=>'CHtml::link("$data->name",array("editor/cloudinator",
                                         "id"=>"$data->id"))',
						        ),
								'created',
								array(
									'class'=>'CButtonColumn',
									'template'=>'{update} {clone} {delete}  ',
											'buttons' => array(
													'update'=>array(
															'htmlOptions' => array("data-ajax"=>"false"),
															'url'=>'Yii::app()->createUrl("subforms/update", array("id"=>$data->id))',
															),
													'clone'=>array(
															'label' => 'Clonar',
															'htmlOptions' => array("data-ajax"=>"false"),
															'imageUrl' => Yii::app()->baseUrl.'/images/clone.jpg',
															'url'=>'Yii::app()->createUrl("subforms/clone", array("id"=>$data->id))',
															),
													'delete'=>array(
															'label' => 'Eliminar',
															'htmlOptions' => array("data-ajax"=>"false"),
															'url'=>'Yii::app()->createUrl("subforms/delete", array("id"=>$data->id))',
															),
											),
								),
								),
								));?>
								
<h2>Subformularios no publicados</h2>
<?php $this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$subformnopublicados,
							'htmlOptions' => array("data-ajax"=>"false"),
							'columns'=>array(
								array(
						            'name'=>'name',
								 	'type'=>'raw',
						            'value'=>'CHtml::link("$data->name",array("editor/cloudinator",
                                         "id"=>"$data->id"))',
						        ),
								'created',
								array(
									'class'=>'CButtonColumn',
									'template'=>'{publicar} {update} {clone} {delete}  ',
											'buttons' => array(
													'publicar'=>array(
															'htmlOptions' => array("data-ajax"=>"false"),
															'imageUrl' => Yii::app()->baseUrl.'/images/publish.gif',
															'url'=>'Yii::app()->createUrl("subforms/release", array("id"=>$data->id))',
															),
													'update'=>array(
															'htmlOptions' => array("data-ajax"=>"false"),
															'url'=>'Yii::app()->createUrl("subforms/update", array("id"=>$data->id))',
															),
													'clone'=>array(
															'label' => 'Clonar',
															'htmlOptions' => array("data-ajax"=>"false"),
															'imageUrl' => Yii::app()->baseUrl.'/images/clone.jpg',
															'url'=>'Yii::app()->createUrl("subforms/clone", array("id"=>$data->id))',
															),
													'delete'=>array(
															'label' => 'Eliminar',
															'htmlOptions' => array("data-ajax"=>"false"),
															'url'=>'Yii::app()->createUrl("subforms/delete", array("id"=>$data->id))',
															),
											),
								),
								),
								));?>
