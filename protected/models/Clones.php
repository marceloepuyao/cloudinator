<?php

/**
 * This is the model class for table "cloned".
 *
 * The followings are the available columns in table 'cloned':
 * @property integer $id
 * @property integer $idlev
 * @property string $name
 * @property integer $subformid
 * @property string $modified
 * @property integer $formid
 */
class Clones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cloned';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idlev, name, subformid', 'required'),
			array('idlev, subformid, formid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idlev, name, subformid, modified, formid', 'safe', 'on'=>'search'),
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
			'idlev' => 'Idlev',
			'name' => 'Name',
			'subformid' => 'Subformid',
			'modified' => 'Modified',
			'formid' => 'Formid',
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
		$criteria->compare('idlev',$this->idlev);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('subformid',$this->subformid);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('formid',$this->formid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
