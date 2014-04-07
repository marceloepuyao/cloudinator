<?php

/**
 * This is the model class for table "registropreguntas".
 *
 * The followings are the available columns in table 'registropreguntas':
 * @property integer $id
 * @property integer $preguntaid
 * @property integer $respuestaid
 * @property integer $subformid
 * @property integer $formid
 * @property integer $levantamientoid
 * @property integer $userid
 * @property integer $empresaid
 * @property string $created
 * @property string $respsubpregunta
 * @property integer $clonedid
 */
class Respuestas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'registropreguntas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('preguntaid, respuestaid, levantamientoid, userid', 'required'),
			array('preguntaid, respuestaid, subformid, formid, levantamientoid, userid, empresaid, clonedid', 'numerical', 'integerOnly'=>true),
			array('respsubpregunta', 'length', 'max'=>500),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, preguntaid, respuestaid, subformid, formid, levantamientoid, userid, empresaid, created, respsubpregunta, clonedid', 'safe', 'on'=>'search'),
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
			'preguntaid' => Yii::t('contentForm', 'question'),
			'respuestaid' => Yii::t('contentForm', 'answer'),
			'subformid' => 'Subformid',
			'formid' => 'Formid',
			'levantamientoid' => 'Levantamientoid',
			'userid' => Yii::t('contentForm', 'interviewer'),
			'empresaid' => 'Empresaid',
			'created' => Yii::t('contentForm', 'date'),
			'respsubpregunta' => Yii::t('contentForm', 'subanswer'), 
			'clonedid' => 'Clonedid',
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
		$criteria->compare('preguntaid',$this->preguntaid);
		$criteria->compare('respuestaid',$this->respuestaid);
		$criteria->compare('subformid',$this->subformid);
		$criteria->compare('formid',$this->formid);
		$criteria->compare('levantamientoid',$this->levantamientoid);
		$criteria->compare('userid',$this->userid);
		$criteria->compare('empresaid',$this->empresaid);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('respsubpregunta',$this->respsubpregunta,true);
		$criteria->compare('clonedid',$this->clonedid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Respuestas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
