<?php
/* @var $this RespuestasController */
/* @var $pregunta array  */
/*	'respuestas'=>$respuestas,
	'subformid'=>$subformid, 
	'levantamientoid'=>$levantamientoid,*/


$this->breadcrumbs=array(
	'Respuestases',
);

$this->menu=array(
	array('label'=>'Create Respuestas', 'url'=>array('create')),
	array('label'=>'Manage Respuestas', 'url'=>array('admin')),
);
?>

<h1>Responder</h1>

<h2><?php echo $pregunta['name'];?></h2>

<div data-role="collapsible-set" data-theme="a" data-content-theme="d" data-iconpos="right">
<?php foreach ($respuestas as $respuesta){ ?>
		<a  href="<?php echo $this->createUrl('respuestas/index', array('subformid'=>$subformid, 'levantamientoid' =>$levantamientoid, 'respid'=>$respuesta['id'], 'pregid'=>$pregunta['id']));?>"  data-theme="c"  rel="external"  data-role="button" data-iconpos="top">
			<?php echo $respuesta['name']?>
		</a>
<?php }?>
</div>