<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 10/8/16
 * Time: 8:42 PM
 */



class RetailerPayment extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */

    public $retailerName;
    public $totalPayableAmount;

    public function tableName()
    {
        return 'retailer_payments';
    }

    public function getDbConnection() {
        return Yii::app()->secondaryDb;
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(array('retailer_id,paid_amount,date,payment_type', 'required'),);
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
        /*return array(
            'id' => 'ID',
            'retailer_id' => 'Reatailer Id',
            'city' => 'City',
            'state' => 'State',
            'pincode' => 'Pincode',
            'phone' => 'Phone No',
            'created_date' => 'Created Date',
        );*/
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

    public static function paymentTypes(){
        $connection = Yii::app()->secondaryDb;
        $paymentTypes = Utility::get_enum_values($connection, "retailer_payments", 'payment_type' );
        return $paymentTypes;
    }

    public static function status(){
        $status = array(array('value'=>0), array('value'=>1));
        return $status;
    }


    public function getRetailerName(){
            return $this->retailerName;
    }

    public function geTotalPayableAmount(){
        return $this->totalPayableAmount;
    }



}