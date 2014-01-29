<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />

<!-- blueprint CSS framework> 
	<!--end css-->
<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />

<!-- jquery mobile -->
<link rel="stylesheet"
	href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script
	src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>


<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

<style type="text/css" media="screen">
	.container {
		padding-right: 20%;
		padding-left: 20%;
	},
	a {
		rel: external
	}
</style>
<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
		<div data-role="header" data-theme="b">
			<h1>
			<?php echo $this->pageTitle; ?>
			</h1>
			
			<?php if(Yii::app()->user->isGuest){?>
				<a id="popup" href="#popupNested" data-rel="popup" data-role="button"
					data-inline="true" data-icon="bars" data-theme="b"
					data-transition="pop"><?php echo Yii::t('contentForm', 'language')?>
				</a>
			<?php }else{?>
				<a href="<?php echo Yii::app()->user->returnUrl; ?>" rel="external" data-icon="arrow-l"><?php echo Yii::t('contentForm', 'back')?> </a>
				<a href="#mypanel" data-icon="bars"><?php echo Yii::t('contentForm', 'options');?>
				</a>
			<?php }?>
			
		</div>

		<div data-role="popup" id="popupNested" data-theme="none">
			<fieldset data-role="controlgroup">
				<input name="radio-choice-1" id="es" value="es" <?php if(Yii::app()->language=="es"){echo "checked=checked";} ?> type="radio" />
				<label id="toes" for="es">Español</label> 
				<input name="radio-choice-1" id="pt" value="pt" <?php if(Yii::app()->language=="pt"){echo "checked=checked";} ?> type="radio" /> 
				<label id="topt"  for="pt">Portugués</label> 
				<input name="radio-choice-1" id="en" value="en" <?php if(Yii::app()->language=="en"){echo "checked=checked";} ?> type="radio" /> 
				<label id="toen"  for="en">English</label>
			</fieldset>
		</div>
		<!-- /popup -->


		<div id="page" data-role="content">
		<?php if(isset($this->breadcrumbs)){?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'htmlOptions' => array("data-ajax"=>"false"),
		)); ?>
			<!-- breadcrumbs -->
		<?php }?>

			<div data-theme='b' data-display='overlay' data-position='right'
				data-role='panel' id='mypanel'>
				<h2>
				<?php
				if(!Yii::app()->user->isGuest){
					echo Yii::app()->user->name." ".Yii::app()->user->lastname;
				}
				?>
				</h2>
				<?php if(Yii::app()->user->getState('superuser')){?>
					<a href="<?php echo Yii::app()->request->baseUrl.'/editor'; ?>" rel="external" data-icon="arrow-l">Editar Formularios </a><br />
					
				<?php }?>

				<a href='<?php echo Yii::app()->request->baseUrl;?>/users'  rel="external"
					class='usuarios'><?php echo Yii::t('contentForm', 'managingusers')?>
				</a><br />
				<?php if(!Yii::app()->user->isGuest){if(Yii::app()->user->superuser){?>
				<a href='<?php echo Yii::app()->request->baseUrl;?>/companies' rel="external"><?php echo Yii::t('contentForm', 'managingcompanies')?>  
				</a><br />
				<?php }}?>
				<a href='<?php echo Yii::app()->request->baseUrl;?>/site/logout' rel="external"
					class='cerrarsesion'><?php echo Yii::t('contentForm', 'logout')?> </a>
				<br /> <a href='#header' data-rel='close'><?php echo Yii::t('contentForm', 'close')?>
				</a>
			</div>

			<?php echo $content; ?>

			<div class="clear"></div>

			<div id="footer">
				Copyright &copy;
				<?php echo 2014; ?>
				Cloudlab UAI<br /> All Rights Reserved.<br />
				<?php echo Yii::powered(); ?>
			</div>
			<!-- footer -->

		</div>

<script type="text/javascript">

$( document ).ready(function() {
	$('.ui-link').each(function(){
		$(this).attr('rel', 'external');
	});
	$('.sort-link').each(function(){
		$(this).css('color', 'white');
	});
	$('#toes').on('click',function(){
		window.location.href = "login?lang=es";
	});
	$('#toen').on('click', function(){
		window.location.href = "login?lang=en";
	});
	$('#topt').on('click', function(){
		window.location.href = "login?lang=pt";
	});
});


</script>
	

</body>
</html>
