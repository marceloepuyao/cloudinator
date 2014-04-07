<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $lastname
 * @property string $password
 * @property string $firstaccess
 * @property string $lastaccess
 * @property string $lang
 * @property string $modified
 * @property integer $superuser
 */
class Users extends CActiveRecord
{
	public $confirmpassword;
	public $newpassword;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		 array('confirmpassword', 'compare', 'on'=>'update', 'compareAttribute'=>'newpassword'),
		 array('confirmpassword', 'compare', 'on'=>'insert', 'compareAttribute'=>'password'),
		 array('confirmpassword', 'safe'),
		 array('newpassword', 'safe'),
		//array('password, confirmpassword','compare'),
		//array('password', 'compare', 'compareAttribute'=>'confirmpassword', 'on'=>'create', 'message'=>'wrong confirm'),
		array('email, name, lang, lastname','required'),
		 array('password, confirmpassword', 'required', 'on'=>'insert'),
		//array('superuser', 'numerical', 'integerOnly'=>true),
		array('email, name, lastname, password, newpassword, confirmpassword, lang', 'length', 'max'=>50),
		array('modified', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, email, name, lastname, password, confirmpassword, newpassword, firstaccess, lastaccess, lang, modified, superuser', 'safe', 'on'=>'search'),
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
			'email' => Yii::t('contentForm', 'email'),
			'name' => Yii::t('contentForm', 'firstname'),
			'lastname' => Yii::t('contentForm', 'lastname'),
			'password' => Yii::t('contentForm', 'password'),
			'confirmpassword' => Yii::t('contentForm', 'confirmpassword'),
			'lastaccess' => Yii::t('contentForm', 'lastaccess'),
			'firstaccess' => Yii::t('contentForm', 'firstaccess'),
			'modified' => Yii::t('contentForm', 'lastmod'),
			'newpassword' => Yii::t('contentForm', 'newpass'),
			'lang' => Yii::t('contentForm', 'language'),
			'superuser' => Yii::t('contentForm', 'superuser'),
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('firstaccess',$this->firstaccess,true);
		$criteria->compare('lastaccess',$this->lastaccess,true);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('superuser',$this->superuser);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
