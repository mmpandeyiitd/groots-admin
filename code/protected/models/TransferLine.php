<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 10/8/16
 * Time: 8:42 PM
 */



class TransferLine extends CActiveRecord
{

    public $title='';

    public $parent_id='';
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'transfer_line';
    }

    public function getDbConnection() {
        return Yii::app()->secondaryDb;
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id,transfer_id,base_product_id,order_qty,delivered_qty,received_qty,unit_price,price,status,created_at', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'TransferHeader' => array(self::BELONGS_TO,  'TransferHeader', 'transfer_id'),
            'BaseProduct' => array(self::BELONGS_TO,  'BaseProduct', 'base_product_id'),
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Retailer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getTransferInSumByDate($w_id,$date){
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT ol.base_product_id as id, SUM(ol.received_qty) as qty,bp.pack_size, bp.pack_unit FROM `transfer_line` ol join transfer_header oh on oh.id=ol.transfer_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE oh.delivery_date='$date' and oh.dest_warehouse_id=$w_id and oh.status != 'cancelled' and oh.transfer_category='primary' group by ol.base_product_id having qty > 0 order by ol.base_product_id asc";
        //echo $sql;die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $orderLines = array();
        foreach ($result as $item){
            $orderLines[$item['id']] = $item['qty'];
        }

        return $orderLines;
    }

    public static function getNotRegularTransferInSumByDate($w_id,$date){
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT ol.base_product_id as id, SUM(ol.received_qty) as qty,bp.pack_size, bp.pack_unit FROM `transfer_line` ol join transfer_header oh on oh.id=ol.transfer_id and oh.transfer_type != 'regular' and oh.transfer_category='primary' join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE oh.delivery_date='$date' and oh.dest_warehouse_id=$w_id and oh.status != 'cancelled' group by ol.base_product_id having qty > 0 order by ol.base_product_id asc";
        //echo $sql;die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $orderLines = array();
        foreach ($result as $item){
            $orderLines[$item['id']] = $item['qty'];
        }

        return $orderLines;
    }

    public static function getDeliveredTransferOutSumByDate($w_id,$date){
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT ol.base_product_id as id, SUM(ol.delivered_qty) as qty, bp.pack_size, bp.pack_unit  FROM `transfer_line` ol join transfer_header oh on oh.id=ol.transfer_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE oh.delivery_date='$date' and oh.source_warehouse_id=$w_id and oh.status != 'cancelled' and oh.transfer_category='primary' group by ol.base_product_id having qty > 0 order by ol.base_product_id asc";
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $orderLines = array();
        foreach ($result as $item){
            $orderLines[$item['id']] = $item['qty'];
        }

        return $orderLines;
    }

    public static function getOrderedTransferOutSumByDate($w_id,$date){
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT ol.base_product_id as id, SUM(ol.order_qty) as qty, bp.pack_size, bp.pack_unit  FROM `transfer_line` ol join transfer_header oh on oh.id=ol.transfer_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE oh.delivery_date='$date' and oh.source_warehouse_id=$w_id and oh.status != 'cancelled' and oh.transfer_category='primary' group by ol.base_product_id  order by ol.base_product_id asc";
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $orderLines = array();
        foreach ($result as $item){
            $orderLines[$item['id']] = $item['qty'];
        }

        return $orderLines;
    }

    public static function getLiqInvSent($w_id,$date){
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT ol.base_product_id as id, SUM(ol.delivered_qty) as qty, bp.pack_size, bp.pack_unit  FROM `transfer_line` ol join transfer_header oh on oh.id=ol.transfer_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE oh.delivery_date='$date' and oh.source_warehouse_id=$w_id and oh.status in ('pending','received') and oh.transfer_category='secondary' group by ol.base_product_id having qty > 0 order by ol.base_product_id asc";
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $orderLines = array();
        foreach ($result as $item){
            $orderLines[$item['id']] = $item['qty'];
        }

        return $orderLines;
    }

    public static function getLiqInvReceived($w_id,$date){
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT ol.base_product_id as id, SUM(ol.received_qty) as qty, bp.pack_size, bp.pack_unit  FROM `transfer_line` ol join transfer_header oh on oh.id=ol.transfer_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE oh.delivery_date='$date' and oh.source_warehouse_id=$w_id and oh.status in ('pending','received') and oh.transfer_category='secondary' group by ol.base_product_id having qty > 0 order by ol.base_product_id asc";
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $orderLines = array();
        foreach ($result as $item){
            $orderLines[$item['id']] = $item['qty'];
        }

        return $orderLines;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getParentId(){
        return $this->parent_id;
    }

}