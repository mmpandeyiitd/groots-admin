<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 10/8/16
 * Time: 8:42 PM
 */



class TransferHeader extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'transfer_header';
    }

    public function getDbConnection() {
        return Yii::app()->secondaryDb;
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id,source_warehouse_id,dest_warehouse_id,status,delivery_date,comment,invoice_number,created_at,transfer_type, transfer_category', 'safe', 'on' => 'search,update'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'TransferLine' => array(self::HAS_MANY, 'TransferLine', 'transfer_id'),
            'SourceWarehouse' => array(self::BELONGS_TO,  'Warehouse', 'source_warehouse_id'),
            'DestWarehouse' => array(self::BELONGS_TO,  'Warehouse', 'dest_warehouse_id'),
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
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchNew() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('source_warehouse_id', $this->source_warehouse_id);
        $criteria->compare('dest_warehouse_id', $this->dest_warehouse_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('delivery_date', $this->delivery_date);
        $criteria->compare('comment', $this->comment);
        $criteria->order = 'delivery_date desc, id desc';
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

    public static function status(){
        $connection = Yii::app()->secondaryDb;
        $status = Utility::get_enum_values($connection, self::tableName(), 'status' );
        return $status;
    }

    public static function getAllTransferCategories(){
        $connection = Yii::app()->secondaryDb;
        $transfer_category = Utility::get_enum_values($connection, self::tableName(), 'transfer_category' );
        return $transfer_category;
    }


    public static function getTransferInCalculationData($w_id, $date){
        $quantitiesMap = array();
        $prevDayInv = Inventory::getPrevDayInvMap($date);
        $orderSum = OrderLine::getOrderSumByDate($w_id, $date);
        $purchaseSum = PurchaseLine::getFullfillablePurchaseSumByDate($w_id, $date);
        $transferInSum = TransferLine::getNotRegularTransferInSumByDate($w_id,$date);
        $transferOutSum = TransferLine::getOrderedTransferOutSumByDate($w_id,$date);
        $avgOrderByItem = OrderHeader::getAvgOrderByItem($w_id, $date);

        $quantitiesMap['prevDayInv'] = $prevDayInv;
        $quantitiesMap['orderSum'] = $orderSum;
        $quantitiesMap['purchaseSum'] = $purchaseSum;
        $quantitiesMap['transferInSum'] = $transferInSum;
        $quantitiesMap['transferOutSum'] = $transferOutSum;
        $quantitiesMap['avgOrder'] = $avgOrderByItem;
        return $quantitiesMap;
    }

}