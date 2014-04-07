<?php
/* @var $this RespuestasController */
/*'pregunta'=>$pregunta,
				'respuestas'=>$respuestas,
				'subform'=>$subform, 
				'levantamiento'=>$levantamiento,
				'cloneid'=>$cloneid,*/


$this->breadcrumbs=array(
	Yii::t('contentForm', 'recordlevantamientos')=>array('levantamientos/index', 'companyid'=>$levantamiento->empresaid),
	$levantamiento->titulo=> array('levantamientos/view', 'id'=>$levantamiento->id),
	'responder',
);

?>


<h2><?php echo $pregunta['name'];?></h2>

<div data-role="collapsible-set" data-theme="a" data-content-theme="d" data-iconpos="right">
<?php foreach ($respuestas as $respuesta){ ?>
		<?php $theme = "c";
		if($respuesta['id']==$record){
			$theme = "b";
		}?>
		
		<a href="<?php echo $this->createUrl('respuestas/index', array('subformid'=>$subform->id, 'levantamientoid' =>$levantamiento->id,'cloneid'=>$cloneid, 'respid'=>$respuesta['id'], 'pregid'=>$pregunta['id']));?>"  data-theme="<?php echo $theme;?>"  rel="external"  data-role="button" data-iconpos="top">
			<?php echo $respuesta['name']?>
		</a>
<?php }?>
</div>