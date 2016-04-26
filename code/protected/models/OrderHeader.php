<?php

/**
 * This is the model class for table "order_header".
 *
 * The followings are the available columns in table 'order_header':
 * @property integer $order_id
 * @property string $order_number
 * @property integer $user_id
 * @property string $created_date
 * @property string $payment_method
 * @property string $payment_status
 * @property string $billing_name
 * @property string $billing_phone
 * @property string $billing_email
 * @property string $billing_address
 * @property string $billing_state
 * @property string $billing_city
 * @property string $billing_pincode
 * @property string $shipping_name
 * @property string $shipping_phone
 * @property string $shipping_email
 * @property string $shipping_address
 * @property string $shipping_state
 * @property string $shipping_city
 * @property string $shipping_pincode
 * @property string $shipping_charges
 * @property string $total
 * @property string $total_payable_amount
 * @property string $total_paid_amount
 * @property string $discount_amt
 * @property string $coupon_code
 * @property string $payment_ref_id
 * @property string $payment_gateway_name
 * @property string $payment_source
 * @property string $order_source
 * @property string $timestamp
 * @property string $transaction_id
 * @property string $bank_transaction_id
 * @property string $transaction_time
 * @property string $payment_mod
 * @property string $bankname
 * @property string $status
 * @property string $cron_processed_flag
 * @property string $source_url
 * @property string $source_type
 * @property integer $source_id
 * @property string $source_name
 * @property integer $campaign_id
 * @property integer $buyer_shipping_cost
 * @property string $order_type
 * @property string $utm_source
 */
class OrderHeader extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    private $oldAttrs = array();
    public $secondaryDb = null;
    public $store_id;
   // public $status_array;

    public function tableName() {
        return 'order_header';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_number, user_id,shipping_phone', 'required'),
            array('user_id, source_id,shipping_phone,shipping_pincode, campaign_id, buyer_shipping_cost', 'numerical', 'integerOnly' => true),
            array('order_number, billing_name, utm_source', 'length', 'max' => 255),
            array('payment_method', 'length', 'max' => 16),
            array('payment_status', 'length', 'max' => 12),
            array('billing_phone, shipping_phone, payment_source', 'length', 'max' => 15),
            array('billing_email, shipping_name, shipping_email', 'length', 'max' => 256),
            array('billing_state, billing_city, shipping_state, shipping_city, payment_gateway_name, source_type', 'length', 'max' => 100),
            array('billing_pincode, shipping_pincode', 'length', 'max' => 11),
            array('shipping_charges, total, total_payable_amount, total_paid_amount, discount_amt', 'length', 'max' => 10),
            array('coupon_code', 'length', 'max' => 20),
            array('payment_ref_id', 'length', 'max' => 30),
            array('transaction_id, bank_transaction_id, payment_mod, bankname', 'length', 'max' => 50),
            array('shipping_phone', 'length', 'max' => 10),
            array('shipping_phone', 'length', 'min' => 10),
            array('status', 'length', 'max' => 9),
            array('cron_processed_flag', 'length', 'max' => 1),
            array('source_name', 'length', 'max' => 254),
            array('order_type', 'length', 'max' => 150),
            array('created_date, billing_address, shipping_address, timestamp, transaction_time, source_url', 'safe'),
            // The following rule is used by search().
            array('store_id', 'safe', 'on' => 'search'),
            // @todo Please remove those attributes that should not be searched.
            array('order_id,order_number, user_id, created_date, payment_method, payment_status, billing_name, billing_phone, billing_email, billing_address, billing_state, billing_city, billing_pincode, shipping_name, shipping_phone, shipping_email, shipping_address, shipping_state, shipping_city, shipping_pincode, shipping_charges, total, total_payable_amount, total_paid_amount, discount_amt, coupon_code, payment_ref_id, payment_gateway_name, payment_source, order_source, timestamp, transaction_id, bank_transaction_id, transaction_time, payment_mod, bankname, status, cron_processed_flag, source_url, source_type, source_id, source_name, campaign_id, buyer_shipping_cost, order_type, utm_source', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                // 'OrderLine' => array(self::BELONGS_TO, 'OrderLine', 'order_id'),
                // 'Store' => array(self::BELONGS_TO, 'Store', 'store_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'order_id' => 'Order Id',
            'order_number' => 'Order Number',
            'user_id' => 'User Id',
            'created_date' => 'Order Date',
            'payment_method' => 'Payment Method',
            'payment_status' => 'Payment Status',
            'billing_name' => 'User Name',
            'billing_phone' => 'Billing Phone',
            'billing_email' => 'Billing Email',
            'billing_address' => 'Billing Address',
            'billing_state' => 'Billing State',
            'billing_city' => 'Billing City',
            'billing_pincode' => 'Billing Pincode',
            'shipping_name' => 'Shipping Name',
            'shipping_phone' => 'Mobile',
            'shipping_email' => 'Shipping Email',
            'shipping_address' => 'Shipping Address',
            'shipping_state' => 'Shipping State',
            'shipping_city' => 'Shipping City',
            'shipping_pincode' => 'Shipping Pincode',
            'shipping_charges' => 'Shipping Charges',
            'total' => 'Total',
            'total_payable_amount' => 'Total Payable Amount',
            'total_paid_amount' => 'Total Paid Amount',
            'discount_amt' => 'Discount Amt',
            'coupon_code' => 'Coupon Code',
            'payment_ref_id' => 'Payment Ref',
            'payment_gateway_name' => 'Payment Gateway Name',
            'payment_source' => 'Payment Source',
           // 'order_source' => 'Order Source',
            'timestamp' => 'Timestamp',
            'transaction_id' => 'Transaction',
            'bank_transaction_id' => 'Bank Transaction',
            'transaction_time' => 'Transaction Time',
            'payment_mod' => 'Payment Mod',
            'bankname' => 'Bankname',
            'status' => 'Status',
            'cron_processed_flag' => 'Cron Processed Flag',
            'source_url' => 'Source Url',
            'source_type' => 'Source Type',
            'source_id' => 'Source',
            'source_name' => 'Source Name',
            'campaign_id' => 'Campaign',
            'buyer_shipping_cost' => 'Buyer Shipping Cost',
            'order_type' => 'Order Type',
            'utm_source' => 'Utm Source',
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

        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
 $criteria = new CDbCriteria;
        if(isset($_GET['retailer_id'])){
             if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
          $user_id=$_GET['retailer_id'];
            $criteria->condition .= 'user_id  ='.$user_id ;
        }
        
       

        if (is_numeric($store_id)) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }

            $criteria->condition .= 'store_id  =' . $store_id;
        }

        if (is_numeric($store_id)) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }

            $criteria->condition .= 'store_id  =' . $store_id;
        }
        $criteria->order = 'created_date DESC';

        $criteria->join = 'left JOIN order_line ON order_line.order_id = t.order_id';
        $criteria->distinct = true;


        if (!empty($this->created_date)) {
            // echo $this->created_date;die;
            $this->created_date = date('d/m/Y', strtotime($this->created_date));

            $criteria->addCondition(
                    "DATE_FORMAT(created_date, '%d/%m/%Y') = '$this->created_date'"
            );
        }


        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('order_number', $this->order_number, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('payment_method', $this->payment_method, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('billing_name', $this->billing_name, true);
        $criteria->compare('billing_phone', $this->billing_phone, true);
        $criteria->compare('billing_email', $this->billing_email, true);
        $criteria->compare('billing_address', $this->billing_address, true);
        $criteria->compare('billing_state', $this->billing_state, true);
        $criteria->compare('billing_city', $this->billing_city, true);
        $criteria->compare('billing_pincode', $this->billing_pincode, true);
        $criteria->compare('shipping_name', $this->shipping_name, true);
        $criteria->compare('shipping_phone', $this->shipping_phone, true);
        $criteria->compare('shipping_email', $this->shipping_email, true);
        $criteria->compare('shipping_address', $this->shipping_address, true);
        $criteria->compare('shipping_state', $this->shipping_state, true);
        $criteria->compare('shipping_city', $this->shipping_city, true);
        $criteria->compare('shipping_pincode', $this->shipping_pincode, true);
        $criteria->compare('shipping_charges', $this->shipping_charges, true);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('total_payable_amount', $this->total_payable_amount, true);
        $criteria->compare('total_paid_amount', $this->total_paid_amount, true);
        $criteria->compare('discount_amt', $this->discount_amt, true);
        $criteria->compare('coupon_code', $this->coupon_code, true);
        $criteria->compare('payment_ref_id', $this->payment_ref_id, true);
        $criteria->compare('payment_gateway_name', $this->payment_gateway_name, true);
        $criteria->compare('payment_source', $this->payment_source, true);
        $criteria->compare('order_source', $this->order_source, true);
        $criteria->compare('timestamp', $this->timestamp, true);
        $criteria->compare('transaction_id', $this->transaction_id, true);
        $criteria->compare('bank_transaction_id', $this->bank_transaction_id, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('payment_mod', $this->payment_mod, true);
        $criteria->compare('bankname', $this->bankname, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('cron_processed_flag', $this->cron_processed_flag, true);
        $criteria->compare('source_url', $this->source_url, true);
        $criteria->compare('source_type', $this->source_type, true);
        $criteria->compare('source_id', $this->source_id);
        $criteria->compare('source_name', $this->source_name, true);
        $criteria->compare('campaign_id', $this->campaign_id);
        $criteria->compare('buyer_shipping_cost', $this->buyer_shipping_cost);
        $criteria->compare('order_type', $this->order_type, true);
        $criteria->compare('utm_source', $this->utm_source, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDbConnection() {
        return Yii::app()->secondaryDb;
    }

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'order header', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertOrderheaderLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'order header', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertOrderheaderLog($data);
        }
    }

    protected function beforeDelete() {
        //return parent::beforeDelete();
        $newAttrs = json_encode(array());
        $oldAttrs = json_encode($this->getOldAttributes());
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'order header', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertOrderheaderLog($data);
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

    public function getOrderCount() {
        $connection = Yii::app()->secondaryDb;
        $sql = "select count(order_id) from order_header";
        $command = $connection->createCommand($sql);
        $command->execute();
        $row = $command->queryScalar();
        return $row;
    }
    
     public function getorder_lineDescription($order_id) {
        $connection = Yii::app()->secondaryDb;
        $sql = "select * from line_description where line_id in (select id from order_line where order_id=$order_id)";
        $command = $connection->createCommand($sql);
        $command->execute();
        $row = $command->queryAll();
        return $row;
    }
    
    public function GetOrderdetail($order_id) {
        $connection = Yii::app()->db;
        
       // $sql = "select `ol`.`order_id` AS `order_id`,`ol`.`colour` AS `color`,group_concat(`ol`.`base_product_id` separator ',') AS `base_product_id`,group_concat(`ol`.`size` separator ',') AS `size`,group_concat(`ol`.`product_qty` separator ',') AS `qty` ,group_concat(`ol`.`product_name` separator ',') AS `product_name` ,group_concat(`ol`.`unit_price` separator ',') AS `unit_price` ,group_concat(`ol`.`shipping_charges` separator ',') AS `shipping_charges`,group_concat(`ol`.`total_price_discount` separator ',') AS `total_price_discount`,group_concat(`ol`.`unit_price_discount` separator ',') AS `unit_price_discount`,group_concat(`ol`.`seller_name` separator ',') AS `seller_name`,group_concat(`ol`.`id` separator ',') AS `id` ,group_concat(`ol`.`status` separator ',') AS `status` from `select `ol`.`order_id` AS `order_id`,`ol`.`colour` AS `color`,group_concat(`ol`.`base_product_id` separator ',') AS `base_product_id`,group_concat(`ol`.`size` separator ',') AS `size`,group_concat(`ol`.`product_qty` separator ',') AS `qty` ,group_concat(`ol`.`product_name` separator ',') AS `product_name` ,group_concat(`ol`.`unit_price` separator ',') AS `unit_price` ,group_concat(`ol`.`shipping_charges` separator ',') AS `shipping_charges`,group_concat(`ol`.`total_price_discount` separator ',') AS `total_price_discount`,group_concat(`ol`.`unit_price_discount` separator ',') AS `unit_price_discount`,group_concat(`ol`.`seller_name` separator ',') AS `seller_name`,group_concat(`ol`.`id` separator ',') AS `id` ,group_concat(`ol`.`status` separator ',') AS `status` from `cb_dev_groots_order`.`order_line` `ol`  where ol.order_id=353  group by `ol`.`colour``.`order_line` `ol`  where ol.order_id=$order_id  group by `ol`.`colour`";      
         $sql = "select `ol`.`order_id` AS `order_id`,`ol`.`colour` AS `color`,group_concat(`ol`.`base_product_id` separator ',') AS `base_product_id`,group_concat(`ol`.`size` separator ',') AS `size`,group_concat(`ol`.`product_qty` separator ',') AS `qty` ,group_concat(`ol`.`product_name` separator ',') AS `product_name` ,group_concat(`ol`.`unit_price` separator ',') AS `unit_price` ,group_concat(`ol`.`shipping_charges` separator ',') AS `shipping_charges`,group_concat(`ol`.`total_price_discount` separator ',') AS `total_price_discount`,group_concat(`ol`.`unit_price_discount` separator ',') AS `unit_price_discount`,group_concat(`ol`.`seller_name` separator ',') AS `seller_name`,group_concat(`ol`.`id` separator ',') AS `id` ,group_concat(`ol`.`status` separator ',') AS `status` from `cb_dev_groots_order`.`order_line` `ol`  where ol.order_id=$order_id group by `ol`.`colour`";      
//echo $sql;die;
        $connection = Yii::app()->secondaryDb;
       // $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
        $row = $command->queryAll();
        return $row;
    }

    public function updatelinedescById($lineid = null, $grand_total, $gtotal_price_discount) {
        $lineidinfo = '';

        if (!empty($lineid)) {
            $connection = Yii::app()->secondaryDb;
            $sql = "update order_header set grand_total='" . $grand_total . "',gtotal_price_discount='" . $gtotal_price_discount . "'  where order_id = $lineid";
            $command = $connection->createCommand($sql);
            $command->execute();
        }
        return $lineidinfo;
    }

    public function CancelOrderByID($order_ids) {
        $succ = false;

        if (!empty($order_ids)) {
            $sql = "update `order_header` set status='" . 'cancelled' . "' where order_id in($order_ids)";
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $succ1 = $command->execute();

            $sql1 = "update `order_line` set status='" . 'cancelled' . "' where order_id in($order_ids)";
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql1);
            $succ2 = $command->execute();
        }
        if ($succ2 && $succ1) {
            return true;
        }
        return $succ;
    }

    public static function downloadCSVByIDs($store_front_ids) {
        // $succ = false;
        if (!empty($store_front_ids)) {

            $sqlchksubsid = "select order_number as Order_ID,shipping_name as User_Name,shipping_phone as Contact_No,shipping_email as Email, shipping_address as Address, shipping_city as City, shipping_state as State,shipping_pincode as Pincode ,total as Amount from `order_header` where order_id in(" . $store_front_ids . ")";
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sqlchksubsid);
            $command->execute();
            $assocDataArray = $command->queryAll();
            $fileName = "OrderLis.csv";
            ob_clean();
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($assocDataArray['0'])) {
                $fp = fopen('php://output', 'w');
                $columnstring = implode(',', array_keys($assocDataArray['0']));
                $updatecolumn = str_replace('_', ' ', $columnstring);

                $updatecolumn = explode(',', $updatecolumn);
                fputcsv($fp, $updatecolumn);
                foreach ($assocDataArray AS $values) {
                    fputcsv($fp, $values);
                }
                fclose($fp);
            }
            ob_flush();
        }
    }

   

}
