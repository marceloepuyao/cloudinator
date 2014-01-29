<?php
/* @var $this RespuestasController */
/*'pregunta'=>$pregunta,
				'respuestas'=>$respuestas,
				'subform'=>$subform, 
				'levantamiento'=>$levantamiento,*/


$this->breadcrumbs=array(
	Yii::t('contentForm', 'recordlevantamientos')=>array('index', 'companyid'=>$levantamiento->empresaid),
	$levantamiento->titulo=> array('levantamientos/view', 'id'=>$levantamiento->id),
	'responder',
);

?>


<h2><?php echo $pregunta['name'];?></h2>

<div data-role="collapsible-set" data-theme="a" data-content-theme="d" data-iconpos="right">
<?php foreach ($respuestas as $respuesta){ ?>
		<a  href="<?php echo $this->createUrl('respuestas/index', array('subformid'=>$subform->id, 'levantamientoid' =>$levantamiento->id, 'respid'=>$respuesta['id'], 'pregid'=>$pregunta['id']));?>"  data-theme="c"  rel="external"  data-role="button" data-iconpos="top">
			<?php echo $respuesta['name']?>
		</a>
<?php }?>
</div>