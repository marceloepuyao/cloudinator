<?php
/* @var $this UsersController */
/* @var $model Users */

$this->setPageTitle(Yii::t('contentForm', 'managingusers'));

$this->breadcrumbs=array(
Yii::t('contentForm', 'managingusers')=>array('index'),
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
<?php echo Yii::t('contentForm', 'managingusers');?>
</h2>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'htmlOptions' => array("data-ajax"=>"false"),
	'columns'=>array(
		'email',
		'name',
		'lastname',
		'lang',
		'lastaccess',
		 array(
            'name'=>'superuser',
            'filter'=>array('1'=>"Yii::t('contentForm', 'yes')",'0'=>'No'),
            'value'=>'($data->superuser=="1")?("'.Yii::t("contentForm", "yes").'"):("No")'
        ),

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


<form action="<?php echo Yii::app()->request->baseUrl."/users/create";?>" data-ajax="false">
	<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('contentForm', 'addnewuser')); ?>
	</div>
</form>
<script type="text/javascript">

	$( document ).ready(function() {
		$('.ui-link').each(function(){
			$(this).attr('rel', 'external');
		});
		$('.ui-link:visited').each(function(){
			$(this).css('color', 'white');
		});
	});
</script>