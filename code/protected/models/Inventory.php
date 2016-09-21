<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 13/9/16
 * Time: 7:36 PM
 */


class Inventory extends CActiveRecord
{

    public $order_qty = '';
    public $transferIn_qty = '';
    public $transferOut_qty = '';
    public $purchase_qty = '';
    public $balance = '';
    public $item_title = '';
    public $start_date="";
    public $end_date="";
    public $order_id='';
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'inventory';
    }


    public function getDbConnection() {
        return Yii::app()->secondaryDb;
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id,inv_id,warehouse_id,base_product_id,schedule_inv,present_inv,wastage,extra_inv,inv_change_type,inv_change_id,inv_change_quantity,date,created_at,item_title', 'safe', 'on' => 'search,update'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'InvHeader' => array(self::BELONGS_TO, 'InventoryHeader', 'inv_id'),
            'Warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
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
        $criteria->with = array(
            'BaseProduct' => array('alias'=> 't1', 'together' => true, ),
            'InvHeader' => array('alias'=> 't2', 'together' => true, ),
        );
        $criteria->together = true;
        //$criteria->select = " t.*";
        $criteria->compare( 't1.title', $this->item_title, true );
        $criteria->compare( 't2.warehouse_id', $this->warehouse_id, true );
        $criteria->compare( 'date', $this->date, true );
        if($this->start_date){
            $criteria->addCondition("date >= '".$this->start_date."''");
        }
        if($this->end_date){
            $criteria->addCondition("date <= '".$this->end_date."''");
        }
        $criteria->order = 'date desc, title asc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'date',
                        'desc'=>'date DESC',
                    ),
                    'item_title'=>array(
                        'asc'=>'BaseProduct.title',
                        'desc'=>'BaseProduct.title DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
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

    public function getOrderQty(){
        return $this->order_qty;
    }

    public function getTransferInQty(){
        return $this->transferIn_qty;
    }

    public function getTransferOutQty(){
        return $this->transferOut_qty;
    }

    public function getPurchaseQty(){
        return $this->purchase_qty;
    }

    public function getBalance(){
        return $this->balance;
    }

    public function getItemTitle(){
        return $this->item_title;
    }

    public function getStartDate(){
        return $this->start_date;
    }

    public function getEndDate(){
        return $this->end_date;
    }

    public function getOrderId(){
        return $this->order_id;
    }

}