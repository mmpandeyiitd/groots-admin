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
 * @property string $username
 * @property string $password
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
class UserStore extends CActiveRecord {

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
            array('vtiger_accountid, username, password, channel_name, channel_id, order_prefix, type', 'required'),
            array('visible, status, vtiger_status, vtiger_accountid, is_deleted, seller_mailer_flag, buyer_mailer_flag, is_active_valid, store_shipping_charge', 'numerical', 'integerOnly' => true),
            array('getit_store_id', 'length', 'max' => 10),
            array('store_name, store_logo, seller_name, meta_keywords, email, channel_name, channel_id', 'length', 'max' => 255),
            array('business_address', 'length', 'max' => 300),
            array('business_address_country, business_address_state, business_address_city, business_address_pincode, mobile_numbers, telephone_numbers, username, password', 'length', 'max' => 100),
            array('meta_title, meta_description', 'length', 'max' => 150),
            array('customer_value', 'length', 'max' => 12),
            array('chat_id', 'length', 'max' => 45),
          //  array('tagline', 'length', 'max' => 256),
            array('order_prefix', 'length', 'max' => 11),
            array('type', 'length', 'max' => 50),
            array('store_details, created_date, modified_date, redirect_url', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('store_id, getit_store_id, store_name, store_details, store_logo, seller_name, business_address, business_address_country, business_address_state, business_address_city, business_address_pincode, mobile_numbers, telephone_numbers, visible, meta_title, meta_keywords, meta_description, customer_value, chat_id, email, status, vtiger_status, vtiger_accountid, created_date, modified_date, is_deleted, is_tagline, username, password, redirect_url, seller_mailer_flag, buyer_mailer_flag, channel_name, channel_id, order_prefix, is_active_valid, store_shipping_charge, type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'subscribedProducts' => array(self::HAS_MANY, 'SubscribedProduct', 'store_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'store_id' => 'Brand Id',
           
           // 'store_code' => 'Store Code',
            'store_name' => 'Brand Name',
            'store_details' => 'Brand Details',
            'store_logo' => 'Brand Logo',
            'seller_name' => 'Brand Name',
            'business_address' => 'Business Address',
            'business_address_country' => 'Business Address Country',
            'business_address_state' => 'Business Address State',
            'business_address_city' => 'Business Address City',
            'business_address_pincode' => 'Business Address Pincode',
            'mobile_numbers' => 'Mobile Numbers',
            'telephone_numbers' => 'Telephone Numbers',
            'visible' => 'Visible',
           // 'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'customer_value' => 'Customer Value',
            'chat_id' => 'Chat',
            'email' => 'Email',
            'status' => 'Status',
            'vtiger_status' => 'Vtiger Status',
            'vtiger_accountid' => 'Vtiger Accountid',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
            'is_deleted' => 'Is Deleted',
            //'tagline' => 'Tagline',
           // 'is_tagline' => 'Is Tagline',
            'username' => 'Username',
            'password' => 'Password',
            'redirect_url' => 'Redirect Url',
            'seller_mailer_flag' => 'Seller Mailer Flag',
            'buyer_mailer_flag' => 'Buyer Mailer Flag',
            'channel_name' => 'Channel Name',
            'channel_id' => 'Channel',
            'order_prefix' => 'Order Prefix',
            'is_active_valid' => 'Is Active Valid',
            'store_shipping_charge' => 'Store Shipping Charge',
            'type' => 'Type',
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
        
//          $is_superadmin=Yii::app()->session['is_super_admin'];
//        if ($is_superadmin==1) {
//            //die;
//            if (!empty($criteria->condition)) {
//                $criteria->condition .= ' AND ';
//            }
//         //   $criteria->condition .= 'store_id != " "';
//            
//        }else  if ((Yii::app()->session['is_super_admin']==0)) {
//             $adminid = Yii::app()->session['brand_id'];
//            if (!empty($criteria->condition)) {
//                $criteria->condition .= ' AND ';
//            }
//            $criteria->condition .= 'store_id ='.$adminid;
//        }

        $criteria->compare('store_id', $this->store_id, true);
       
     //   $criteria->compare('store_code', $this->store_code, true);
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
       
//        $criteria->compare('username', $this->username, true);
//        $criteria->compare('password', $this->password, true);
        
//        $criteria->compare('is_active_valid', $this->is_active_valid);
//        $criteria->compare('store_shipping_charge', $this->store_shipping_charge);
     //   $criteria->compare('type', $this->type, true);

//        return new CActiveDataProvider(get_class($this), array(
//            'criteria' => $criteria,
//        ));
        
         return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Author:Ravi Kr Shrama
     * Declares the function Get Records login by users
     * and function to be declears.
     */
    public function getRecordById($store_id) {
        if ($store_id == '1') {
            $connection = Yii::app()->db;
            //$sql= mysql_query("select users.id, users.username, users.password, users.address, users.mobile, users.city, store.product from users Inner Join store ON users.id = store.id where store.id='9'");
            $command = $connection->createCommand("select * from store");
            $row = $command->queryAll();
            
            return $row;
        } else {
            $connection = Yii::app()->db;
            $command = $connection->createCommand("select * from store where store_id='". $store_id."'");
            $row = $command->queryAll();
            return $row;
        }
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

}
