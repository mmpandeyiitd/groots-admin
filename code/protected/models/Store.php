<?php

/**
 * This is the model class for table "store".
 *
 * The followings are the available columns in table 'store':
 * @property string $store_id
 * @property string $getit_store_id
 * @property string $store_code
 * @property string $store_name
 * @property string $store_details
 * @property string $store_logo
 * @property string $seller_name
 * @property string $business_address
 * @property string $business_address_country
 * @property string $business_address_state
 * @property string $business_address_city
 * @property string $business_address_pincode
 * @property string $mobile_numbers
 * @property string $telephone_numbers
 * @property integer $visible
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $customer_value
 * @property string $chat_id
 * @property string $email
 * @property integer $status
 * @property integer $vtiger_status
 * @property integer $vtiger_accountid
 * @property string $created_date
 * @property string $modified_date
 * @property integer $is_deleted
 * @property string $tagline
 * @property integer $is_tagline
 * @property string $redirect_url
 * @property integer $seller_mailer_flag
 * @property integer $buyer_mailer_flag
 * @property string $channel_name
 * @property string $channel_id
 * @property string $order_prefix
 * @property integer $is_active_valid
 * @property integer $store_shipping_charge
 * @property string $type
 *
 * The followings are the available model relations:
 * @property SubscribedProduct[] $subscribedProducts
 */
class Store extends CActiveRecord {

    private $oldAttrs = array();

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'store';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('business_address,business_address_pincode,business_address_city,business_address_state,business_address_country', 'required'),
           // array('store_name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/','message' => 'Invalid characters in Brand Name.'),
           // array('seller_name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in Contact Person.'),
            array('business_address_city', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in City.'),
            array('business_address_state', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in State.'),
            array('business_address_country', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in Country.'),
            array('visible, status,is_deleted,mobile_numbers,business_address_pincode', 'numerical', 'integerOnly' => true),
            array('store_name, store_logo, seller_name,email', 'length', 'max' => 255),
            array('business_address,tags,image_url,store_logo_url', 'length', 'max' => 1000),
            array('email', 'email', 'message' => "The email isn't correct"),
            array('mobile_numbers', 'length', 'min' => 10),
            array('mobile_numbers', 'length', 'max' => 10),
            array('business_address_pincode', 'length', 'min' => 6),
            array('business_address_pincode', 'length', 'max' => 6),
            array('email', 'unique', 'on' => 'insert', 'message' => 'email:(value) already exists!'),
            array('mobile_numbers', 'unique', 'on' => 'insert', 'message' => 'mobile:(value) already exists!'),
            array('business_address_country,business_address_state, business_address_city, business_address_pincode, mobile_numbers, telephone_numbers', 'length', 'max' => 100),
            array('store_details, created_date, modified_date', 'safe'),
            array('store_logo,image', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('store_id,seller_name, store_details, seller_name, business_address, business_address_country, business_address_state, business_address_city, business_address_pincode, mobile_numbers, telephone_numbers, visible, email, status, created_date, modified_date, is_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    //  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
//        return array(
//            'subscribedProducts' => array(self::HAS_MANY, 'SubscribedProduct', 'store_id'),
//        );
//        
//        return array(
//            'store' => array(self::BELONGS_TO, 'UserStore', 'store_id'),
//        );
//    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'store_id' => 'Brand Id',
            // 'store_code' => 'Brand Code',
            'store_name' => 'Brand Name',
            'store_details' => 'Brand Details',
            'store_logo' => 'Brand Logo',
            'seller_name' => 'Contact Person',
            'business_address' => 'Address',
            'business_address_country' => 'Country',
            'business_address_state' => 'State',
            'business_address_city' => 'City',
            'business_address_pincode' => ' Pincode',
            'mobile_numbers' => 'Mobile',
            'telephone_numbers' => 'Telephone Numbers',
            'visible' => 'Visible',
            'email' => 'Email',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
            'is_deleted' => 'Is Deleted',
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

        // print_r($this);

        $criteria->compare('store_id', $this->store_id, true);
        $criteria->compare('store_name', $this->store_name, true);
        $criteria->compare('store_details', $this->store_details, true);
        $criteria->compare('store_logo', $this->store_logo, true);
        $criteria->compare('seller_name', $this->seller_name, true);
        $criteria->compare('business_address', $this->business_address, true);
        $criteria->compare('business_address_country', $this->business_address_country, true);
        $criteria->compare('business_address_state', $this->business_address_state, true);
        $criteria->compare('business_address_city', $this->business_address_city, true);
        $criteria->compare('business_address_pincode', $this->business_address_pincode, true);
        $criteria->compare('mobile_numbers', $this->mobile_numbers, true);
        $criteria->compare('telephone_numbers', $this->telephone_numbers, true);
        $criteria->compare('visible', $this->visible);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        $criteria->compare('is_deleted', $this->is_deleted);


//        return new CActiveDataProvider(get_class($this), array(
//            'criteria' => $criteria,
//        ));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function updateConfigurationsretailers($retailesid, $id) {
        try {
            //copy ne and old ids to new variables. If empty replace by 0 to 
            //avoid sql exception

            $check = count($retailesid);

            if ($check > 0 && !empty($id)) {
                $base_ids_str = implode(',', $retailesid);
                $queryStr = "update  store set retailer_mapped ='" . $base_ids_str . "', modified_date='" . date('Y-m-d H:i:s') . "' where store_id=" . $id;
                $connection = Yii::app()->db;
                $command = $connection->createCommand($queryStr);
                $command->execute();
                $newAttrs = json_encode($retailesid);
                $oldAttrs = json_encode($this->getOldAttributes());
                $log = new Log();
                $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store map retails', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
                $log->insertStoreLog($data);
            }

            //log base_productid, old ids and new ids

            return true;
            //}
        } catch (Exception $e) {
            throw $e;
        }
        return false;
    }

    /**
     * Author:Ravi Kr Shrama
     * Declares the function create password MD5 data
     * and function to be declears.
     */
    public function beforeSave() {
        //$pass = md5($this->password);
        // $this->password = $pass;
        return true;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Store the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        if (!$this->isNewRecord) {

            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertStoreLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertStoreLog($data);
        }
    }

    protected function afterDelete() {
        //return parent::beforeDelete();
        $newAttrs = json_encode(array());
        $oldAttrs = json_encode($this->getOldAttributes());
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertStoreLog($data);
    }

    public static function getstore_nameByid($store_id) {
        $store_name='';
        if(is_numeric($store_id)){
        $connection = Yii::app()->db;
        $sql = "SELECT store_name  FROM `store`  where store_id=" . $store_id . "";
        $command = $connection->createCommand($sql);
        $command->execute();
        $store_name = $command->queryScalar();
        }

        return $store_name;
    }

    public static function Deletebybrand($id) {
        $queryStr = "delete from `store`  where store_id=" . $id . "";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($queryStr);
        $command->execute();
    }

    public static function Update_brandImage($store_id, $mage, $image_url) {

        $sql = "update store set image='" . $mage . "',image_url='" . $image_url . "' where store_id='" . $store_id . "'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public static function Update_brandLOGO($store_id, $mage, $image_url) {

        $sql = "update store set store_logo='" . $mage . "',store_logo_url='" . $image_url . "' where store_id='" . $store_id . "'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
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

}
