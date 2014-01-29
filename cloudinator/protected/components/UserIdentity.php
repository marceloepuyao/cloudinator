<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user= Users::model()->find("LOWER(email)=?", array(strtolower($this->username)));
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(sha1($this->password)!==$user->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{

			$this->_id = $user->id;
		
			
			$model = Users::model()->findByPk($user->id);
			$model->lastaccess = date("Y-m-d H:i:s");
			if($model->firstaccess == "0000-00-00 00:00:00"){
				$model->firstaccess = date("Y-m-d H:i:s");
			}
			$model->save();

			$this->setState('name', $user->name) ;
			$this->setState('lang', $user->lang) ;
			$this->setState('lastname', $user->lastname) ;
			$this->setState('superuser',$user->superuser);

			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	public function getId()
    {
        return $this->_id;
    }
}