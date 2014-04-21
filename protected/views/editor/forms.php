<?php
/* @var $this EditorController */
/*'formvisibles'=>$formvisibles,
 'formnovisibles'=>$formnovisibles,*/

$this->breadcrumbs=array(
	'Propuestas Tipo',
);
?>
<br/>
<?php /*
(*) Notas:<br/>
-Las Propuesta Tipo sirven para hacer agrupaciones de productos.<br/>
-Las Propuesta Tipo Ocultas no serán visibles en la interfaz de ejecutor.<br/>
*/?>

<form style="text-align: right; vertical-align: top;" action="<?php echo Yii::app()->request->baseUrl."/forms/create";?>" data-ajax="false">
	<div class="row buttons">
	<?php echo CHtml::submitButton("Nueva Propuesta Tipo"); ?>
	</div>
</form>
<div style ="float:left;width:47%;">
<h3>Propuestas Tipo Visibles</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$formvisibles,
							'htmlOptions' => array("data-ajax"=>"false"),
							'columns'=>array(
								array(
						            'name'=>'name',
								 	'type'=>'raw',
						            'value'=>'CHtml::link("$data->name",array("editor/subforms",
                                         "id"=>"$data->id"))',
						        ),
								'created',
								array(
									'class'=>'CButtonColumn',
									'template'=>'{update} {visible} {delete}  ',
											'buttons' => array(
													'update'=>array(
															'htmlOptions' => array("data-ajax"=>"false"),
															'url'=>'Yii::app()->createUrl("forms/update", array("id"=>$data->id))',
															),
													'visible'=>array(
															'label' => 'Dejar Oculto',
															'htmlOptions' => array("data-ajax"=>"false"),
															'imageUrl' => Yii::app()->baseUrl.'/images/novisible.jpg',
															'url'=>'Yii::app()->createUrl("forms/setnovisible", array("id"=>$data->id))',
															),
													'delete'=>array(
															'label' => 'Eliminar',
															'htmlOptions' => array("data-ajax"=>"false"),
															'url'=>'Yii::app()->createUrl("forms/delete", array("id"=>$data->id))',
															),
											),
								),
								),
								));?>
</div>
								
<div style ="float:right;width:47%;">
<h3>Propuestas Tipo Ocultas</h3>						
<?php $this->widget('zii.widgets.grid.CGridView', array(
							'dataProvider'=>$formnovisibles,
							'htmlOptions' => array("data-ajax"=>"false"),
							
							'columns'=>array(
								 array(
						            'name'=>'name',
								 	'type'=>'raw',
						            'value'=>'CHtml::link("$data->name",array("editor/subforms",
                                         "id"=>"$data->id"))',
						        ),
						        'created',
								
								array(
									'class'=>'CButtonColumn',
									'template'=>'{update} {novisible} {delete}  ',
											'buttons' => array(
													'update'=>array(
															'htmlOptions' => array("data-ajax"=>"false"),
															'url'=>'Yii::app()->createUrl("forms/update", array("id"=>$data->id))',
															),
													'novisible'=>array(
															'label' => 'Dejar Visible',
															'htmlOptions' => array("data-ajax"=>"false"),
															'imageUrl' => Yii::app()->baseUrl.'/images/visible.jpg',
															'url'=>'Yii::app()->createUrl("forms/setvisible", array("id"=>$data->id))',
															),
													'delete'=>array(
															'label' => 'Eliminar',
															'htmlOptions' => array("data-ajax"=>"false"),
															'url'=>'Yii::app()->createUrl("forms/delete", array("id"=>$data->id))',
															),
											),
								),
								),
								));?>
								
								</div>

						
								
								





