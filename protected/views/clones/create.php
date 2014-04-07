<?php
/* @var $this ClonesController */
/* @var $model Clones */
/* 'subform'=>$subform,*/ 
/*'levantamiento' => $levantamiento,*/

$this->breadcrumbs=array(
	Yii::t('contentForm', 'recordlevantamientos')=>array('index', 'companyid'=>$levantamiento->empresaid),
	$levantamiento->titulo => array('levantamientos/view', 'id'=>$levantamiento->id),
	"Clone: $subform->name",
);
?>
<h2>Clone: <?php echo $subform->name;?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>