<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<style type="text/css" media="screen">
		body{
			display: block;
			margin: 0px;
		}
		h1 {
			color: black;
		}
		#newTreeName{
			display: none;
			position: absolute;
			top: 40%;
			left: 35%;
			height: 100px;
			width: 300px;
			text-align: center;
			z-index: 90002;
			background-color: #FFFFFF;
			border: 5px groove #9090dd;
		}
		#newFormName{
			display: none;
			position: absolute;
			top: 40%;
			left: 35%;
			height: 100px;
			width: 300px;
			text-align: center;
			z-index: 90002;
			background-color: #FFFFFF;
			border: 5px groove #9090dd;
		}
		#copyTreeName{
			display: none;
			position: absolute;
			top: 40%;
			left: 35%;
			height: 100px;
			width: 300px;
			text-align: center;
			z-index: 90002;
			background-color: #FFFFFF;
			border: 5px groove #9090dd;
		}
		#cloneFormName{
			display: none;
			position: absolute;
			top: 40%;
			left: 35%;
			height: 130px;
			width: 300px;
			text-align: center;
			z-index: 90002;
			background-color: #FFFFFF;
			border: 5px groove #9090dd;
		}
		#notices{
			position: fixed;
			top: 0;
			left: 40%;
			width: 20%;
			text-align: center;
			z-index: 90007;
			cursor: pointer;
		}
		.menu_subformularios{
			display: none;
		}
		.menu_formularios{
			display: none;
		}
		.tabla{
			left: 20px;
			right: 20px;
			top: 10px;
		}
		.formElement{
			margin: 5px;
		}
		.formPopUp{
			height: auto;
		}
		.header{
			background-image: url("http://www.sonda.com/media/media2011/img/fondo-new.jpg");
			background-repeat: repeat-x;
			height: auto;
			min-height: 90px;
			width: 100%;
		}
		.bg_top {
			background: url("http://www.sonda.com/media/media2011/img/fondo-header.jpg") repeat-x scroll 0;
			width: 100%;
			height: auto;
			position: relative;
			right: 0;
			top: 0;
			overflow: hidden;
			min-width: 1024px;
		}
		.backWhite{
			background-color: #FFFFFF;
		}
		.loading{
			position: fixed;
			display: none;
			top: 45%;
		    left: 45%;
		    z-index: 90008;
		}
		.blackout{
			background-color: #DDDDDD;
			position: fixed;
			top: 0;
			left: 0;
			height: 100%;
			width: 100%;
			opacity: 0.5;
			z-index: 90001;
		}
	</style>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo">
		<?php $imghtml= CHtml::image(Yii::app()->request->baseUrl.'/images/logosonda.jpg', 'DORE'); ?>
		<?php echo CHtml::link($imghtml, array('datos/admin'));?>
		</div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				/*array('label'=>'Nuevo Formulario', 'url'=>array('forms/create'), 'visible'=>!Yii::app()->user->isGuest),*/
				array('label'=>'Volver a Modo Ejecutor', 'url'=>array('site/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Actualizaciones', 'url'=>array('/editor/upgrade'), 'visible'=>!Yii::app()->user->isGuest),
				//array('label'=>'Contact', 'url'=>array('/site/contact'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Cerrar Sesión ('.Yii::app()->user->name.' '.Yii::app()->user->lastname.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; 2014 by Cloudlab UAI.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
