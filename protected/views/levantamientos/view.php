<?php
/* @var $this LevantamientosController */
/* @var $model Levantamientos */
/*'forms'=>$forms,
			'data' => $data,
			'company' => $company,
			'clones'=> $cloned,*/
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
		<?php $completitudform = array();?>
		<div data-role="collapsible" data-collapsed="true">
			<h2><?php echo $form->name?></h2> 
				<ul data-role="listview" data-theme="d"  data-divider-theme="d">
					<?php $subforms = $data[$form->id];?>
					<?php $cloned = $clones[$form->id];	?>
					<li data-role="list-divider"><?php echo Yii::t('contentForm', 'subforms');?><span class="ui-li-count"><?php echo count($subforms)+count($cloned);?></span></li>
					<?php 
					foreach ($subforms as $subform){
						if(MyUtils::checkSubForm($subform->id)){
							extract(MyUtils::getLastQuestionBySubform($subform->id, $model->id)); //$pregunta  $respuestas, $ultimavisita, $completitud, $idregistro
							//die(var_dump($completitud));
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
							$completitud = array();
							$completitud[] = 0;
							$url = "";
						}
						?>
						<li class="" data-idclone="0"  data-subform="4" data-levantamiento="3">
								<a href="<?php echo $url;?>" <?php echo $datarel;?> data-inline="true" data-transition="slideup" data-icon="gear" data-theme="e">
						    		<h3><?php echo $subform->name?></h3>
					                <p><strong><?php echo Yii::t('contentForm', 'lastvisit');?>: <?php echo $ultimavisita;?></strong></p>
					                <p><?php echo Yii::t('contentForm', 'nextquestion').": "; echo ($pregunta!=null)?($pregunta['name']):(Yii::t('contentForm', 'endreached'));?></p>
					                <p class="ui-li-aside"><strong>Completitud: <?php echo $completitud[0]."%"; echo isset($completitud[1])?" - ".$completitud[1]."%":"";?></strong></p>
				            	</a>
			            </li>
			            <?php if(Yii::app()->user->getState('editmode')==1){?>
			            	<div data-role="popup" id="popupMenu<?php echo $subform->id;?>" data-theme="d">
						        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d"> 
						            <li><a rel="external" href="<?php echo $this->createUrl('respuestas/index', array('subformid'=>$subform->id, 'levantamientoid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'gothrough');?></a></li>   
						            <li><a rel="external" href="<?php echo $this->createUrl('clones/create', array('id'=>$subform->id, 'levid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'clonesubform');?></a></li>
						            <li><a rel="external" href="<?php echo $this->createUrl('respuestas/deleterespuestas', array('subformid'=>$subform->id, 'levantamientoid'=>$model->id));?>"><?php echo Yii::t('contentForm', 'deleteanswers');?></a></li>
						        </ul>
							</div>        
		            <?php }
		            
					$completitudform[] = isset($completitud[1])?round(($completitud[0]+$completitud[1])/2, 2):round($completitud[0], 2);
					
					}?>
		           
		            <?php 
		            	
		            	foreach ($cloned as $clon){
							if(MyUtils::checkSubForm($clon->subformid)){
								extract(MyUtils::getLastQuestionBySubform($clon->subformid, $clon->idlev, $clon->id)); //$pregunta  $respuestas, $ultimavisita, $completitud, $idregistro
								
								if(Yii::app()->user->getState('editmode')==1){
									$url = "#popupMenuClone".$clon->id;
									$datarel = "data-rel = 'popup'";
								}else{
									$url = $this->createUrl('respuestas/index', array('subformid'=>$clon->subformid, 'levantamientoid'=>$model->id,  'cloneid'=>$clon->id));      
									$datarel = "rel='external'";
								}
							
							}else{
								$pregunta['name'] = Yii::t('contentForm', 'incompleteform');
								$ultimavisita = Yii::t('contentForm', 'never');
								$completitud = array();
								$completitud[] = 0;
								$url = "";
							}
							?>
							<li class="" data-idclone="0"  data-subform="4" data-levantamiento="3">
									<a href="<?php echo $url;?>" <?php echo $datarel;?> data-inline="true" data-transition="slideup" data-icon="gear" data-theme="e">
							    		<h3><?php echo $clon->name?></h3>
						                <p><strong><?php echo Yii::t('contentForm', 'lastvisit');?>: <?php echo $ultimavisita;?></strong></p>
						                <p><?php echo Yii::t('contentForm', 'nextquestion').": "; echo ($pregunta!=null)?($pregunta['name']):(Yii::t('contentForm', 'endreached'));?></p>
						                <p class="ui-li-aside"><strong>Completitud: <?php echo $completitud[0]."%"; echo isset($completitud[1])?" - ".$completitud[1]."%":"";?></strong></p>
					            	</a>
				            </li>
				            <?php if(Yii::app()->user->getState('editmode')==1){?>
				            	<div data-role="popup" id="popupMenuClone<?php echo $clon->id;?>" data-theme="d">
							        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d"> 
							            <li><a rel="external" href="<?php echo $this->createUrl('respuestas/index', array('subformid'=>$clon->subformid, 'levantamientoid'=>$model->id, 'cloneid'=>$clon->id));?>"><?php echo Yii::t('contentForm', 'gothrough');?></a></li>   				
										<li><?php echo  CHtml::link(CHtml::encode(Yii::t('contentForm', 'delete')), array('clones/delete', 'id'=>$clon->id),
										  array(
										    'submit'=>array('clones/delete', 'id'=>$clon->id),
										    'class' => 'delete','confirm'=>'¿Estás Seguro?'
										  )
										);?></li>
							            <li><a rel="external" href="<?php echo $this->createUrl('respuestas/deleterespuestas', array('subformid'=>$clon->subformid, 'levantamientoid'=>$model->id,  'cloneid'=>$clon->id));?>"><?php echo Yii::t('contentForm', 'deleteanswers');?></a></li>
							        </ul>
								</div>
			            
		            <?php }
		            	$completitudform[] = isset($completitud[1])?round(($completitud[0]+$completitud[1])/2, 2):round($completitud[0], 2);
		            	}?>
		            <li data-role="list-divider">Completitud del Formulario : <?php echo round(array_sum($completitudform)/count($completitudform), 2)."%";?></li>

				</ul>
		</div>
		<? }?>
	</div>
	
	<div class="row buttons">
	<?php echo CHtml::button(Yii::t('contentForm', 'reports'), array("submit"=>$this->createUrl('levantamientos/reports', array("id"=>$model->id)), "data-ajax"=>"false")); ?>
	</div>

