<?php

/**
 * This is the model class for table "trees".
 *
 * The followings are the available columns in table 'trees':
 * @property integer $id
 * @property string $name
 * @property integer $megatree
 * @property integer $deleted
 * @property string $created
 * @property string $modified
 * @property integer $released
 */
class Subforms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('name', 'required'),
		array('megatree, deleted, released', 'numerical', 'integerOnly'=>true),
		array('name', 'length', 'max'=>50),
		array('modified', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, name, megatree, deleted, created, modified, released', 'safe', 'on'=>'search'),
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
			'name' => 'Nombre Subformulario',
			'megatree' => 'Megatree',
			'deleted' => 'Deleted',
			'created' => 'Creado',
			'modified' => 'Modified',
			'released' => 'Released',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('megatree',$this->megatree);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('released',$this->released);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subforms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
