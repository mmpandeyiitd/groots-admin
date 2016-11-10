<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 10/8/16
 * Time: 8:42 PM
 */



class PurchaseHeader extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'purchase_header';
    }

    public function getDbConnection() {
        return Yii::app()->secondaryDb;
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id,warehouse_id,vendor_id,payment_method,payment_status,status,delivery_date, total_payable_amount, paid_amount,comment,invoice_number,created_at', 'safe', 'on' => 'search,update'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'PurchaseLine' => array(self::HAS_MANY, 'PurchaseLine', 'purchase_id'),
            'Vendor' => array(self::BELONGS_TO,  'Vendor', 'vendor_id'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(

        );
    }

    /*
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
        $criteria->compare('warehouse_id', $this->warehouse_id);
        $criteria->compare('payment_method', $this->payment_method);
        $criteria->compare('payment_status', $this->payment_status);
        $criteria->compare('status', $this->status);
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

    public static function paymentMethod(){
        $connection = Yii::app()->secondaryDb;
        $paymentMethods = Utility::get_enum_values($connection, self::tableName(), 'payment_method' );
        return $paymentMethods;
    }

    public static function paymentStatus(){
        $connection = Yii::app()->secondaryDb;
        $paymentStatus = Utility::get_enum_values($connection, self::tableName(), 'payment_status' );
        return $paymentStatus;
    }

    public static function status(){
        $connection = Yii::app()->secondaryDb;
        $status = Utility::get_enum_values($connection,self::tableName(), 'status' );
        return $status;
    }



}