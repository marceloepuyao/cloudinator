<?php

/**
 * This is the model class for table "levantamientos".
 *
 * The followings are the available columns in table 'levantamientos':
 * @property integer $id
 * @property string $titulo
 * @property integer $empresaid
 * @property string $info
 * @property string $formsactivos
 * @property string $conctadopor
 * @property string $areacontacto
 * @property string $completitud
 * @property string $created
 * @property string $modified
 * @property integer $deleted
 */
class Levantamientos extends CActiveRecord
{
	public $forms;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'levantamientos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('titulo',  'required'),
		array('empresaid, deleted', 'numerical', 'integerOnly'=>true),
		array('titulo, formsactivos', 'length', 'max'=>150),
		array('info', 'length', 'max'=>500),
		array('conctadopor, areacontacto, completitud', 'length', 'max'=>100),
		array('created, modified', 'safe'), 
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, titulo, empresaid, info, formsactivos, conctadopor, areacontacto, completitud, created, modified, deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'titulo' => Yii::t('contentForm', 'titlevisit'),
			'empresaid' => 'Empresaid',
			'info' => Yii::t('contentForm', 'info'),
			'formsactivos' => 'Formsactivos',
			'conctadopor' => Yii::t('contentForm', 'contactedby'),
			'areacontacto' => Yii::t('contentForm', 'contactedarea'),
			'completitud' => 'Completitud',
			'created' => 'Created',
			'modified' => Yii::t('contentForm', 'lastmod'),
			'deleted' => 'Deleted',

			'forms' => Yii::t('contentForm', 'forms'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('empresaid',$this->empresaid);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('formsactivos',$this->formsactivos,true);
		$criteria->compare('conctadopor',$this->conctadopor,true);
		$criteria->compare('areacontacto',$this->areacontacto,true);
		$criteria->compare('completitud',$this->completitud,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Levantamientos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
