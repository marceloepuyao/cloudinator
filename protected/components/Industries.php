<?php
class Industries {
		
	public static function getIndustries()
	{
		$industries = array('industria_pesada' => Yii::t('contentForm', 'industria_pesada'), 
						'siderurgicas'=> Yii::t('contentForm', 'siderurgicas'),
						'metalurgicas'=> Yii::t('contentForm', 'metalurgicas'),
						'cementeras'=> Yii::t('contentForm', 'cementeras'), 
						'quimicas_de_base'=> Yii::t('contentForm', 'quimicas_de_base'),
						'petroquimicas'=> Yii::t('contentForm', 'petroquimicas'),
						'automovilistica'=> Yii::t('contentForm', 'automovilistica'),
						'industria_ligera'=> Yii::t('contentForm', 'industria_ligera'),
						'alimentacion'=> Yii::t('contentForm', 'alimentacion'),
						'textil'=> Yii::t('contentForm', 'textil'),
						'farmaeutica'=> Yii::t('contentForm', 'farmaeutica'),
						'agroindustria'=> Yii::t('contentForm', 'agroindustria'),
						'armamentistica'=> Yii::t('contentForm', 'armamentistica'),
						'industria_punta'=> Yii::t('contentForm', 'industria_punta'),
						'robotica'=> Yii::t('contentForm', 'robotica'),
						'informatica'=> Yii::t('contentForm', 'informatica'),
						'astronautica'=> Yii::t('contentForm', 'astronautica'),
						'mecanica'=> Yii::t('contentForm', 'mecanica'),
						'educacionales'=> Yii::t('contentForm', 'educacionales'),
						'gubernamentales'=> Yii::t('contentForm', 'gubernamentales'),
						'otras'=> Yii::t('contentForm', 'otras'));	
		return $industries;
		
	}
	
	
	
}