<?php

/**
 * This is the model class for table "ympdm_user".
 *
 * The followings are the available columns in table 'ympdm_user':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $permission_info
 * @property string $created_at
 */
class Users extends CActiveRecord {

    private $oldAttrs = array();

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('password,email,user_type,', 'required'),
            array('email', 'email'),
            array('name', 'length', 'max' => 250),
            array('email', 'unique', 'message' => 'Email already exists!'),
            array('is_superadmin,status,brand_id', 'numerical', 'integerOnly' => true),
            array('user_type', 'length', 'max' => 20),
            array('email', 'unique', 'on' => 'insert,update', 'message' => 'email:(value) already exists!'),
         //   array('user_name', 'unique', 'on' => 'insert,update', 'message' => 'username:(value) already exists!'),
            array('name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in Name.'),
          //  array('user_name', 'match', 'pattern' => '/^[A-Za-z0-9]+$/u', 'message' => 'Invalid characters in username.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,name,email,is_superadmin,status,user_type, password,permission_info,created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'user_type' => 'User Type',
            'user_name' => 'User Name',
            'password' => 'Password',
            'status' => 'status',
            'permission_info' => 'Permission Info',
            'created_at' => 'Created At',
            'is_superadmin' => 'is_superadmin',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('user_type', $this->user_type, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('permission_info', $this->permission_info, true);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return YmpdmUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getUserInfo($username, $pass) {

        $user_info = '';
        if (isset($username) AND isset($pass)) {
            $connection = Yii::app()->db;
            $sql = "select * from users where email='" . $username . "' and password='" . $pass . "'";
            $command = $connection->createCommand($sql);
            $command->execute();
            foreach ($command->queryAll() as $pcm) {

                if ($pcm['status'] == 0) {
                    return $user_info = 2;
                    break;
                }
                $user_info['id'] = $pcm['id'];
                $user_info['user_name'] = $pcm['user_name'];
                $user_info['email'] = $pcm['email'];
                $user_info['permission_info'] = $pcm['permission_info'];
                $user_info['is_superadmin'] = $pcm['is_superadmin'];
                $user_info['brand_id'] = $pcm['brand_id'];
            }
        }
        return $user_info;
    }

    public function updateUsers($id, $permission_json) {
        $connection = Yii::app()->db;
        $sql = "update users set permission_info='" . $permission_json . "' where id=" . $id . "";
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function CreateUsers($id, $permission_json) {

        $connection = Yii::app()->db;
        $sql = "update users set permission_info='" . $permission_json . "' where id=" . $id . "";
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function CreateByBrand($name,$email,$user_type,$user_name,$brand_id,$password,$permition) {
        $connection = Yii::app()->db;
        $sql = "insert into users  (email,user_type,user_name,name,brand_id,password,permission_info) values ('".$email."','".$user_type."','".$user_name."','".$name."','".$brand_id."','".$password."','".$permition."') ";
        $command = $connection->createCommand($sql);
        if ($command->execute()) {
            return true;
            exit();
        }
        return false;
    }

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        //parent::afterSave();
        if (!$this->isNewRecord) {
            $a = @$data['oldAttrs'] . Yii::app()->session['oldjson'];
            $b = @$data['newAttrs'] . Yii::app()->session['newjson'];


            $newAttrs = json_encode(array($this->getAttributes(), $b));
            $oldAttrs = json_encode(array($this->getOldAttributes(), $a));

            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'user', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertUserLog($data);
        }
        if ($this->isNewRecord) {
            // $a = @$data['oldAttrs'].Yii::app()->session['oldjson'];
            $b = Yii::app()->session['newjson'];

            $newAttrs = json_encode(array($this->getAttributes(), $b));

            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'user', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertUserLog($data);
        }
    }

    protected function afterDelete() {
        //return parent::beforeDelete();


        $newAttrs = json_encode(array());
        $r = Yii::app()->session['last_json'];
        // $a = json_decode($r);
        $oldAttrs = json_encode($r);
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'user', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertUserLog($data);
    }

    protected function afterFind() {
        // Save old values
        $this->setOldAttributes($this->getAttributes());

        return parent::afterFind();
    }

    public function getOldAttributes() {
        return $this->oldAttrs;
    }

    public function setOldAttributes($attrs) {
        $this->oldAttrs = $attrs;
    }

    public function forgotoassword($email) {

        $sql = "select count(email) from users where email='" . $email . "'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
        $row = $command->queryScalar();
        if ($row > 0) {
            $sql_data = "select name,password from users where email='" . $email . "'";
            $command_detail = $connection->createCommand($sql_data);
            $command_detail->execute();
            $login_detail = $command_detail->queryAll();
            //  print_r($login_detail);
            // die;
            $from_email = 'yorder@hotmail.com';
            $from_name = 'YORDER';
            $forgot_password = 'forgot_password';
            $mailArray = array(
                'to' => array(
                    '0' => array('email' => $email)
                ),
                'from' => $from_email,
                'fromname' => $from_name,
                'subject' => $forgot_password,
                'html' => '<table><tr><td>User Name</td><td>:</td><td>' . $login_detail[0]['name'] . '</td></tr> '
                . '<tr>Password<td></td><td>:</td><td>' . $login_detail[0]['password'] . '</td></tr>'
                . '</table>',
                'text' => '',
            );
            $url = 'http://sendgrid.com/';
            $parameter = 'api/mail.send.json';
            $user = 'konsultapp123';
            $pass = 'k0n5u1t123';
            $params = array();
            $params['api_user'] = $user;
            $params['api_key'] = $pass;
            $i = 0;

            $json_string = array();
            foreach ($mailArray['to'] as $to) {
                if ($i == 0) {
                    $params['to'] = $email;
                    $params['toname'] = 'shareef';
                    $json_string['to'][] = $email;
                } else {
                    $json_string['to'][] = $email;
                }
                $i++;
            }


            $params['from'] = $mailArray['from'];

            if ($mailArray['fromname'] && $mailArray['fromname'] != '') {
                $params['fromname'] = $mailArray['fromname'];
            }

            $params['subject'] = $mailArray['subject'];

            if ($mailArray['html'] && $mailArray['html'] != '') {
                $params['html'] = $mailArray['html'];
            }

            if ($mailArray['text'] && $mailArray['text'] != '') {
                $params['text'] = $mailArray['text'];
            }


            if (isset($mailArray['files'])) {
                foreach ($mailArray['files'] as $file) {
                    $params['files[' . $file['name'] . ']'] = '@' . $file['path'];
                }
            }

            $params['x-smtpapi'] = json_encode($json_string);
            $request = $url . 'api/mail.send.json';

            // Generate curl request
            $session = curl_init($request);

            // Tell curl to use HTTP POST
            curl_setopt($session, CURLOPT_POST, true);

            // Tell curl that this is the body of the POST
            curl_setopt($session, CURLOPT_POSTFIELDS, $params);

            // Tell curl not to return headers, but do return the response
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

            // obtain response
            $response = curl_exec($session);
            curl_close($session);
            // print_r($response);
            $respons_data = json_decode($response, TRUE);

            if ($respons_data['message'] === 'success') {
                return 1;
            }
        } else {
            return 2;
        }
    }

    public function create_user_bybrand() {

        $queryStr = "update  store set retailer_mapped ='" . $base_ids_str . "', modified_date='" . date('Y-m-d H:i:s') . "' where store_id=" . $id;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($queryStr);
        $command->execute();
    }

}
