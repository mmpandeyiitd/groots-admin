<?php

/**
 * This is the model class for table "order_line".
 *
 * The followings are the available columns in table 'order_line':
 * @property integer $id
 * @property integer $order_id
 * @property integer $subscribed_product_id
 * @property integer $base_product_id
 * @property integer $store_id
 * @property string $store_name
 * @property string $store_email
 * @property integer $store_front_id
 * @property string $store_front_name
 * @property string $seller_name
 * @property string $seller_phone
 * @property string $seller_address
 * @property string $seller_state
 * @property string $seller_city
 * @property string $colour
 * @property string $size
 * @property string $product_name
 * @property integer $product_qty
 * @property string $unit_price
 * @property string $price
 */
class Dispatch extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    private $oldAttrs = array();
    public $dbadvert = null;
    public $action;

    public function tableName() {
        return 'partial_shipment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, baseproduct_id,track_id,dispatched_date,courier_name', 'required'),
            array('id, order_id, baseproduct_id, qty,created_date,status', 'numerical', 'integerOnly' => true),
            array('dispatched_date', 'date', 'format' => 'MM/dd/yyyy'),
            array('courier_name', 'length', 'max' => 250),
            // array('seller_address', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, status, order_id, baseproduct_id, courier_name,', 'safe', 'on' => 'search'),
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
            'order_id' => 'Order',
            'base_product_id' => 'Base Product',
            'courier_name' => 'Courier Name',
            'dispatched_date' => 'Dispatched Date',
            'qty' => 'Product Quantuity',
            //   'shipping_partner' => 'Shipping Partner',
            'courier_name' => 'Courier Name',
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
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('courier_name', $this->courier_name);
        $criteria->compare('base_product_id', $this->base_product_id);
        $criteria->compare('dispatched_date', $this->dispatched_date);
        $criteria->compare('qty', $this->qty, true);
        // $criteria->compare('shipping_partner', $this->shipping_partner, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Dispatch the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDbConnection() {

        return Yii::app()->secondaryDb;
    }

    public function getRemainigQuantityById($order_id, $baseproduct_id) {
        $sum = 0;

        if (is_numeric($order_id) && is_numeric($order_id)) {
            $connection = Yii::app()->secondaryDb;
            $sql = "Select sum(qty) FROM partial_shipment where order_id = $order_id and baseproduct_id=$baseproduct_id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $sum = $command->queryScalar();
        }
        return $sum;
    }

//    public function Insert_paertial_shipment($sql) {
//
//        $connection = Yii::app()->secondaryDb;
//        $command = $connection->createCommand($sql);
//        $command->execute();
//    }

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'order line', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertOrderlineLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'order line', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertOrderlineLog($data);
        }
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
