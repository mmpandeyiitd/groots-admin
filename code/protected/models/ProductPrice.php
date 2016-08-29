<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 10/8/16
 * Time: 8:42 PM
 */



class ProductPrice extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'product_prices';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array();
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
       /* return array(
            'id' => 'ID',
            'address_line_1' => 'Address',
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

    public static function getByBaseProductIdEffectiveDate($bp_id,$sp_id,$date){
        $query = "select * from product_prices where base_product_id='$bp_id' and subscribed_product_id='$sp_id' and effective_date='$date'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($query);
        $command->execute();
        return $command->queryAll();
    }

    public static function  getRetailerSubscribedProductPricesByDate($retailerId, $effectiveDate){
        $query = "select * from product_prices  where  subscribed_product_id in (select distinct subscribed_product_id from retailer_product_quotation where retailer_id=$retailerId)  and effective_date='$effectiveDate'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($query);
        $command->execute();
        return $command->queryAll();
    }
}