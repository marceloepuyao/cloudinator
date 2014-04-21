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
		
		<?php if($respuesta['metaname']){?>
			<a href="#popup<?php echo $respuesta['id'];?>" data-rel="popup"  data-theme="<?php echo $theme;?>"  data-role="button" data-iconpos="top">
				<?php echo $respuesta['name']?>
			</a>
			<div data-role="popup" id="popup<?php echo $respuesta['id'];?>" data-theme="b" rel="external" class="ui-corner-all">
			    <form data-ajax="false">
			        <div style="padding:10px 20px;" data-theme="b" rel="external" >
			            <h3><?php echo $respuesta['metaname'];  ?></h3>
			         
			            <?php if($respuesta['metatype'] == "textarea"){?>
			            	<input name="subresp" id="un" value="" placeholder="<?php echo $respuesta['metadata'];?>" data-theme="b" type="text">

			            <?php }elseif($respuesta['metatype'] == "array"){?>
			 				
			 				<?php $arr = explode(",", $respuesta['metadata'] );?>
			 				<select name="subresp">
			 				 <?php foreach($arr as $ar){?>
							  <option><?php echo $ar?></option>
							  <?php }?>
							</select>
			            <?php }?>
			            
			            <input type="hidden" name="levantamientoid"  id="levantamientoid"  value="<?php echo $levantamiento->id; ?>" >
						<input type="hidden" name="subformid"  id="subformid"  value="<?php echo $subform->id; ?>" >
						<input type="hidden" name="cloneid"  id="cloneid"  value="<?php echo $cloneid; ?>" >
						<input type="hidden" name="respid" id="respid"  value="<?php echo $respuesta['id']; ?>" >
						<input type="hidden" name="pregid"  id="pregid"  value="<?php echo $pregunta['id']; ?>" >
   
						<input type="submit" data-ajax="false" data-theme="b" rel="external" data-rel="external"  data-icon="check" value="Continuar"/>
			        </div>
			    </form>
			</div>
			
		<?php }else{?>
			
			<a href="<?php echo $this->createUrl('respuestas/index', array('subformid'=>$subform->id, 'levantamientoid' =>$levantamiento->id,'cloneid'=>$cloneid, 'respid'=>$respuesta['id'], 'pregid'=>$pregunta['id']));?>"  data-theme="<?php echo $theme;?>"  rel="external"  data-role="button" data-iconpos="top">
				<?php echo $respuesta['name']?>
			</a>
		<?php }?>
<?php }?>
</div>
<br>
</br>



<div class="row buttons">
	<?php echo CHtml::button('Volver al Levantamiento', array("submit"=>$this->createUrl('levantamientos', array("id"=>$levantamiento->id)), "data-ajax"=>"false")); ?>
</div>