<?php

/**
 * This is the model class for table "empresas".
 *
 * The followings are the available columns in table 'empresas':
 * @property integer $id
 * @property string $nombre
 * @property string $industria
 * @property string $info
 * @property string $modified
 */
class Companies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'empresas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('nombre', 'required'),
		array('nombre, info', 'length', 'max'=>500),
		array('industria', 'length', 'max'=>50),
		array('modified', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, nombre, industria, info, modified', 'safe', 'on'=>'search'),
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
			'nombre' => Yii::t('contentForm', 'namecompany'),
			'industria' => Yii::t('contentForm', 'industry'),
			'info' => Yii::t('contentForm', 'companyinformation'),
			'modified' => Yii::t('contentForm','lastmod'),
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('industria',$this->industria,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Companies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
