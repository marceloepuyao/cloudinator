<?php
/* @var $this UsersController */
/* @var $model Users */

$this->setPageTitle(Yii::t('contentForm', 'managingusers')." - ".Yii::t('contentForm', 'addnewuser'));
$this->breadcrumbs=array(
Yii::t('contentForm', 'managingusers')=>array('index'),
Yii::t('contentForm', 'addnewuser'),
);

$this->menu=array(
array('label'=>'Manage Users', 'url'=>array('index')),
);
?>

<h2>
<?php echo Yii::t('contentForm', 'addnewuser');?>
</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>