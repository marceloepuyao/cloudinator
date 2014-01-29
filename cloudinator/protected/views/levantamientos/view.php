<?php
/* @var $this LevantamientosController */
/* @var $model Levantamientos */
$this->setPageTitle($company['nombre']);
$this->breadcrumbs=array(
Yii::t('contentForm', 'recordlevantamientos')=>array('index', 'companyid'=>$model->empresaid),
$model->titulo,
);

?>
<?php if(Yii::app()->user->getState('editmode')!=1){?>
	<a href="<?php echo $this->createUrl('levantamientos/editmode', array('id'=>$model->id));?>" rel="external" data-mini="true" data-corners="true" data-wrapperels="span" style="float: right;" data-role="button" data-inline="true"><?php echo Yii::t('contentForm', 'editmode');?></a>
<?php }else{?>
	<a href="<?php echo $this->createUrl('levantamientos/exiteditmode', array('id'=>$model->id));?>" rel="external" data-mini="true" data-corners="true" data-wrapperels="span" style="float: right;" data-role="button" data-inline="true"><?php echo Yii::t('contentForm', 'exiteditmode');?></a>
	
<?php }?>

<h2><?php echo $model->titulo;?></h2>
	<div data-role="collapsible-set" data-theme="b" data-content-theme="d" >
		<?php foreach ($forms as $form){ ?>
		<div data-role="collapsible" data-collapsed="true">
			<h2><?php echo $form->name?></h2> 
				<ul data-role="listview" data-theme="d"  data-divider-theme="d">
					<?php $subforms = $data[$form->id];?>
					<li data-role="list-divider"><?php echo Yii::t('contentForm', 'subforms');?><span class="ui-li-count"><?php echo count($subforms);?></span></li>
					<?php 
					foreach ($subforms as $subform){
						if(MyUtils::checkSubForm($subform->id)){
							extract(MyUtils::getLastQuestionBySubform($subform->id, $model->id)); //$pregunta  $respuestas, $ultimavisita, $completitud, $idregistro
							
							if(Yii::app()->user->getState('editmode')==1){
								$url = "#popupMenu".$subform->id;
								$datarel = "data-rel = 'popup'";
							}else{
								$url = $this->createUrl('respuestas/index', array('subformid'=>$subform->id, 'levantamientoid'=>$model->id));      
								$datarel = "rel='external'";
							}
						
						}else{
							$pregunta['name'] = Yii::t('contentForm', 'incompleteform');
							$ultimavisita = Yii::t('contentForm', 'never');
							$completitud = "0%";
							$url = "";
						}
						?>
						<li class="" data-idclone="0"  data-subform="4" data-levantamiento="3">
								<a href="<?php echo $url;?>" <?php echo $datarel;?> data-inline="true" data-transition="slideup" data-icon="gear" data-theme="e">
						    		<h3><?php echo $subform->name?></h3>
					                <p><strong><?php echo Yii::t('contentForm', 'lastvisit');?>: <?php echo $ultimavisita;?></strong></p>
					                <p><?php echo Yii::t('contentForm', 'nextquestion').": "; echo ($pregunta!=null)?($pregunta['name']):(Yii::t('contentForm', 'endreached'));?></p>
					                <p class="ui-li-aside"><strong>Completitud: <?php echo $completitud;?></strong></p>
				            	</a>
			            </li>
			            <?php if(Yii::app()->user->getState('editmode')==1){?>
			            	<div data-role="popup" id="popupMenu<?php echo $subform->id;?>" data-theme="d">
						        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d"> 
						            <li><a rel="external" href="<?php echo $this->createUrl('respuestas/index', array('subformid'=>$subform->id, 'levantamientoid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'gothrough');?></a></li>   
						            <li><a rel="external" href="<?php echo $this->createUrl('subforms/clone', array('id'=>$subform->id, 'levantamientoid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'clonesubform');?></a></li>
						            <li><a rel="external" href="<?php echo $this->createUrl('respuestas/deleterespuestas', array('subformid'=>$subform->id, 'levantamientoid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'deleteanswers');?></a></li>
						        </ul>
							</div>
			            
		            <?php }}?>
				</ul>
		</div>
		<? }?>
	</div>
	
			<div class="row buttons">
			<?php echo CHtml::button(Yii::t('contentForm', 'reports'), array("submit"=>$this->createUrl('levantamientos/reports', array("id"=>$model->id)), "data-ajax"=>"false")); ?>
			</div>
			<?php /*
			<div class="row buttons">
			<?php echo CHtml::button(Yii::t('contentForm', 'back'), array("submit"=>$this->createUrl('index', array('companyid'=>$model->empresaid)), "data-ajax"=>"false")); ?>
			</div> */?>
		
		
		
		
		
		<div data-role="popup" id="popupMenu<?php echo $subform->id;?>" data-theme="d">
	        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d"> 
	            <li><a  href="<?php echo $this->createUrl('respuestas/index', array('subformid'=>$subform->id, 'levantamientoid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'gothrough');?></a></li>   
	            <li><a  href="<?php echo $this->createUrl('subforms/clone', array('id'=>$subform->id, 'levantamientoid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'clonesubform');?></a></li>
	            <li><a  href="<?php echo $this->createUrl('respuestas/delete', array('subformid'=>$subform->id, 'levantamientoid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'deleteanswers');?></a></li>
	        </ul>
		</div>
