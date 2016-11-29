<?php

/**
 * This is the model class for table "retailer".
 *
 * The followings are the available columns in table 'retailer':
 * @property integer $id
 * @property string $name
 * @property string $retailer_code
 * @property string $VAT_number
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $telephone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $image
 * @property string $image_url
 * @property string $website
 * @property string $contact_person1
 * @property string $contact_person2
 * @property string $key_brand_stocked
 * @property string $product_categories
 * @property string $categories_of_interest
 * @property integer $store_size
 * @property integer $status
 * @property integer $request_status
 * @property string $created_date
 * @property string $modified_date
 */
class Retailer extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'retailer';
    }

    private $oldAttrs = array();

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,email,password,mobile,address,pincode,city,state,allocated_warehouse_id,collection_agent_id', 'required'),
            array('id, status,credit_limit,', 'numerical', 'integerOnly' => true),

            array('min_order_price, shipping_charge', 'numerical'),
            array('name, website, contact_person1,geolocation,settlement_days,time_of_delivery,demand_centre,owner_email,billing_email', 'length', 'max' => 250),
            array('retailer_code,owner_phone,mobile', 'length', 'max' => 10),
            array('state,retailer_code,VAT_number,contact_person1', 'length', 'max' => 150),
            array('VAT_number', 'length', 'min' => 11, 'max' => 11),
            array('mobile,telephone', 'length', 'min' => 10),
            array('telephone', 'length', 'min' => 11, 'max' => 13),
            //array('name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in name.'),
            array('city', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in city.'),
            array('email', 'unique', 'on' => 'insert', 'message' => 'email already exists!'),
            // array('mobile', 'unique', 'on' => 'insert', 'message' => 'mobile no. already exists!'),
            // array('product_categories,categories_of_interest', 'length', 'max' => 500),
            array('website', 'url', 'defaultScheme' => 'http'),
            array('modified_date,date_of_onboarding', 'safe'),
            //array('file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, retailer_code, VAT_number,pincode, email, password, mobile, telephone, address, city, state, image, image_url, website, contact_person1, contact_person2,product_categories, categories_of_interest, store_size, status,date_of_onboarding,demand_centre,time_of_delivery,settlement_days,billing_email,owner_email,owner_phone,geolocation,created_date, modified_date, collection_fulfilled, due_date, last_due_date, due_payable_amount, total_payable_amount,collection_agent_id, allocated_warehouse_id',
             'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'warehouse_name' => array(self::BELONGS_TO, 'Warehouse', 'allocated_warehouse_id',
            //'orders' => array(self::HAS_MANY, 'OrderHeader', 'user_id'),
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Business Name',
            'retailer_code' => 'Retailer Code',
            'VAT_number' => 'Vat Number',
            'email' => 'Primary Email',
            'password' => 'Password',
            'mobile' => 'Primary Mobile',
            'telephone' => 'Telephone',
            'address' => 'Delivery Address',
            'city' => 'City',
            'state' => 'State',
           'pincode' => 'Pincode',
//            'image_url' => 'Image Url',
            'website' => 'Website',
            'contact_person1' => 'Contact Person1',
//            'contact_person2' => 'Contact Person2',
            //'key_brand_stocked' => 'Key Brand Stocked',
//            'product_categories' => 'Product Categories',
//            'categories_of_interest' => 'Categories Of Interest',
//            'store_size' => 'Store Size',
            'status' => 'Status',
            'request_status' => 'Request Status',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
            'geolocation' => 'geolocation',
            'owner_phone' => 'owner_phone',
            'owner_email' => 'owner_email',
            'billing_email' => 'billing_email',
            'settlement_days' => 'settlement_days',
            'shipping_charge'=>'shipping_charge',
            'min_order_price'=>'min_order_price',
            'collection_agent_id' => 'collection_agent_id'
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
        $criteria->order = "id DESC";
        $criteria->compare('name', $this->name, true);
        $criteria->compare('retailer_code', $this->retailer_code, true);
        $criteria->compare('VAT_number', $this->VAT_number, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('state', $this->state, true);
       $criteria->compare('pincode', $this->pincode, true);
//        $criteria->compare('image_url', $this->image_url, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('contact_person1', $this->contact_person1, true);
//        $criteria->compare('contact_person2', $this->contact_person2, true);
        //$criteria->compare('key_brand_stocked',$this->key_brand_stocked,true);
//        $criteria->compare('product_categories', $this->product_categories, true);
//        $criteria->compare('categories_of_interest', $this->categories_of_interest, true);
//        $criteria->compare('store_size', $this->store_size);
        //$criteria->compare('status', $this->status);
        $criteria->compare('status', 1);
        //$criteria->compare('request_status',$this->request_status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        $criteria->compare('geolocation', $this->geolocation, true);
        $criteria->compare('owner_phone', $this->owner_phone, true);
        $criteria->compare('owner_email', $this->owner_email, true);
        $criteria->compare('billing_email', $this->billing_email, true);
        $criteria->compare('settlement_days', $this->settlement_days, true);
        $criteria->compare('collection_agent_id', $this->collection_agent_id, true);
        $criteria->compare('total_payable_amount', $this->total_payable_amount, true);
        $criteria->compare('allocated_warehouse_id', $this->allocated_warehouse_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Retailer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // ******************** sand grid function ********************/
    public static function sgSendMail($mailArray) {
        //echo $email.$pass;die;
        // $url  = 'http://sendgrid.com/';
        $url = 'https://api.sendgrid.com/';
        $user = 'rishabhsingla';
        $pass = 'lwi@pranav123';

        $params = array();
        $params['api_user'] = $user;
        $params['api_key'] = $pass;
        $i = 0;
        $json_string = array();
        foreach ($mailArray['to'] as $to) {
            if ($to['email'] == "grootsadmin@gmail.com") {
                continue;
            }
            if ($i == 0) {
                $params['to'] = $to['email'];
                //   $params['toname']    = $to['name'];
                $json_string['to'][] = $to['email'];
            } else {
                $json_string['to'][] = $to['email'];
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

        if ($mailArray['replyto'] && $mailArray['replyto'] != '') {
            $params['replyto'] = $mailArray['replyto'];
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

        // print everything out
        return $response;
    }

// *************************** sand grid end ****************************/

    public function gettotal_retailers() {
        $adminid = Yii::app()->session['brand_id'];
        $issuperadmin = Yii::app()->session['is_super_admin'];
        $row = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(id) from retailer";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $row = $command->queryScalar();
        } else {
            $row = Retailer::model()->getMappedretailersByBrandAdmin($adminid);
            $row = count($row);
        }
        return $row;
    }

    public function gettotal_retailersForindex($start_date, $end_date) {
        $adminid = Yii::app()->session['brand_id'];
        $issuperadmin = Yii::app()->session['is_super_admin'];
        $row = 0;
        $cDate = date("Y-m-d H:i:s", strtotime($start_date));
        $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
        if ($issuperadmin == 1) {
            $sql = "select count(id) from retailer where 1=1";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$cDate" . "' AND '" . "$cdate1" . "')";
            }
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $row = $command->queryScalar();
        } else {
            $row = $this->getMappedretailersByBrandAdmin($adminid);
            $row = count($row);
        }
        return $row;
    }

    public function mdpassword($eid, $pass) {
        $pass1 = md5($pass);
        $sql = 'update retailer set password="' . $pass1 . '" where email="' . $eid . '" AND password="' . $pass . '"';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function data_retailers($rid) {
        //  echo "hello";die;
        $connection = Yii::app()->db;
        $sql = "SELECT name,email,mobile FROM `retailer` where id=$rid";
        $command = $connection->createCommand($sql);
        $command->execute();
        // $retailer_name = $command->queryScalar();
        return $category_id_del = $command->queryAll();
    }

    public function getRetailerNameByID($retialerid) {
        $retailer_name = '';
        if (is_numeric($retialerid)) {
            $connection = Yii::app()->db;
            $sql = "SELECT name  FROM `retailer`  where id=$retialerid";
            $command = $connection->createCommand($sql);
            $command->execute();
            $retailer_name = $command->queryScalar();
        }
        return $retailer_name;
    }

    public function insertMediaretailer($media_main, $media_thumb_url, $retailer_id) {
        $sql = "INSERT INTO media_retailer(media_url, thumb_url, retailer_id) VALUES('$media_main', '$media_thumb_url', '$retailer_id')";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'retailer ', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertRetailerListLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'retailer', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertRetailerListLog($data);
        }
    }

    /*  public function beforeSave() {
      // echo $this->password;die;
      $pass = md5($this->password);
      $this->password = $pass;
      return true;
      } */

    protected function afterDelete() {
        parent::beforeDelete();
        $newAttrs = json_encode(array());
        // $r = Yii::app()->session['last_json'];
        $oldAttrs = json_encode($this->getAttributes());
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'user', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertRetailerListLog($data);
        //  $this->redirect(array('retailer/admin'));
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

    public static function getCollectionFrequencies(){
        $connection = Yii::app()->db;
        $collectionFrequency = Utility::get_enum_values($connection, self::tableName(), 'collection_frequency' );
        return $collectionFrequency;
    }

    public function getInitialPayableAmount($r_id){
        if(is_numeric($r_id)){
            $connection = Yii::app()->db;
            $sql = 'select initial_payable_amount from retailer where id = '.$r_id;
            $command = $connection->createCommand($sql);
            $command->execute();
            $initial_payable_amount = $command->queryScalar();
        }
        return $initial_payable_amount;
    }

    public function getLastDueDate($r_id){
        if(is_numeric($r_id)){
            $connection = Yii::app()->db;
            $sql = 'select last_due_date from retailer where id = '.$r_id;
            $command = $connection->createCommand($sql);
            $command->execute();
            $last_due_date = $command->queryScalar();
        }
        return $last_due_date;
    }

}
