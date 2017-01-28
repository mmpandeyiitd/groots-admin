<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 10/8/16
 * Time: 8:42 PM
 */



class PurchaseHeader extends CActiveRecord
{

    public $groots_authorized_name;
    public $groots_address;
    public $groots_city;
    public $groots_state;
    public $groots_country;
    public $groots_pincode;


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

    public function validatePriceVendorInput($unitPrice, $totalPrice, $vendorId, $isParent){
        //var_dump($unitPrice,$totalPrice, $vendorId);die;
        $status = 1;
        $msg = '';
        if(empty($unitPrice)){
            $status = 0;
            $msg = 'Unit Price Must Be Greater Than 0.!';
        }
        else if(empty($totalPrice)){
            $status = 0;
            $msg = 'Total Price Must Be Greater Than 0.!';   
        }
        else if(empty($vendorId) && !$isParent){
            $status = 0;
            $msg = 'Please Select Vendor';    
        }
        $result = array();
        $result['status'] = $status;
        $result['msg'] = $msg;
        return $result;
    }


    public function readInventoryUploadedFile($uploadedFile, $logfile, $w_id){
        $purchase_id='';
        $first = true;
        $firstQuery = false;
        $query = 'insert into groots_orders.purchase_line (id, purchase_id, base_product_id, order_qty, received_qty, unit_price, price, created_at, vendor_id) values';
        $parentData = array();
        $parentIds = array();
        while(!feof($uploadedFile)){
            $row = fgetcsv($uploadedFile);
            if(!$first){
                $purchase_id = (!empty($purchase_id)) ? $row[0] : $purchase_id;
                $date = trim($row[7]);
                $bp_id = trim($row[2]);
                $line_id = trim($row[1]);
                $vendor_id = trim($row[6]);
                $rec_qty = trim($row[10]);
                $order_qty = trim($row[9]);
                $unit_price = trim($row[11]);
                $total_price = trim($row[12]);
                $parentId = trim($row[3]);
                $array = array('received_qty' => $rec_qty, 'order_qty' => $order_qty, 'unit_price' => $unit_price, 'total_price' => $total_price);
                $flag = self::validateBulkUploadRow($array);
                if($flag['status'] == 1){
                    if(empty($line_id)){
                        $line_id = null;
                    }
                    $query.= ($firstQuery) ? ', ':'';
                    $query.= '('.$line_id.', '.$purchase_id.', '.$bp_id.', '.$order_qty.', '.$rec_qty.', '.$unit_price.', '.$total_price.', '.$vendor_id.')';
                    $firstQuery = true;
                    if(!empty($parentId)){
                        array_push($parentIds, $parentId);
                        self::buildingParentData($parentData, $array, $parentId);    
                    }
                }
                else if($flag['status'] == 0){
                    throw new Exception($flag['msg']);
                }
                if(!empty($parentId)) array_push($parentIds, $parentId);
            }
            $first = false;
        }
        if($firstQuery){
            
            $query .= ' on duplicate key update order_qty = values(order_qty), received_qty = values(received_qty), unit_price = values(unit_price), price = values(price)';
            try{
                self::executePurchaseBulkQuery($query);
                self::updateParentData($parentIds, $parentData,$purchase_id);
            } catch(Exception $e){
                throw $e;
            }

        }
        die($query);
    }

    public function validateBulkUploadRow($array){
        $result = array();
        if(isset($array)){
            foreach ($array as $key => $value) {
                if(isset($value)){
                    if(!is_numeric($value)){
                        $result['status'] = 0;
                        $result['msg'] = $key.' must be numeric';
                        return $result;
                    }
                    else if($value <= 0){
                        $result['status'] = 0;
                        $result['msg'] = $key.' must be greater than 0';
                        return $result;
                    }
                }
                else{
                    $result['status'] = 2;
                    $result['msg'] = '';
                    return $result;
                }
            }
            $result['status'] = 1;
            $result['msg'] = '';
            return $result;
        }
    }

    public function executePurchaseBulkQuery($query){
        $transaction = Yii::app()->secondaryDb->beginTransaction();
        try{
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($query);
            $command->execute();    
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function buildingParentData($parentData, $array, $parentId){
        if(array_key_exists($parentId, $parentData)){
            $parentData[$parentId]['received_qty'] += $array['received_qty'];
            $parentData[$parentId]['order_qty'] += $array['order_qty'];
            $parentData[$parentId]['unit_price'] += $array['unit_price'];
            $parentData[$parentId]['total_price'] += $array['total_price'];
        }
        else{
            $parentData[$parentId] = array();
            $parentData[$parentId]['received_qty'] = $array['received_qty'];
            $parentData[$parentId]['order_qty'] = $array['order_qty'];
            $parentData[$parentId]['unit_price'] = $array['unit_price'];
            $parentData[$parentId]['total_price'] = $array['total_price'];
        }
    }

    public function updateParentData($parentIds, $parentData, $purchase_id){
        $connection = Yii::app()->secondaryDb;
        $first = true;
        $sql = 'select base_product_id, id from purchase_line where base_product_id in ('.implode(',', $parentIds).' and purchase_id = '.$purchase_id;
        $query = 'insert into groots_orders.purchase_line (id, purchase_id, base_product_id, order_qty, received_qty, unit_price, price, created_at, vendor_id) values';
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        foreach ($result as $key => $value) {
            $parentData[$value['base_product_id']]['line_id'] = $value['id']; 
        }
        foreach ($parentData as $key => $value) {  
            $query.= ($first) ? '':', ';
            $id = (!empty($value['line_id'])) ? $value['line_id'] : null;
            $query.= ' ('.$id.','.$purchase_id.','.$key.','.$value['order_qty'].','.$value['received_qty'].','.$value['unit_price'].','.$value['total_price'].', NOW(),0)';
            $first = false;
        }
        $query.=' on duplicate key update order_qty = values(order_qty), received_qty = values(received_qty), unit_price = values(unit_price), price = values(price)'; 
        $transaction = Yii::app()->secondaryDb->beginTransaction();       
        try{
            $command = $connection->createCommand($query);
            $command->execute();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

}