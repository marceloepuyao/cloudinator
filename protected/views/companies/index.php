<?php
/* @var $this CompaniesController */
/* @var $dataProvider CActiveDataProvider */
/* @var $dataProvider CActiveDataProvider */

$this->setPageTitle(Yii::t('contentForm', 'managingcompanies'));
$this->breadcrumbs=array(
	Yii::t('contentForm', 'managingcompanies'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>
<?php echo  Yii::t('contentForm', 'managingcompanies');?>
</h2>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'htmlOptions' => array("data-ajax"=>"false"),
	'columns'=>array(
		'nombre',
		 array(
            'name'=>'industria',
            'value'=>'Yii::t("contentForm", "$data->industria")',//.Yii::t('contentForm', '$data->industria'),
        ),
		'info',
		'modified',

		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {update} {delete}  ',
					'buttons' => array(
							'view'=>array(
									'htmlOptions' => array("data-ajax"=>"false"),
									),
							'update'=>array(
									'htmlOptions' => array("data-ajax"=>"false"),
									),
							'delete'=>array(
									'htmlOptions' => array("data-ajax"=>"false"),
									),
					),
		),
	),
)); ?>

<form action="<?php echo Yii::app()->request->baseUrl."/companies/create";?>" data-ajax="false">
	<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('contentForm', 'addnewcompany')); ?>
	</div>
</form>


