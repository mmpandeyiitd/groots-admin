<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        Yii::app()->session->open();
        $username = $this->username;
        $password = $this->password;

        $user = Users::model()->getUserInfo($username, $password);

        if (isset($user['id']) && !empty($user['id'])) {
            if (isset($user['id']) && !empty($user['id'])) {



                $this->errorCode = self::ERROR_NONE;   
                $permission_info=json_decode($user['permission_info'],true);

                $this->errorCode = self::ERROR_NONE;
                $permission_info = json_decode($user['permission_info'], true);

                Yii::app()->session['last_json'] = $user['permission_info'];
                Yii::app()->session['premission_info'] = $permission_info;
                Yii::app()->session['checkType'] = 'Admin';
                Yii::app()->session['checkPermission'] = '2';
                Yii::app()->session['store_id'] = $user['id'];
                Yii::app()->session['user_id'] = $user['id'];

                Yii::app()->session['is_super_admin'] = $user['is_superadmin'];
                Yii::app()->session['checkAccess'] = 'Admin';

                Yii::app()->session['brand_id'] = $user['brand_id'];
                Yii::app()->session['checkAccess'] = 'Admin';
            } else {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            return !$this->errorCode;
        } else if ($user == 2) {
            Yii::app()->user->setFlash('error', 'disable ');
            return "error";
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return !$this->errorCode;
        }
        return !$this->errorCode;
    }

}
