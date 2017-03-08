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
    public $created_date;
    public $name;
    public $address;
    public $city;
    public $state;
    public $warehouse_name;
    public $warehouse_id;
    public $groots_authorized_name;
    public $groots_address;
    public $groots_city;
    public $groots_state;
    public $groots_country;
    public $groots_pincode;

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
            array('user_id', 'required'),
            array('user_id,shipping_phone,shipping_pincode', 'numerical', 'integerOnly' => true),
            array('order_number, billing_name', 'length', 'max' => 255),
            array('payment_method', 'length', 'max' => 16),
            array('payment_status', 'length', 'max' => 12),
            array('billing_phone, shipping_phone, payment_source', 'length', 'max' => 15),
            array('billing_email, shipping_name, shipping_email', 'length', 'max' => 256),
            array('billing_state, billing_city, shipping_state, shipping_city, payment_gateway_name', 'length', 'max' => 100),
            array('billing_pincode, shipping_pincode', 'length', 'max' => 11),
            array('shipping_charges, total, total_payable_amount, total_paid_amount, discount_amt', 'length', 'max' => 10),
            array('coupon_code', 'length', 'max' => 20),
            array('payment_ref_id', 'length', 'max' => 30),
            array('transaction_id, bank_transaction_id, payment_mod, bankname', 'length', 'max' => 50),
            array('shipping_phone', 'length', 'max' => 10),
            array('shipping_phone', 'length', 'min' => 10),
//            array('cron_processed_flag', 'length', 'max' => 1),
//            array('source_name', 'length', 'max' => 254),
            array('order_type', 'length', 'max' => 150),
            array('created_date,delivery_date,billing_address, shipping_address, timestamp,status,transaction_time expected_delivery_time , actual_delivery_time', 'safe'),
            // The following rule is used by search().
            array('store_id', 'safe', 'on' => 'search'),
            // @todo Please remove those attributes that should not be searched.
            array('order_id,order_number, user_id,user_comment,created_date, payment_method, payment_status, billing_name, billing_phone, billing_email, billing_address, billing_state, billing_city, billing_pincode, shipping_name, shipping_phone, shipping_email, shipping_address, shipping_state, shipping_city, shipping_pincode, shipping_charges, total, total_payable_amount, total_paid_amount, discount_amt, coupon_code, payment_ref_id, payment_gateway_name, payment_source, order_source, timestamp, transaction_id, bank_transaction_id, transaction_time, payment_mod, bankname, status,order_type, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                //'OrderLine' => array(self::BELONGS_TO, 'OrderLine', 'order_id'),
                // 'Store' => array(self::BELONGS_TO, 'Store', 'store_id'),
                //'Retailer' => array(self::BELONGS_TO, 'Retailer', 'id'),
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
             'delivery_date'=>'Delivery Date',
            'created_date' => 'Order Date',
            'timestamp' => 'Order Date',
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
            'shipping_state' => 'Demand Centre',
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
            'user_comment' => 'user_comment',
            //'timestamp' => 'Timestamp',
            'transaction_id' => 'Transaction',
            'bank_transaction_id' => 'Bank Transaction',
            'transaction_time' => 'Transaction Time',
            'payment_mod' => 'Payment Mod',
            'bankname' => 'Bankname',
            'status' => 'Status',
            'expected_delivery_time' => 'Expected Delivery Time',
            'actual_delivery_time' => 'Actual Delivery Time',
           
//            'cron_processed_flag' => 'Cron Processed Flag',
//            'source_url' => 'Source Url',
//            'source_type' => 'Source Type',
//            'source_id' => 'Source',
//            'source_name' => 'Source Name',
//            'campaign_id' => 'Campaign',
//            'buyer_shipping_cost' => 'Buyer Shipping Cost',
            'order_type' => 'Order Type',
            //'utm_source' => 'Utm Source',
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
        //$criteria->condition = 'order_id > 35';
        $criteria->select = " t.*, r.address, r.state, r.city, r.name, w.id as warehouse_id, w.name as warehouse_name";
        $criteria->join = ' join cb_dev_groots.retailer r on r.id = t.user_id ';
        $criteria->join .= ' join cb_dev_groots.warehouses w on w.id = t.warehouse_id ';
        //$criteria->order = 'created_date DESC';
        $criteria->compare('t.delivery_date', $this->delivery_date, true);
        $criteria->compare('t.created_date', $this->created_date, true);
        /*if (isset($_GET['retailer_id'])) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $user_id = $_GET['retailer_id'];
            $criteria->condition .= 'user_id  =' . $user_id;
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
        }*/
      
         $criteria->compare('t.status', $this->status, true);
         
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('order_number', $this->order_number, true);
        $criteria->compare('user_id', $this->user_id);
      
        
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
      // $criteria->compare('order_source', $this->order_source, true);
        $criteria->compare('timestamp', $this->timestamp, true);
        $criteria->compare('transaction_id', $this->transaction_id, true);
        $criteria->compare('bank_transaction_id', $this->bank_transaction_id, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('payment_mod', $this->payment_mod, true);
        $criteria->compare('bankname', $this->bankname, true);
        $criteria->compare('warehouse_id', $this->warehouse_id, true);
        $criteria->compare('r.name', $this->name, true);
	
	//$criteria->compare('cron_processed_flag', $this->cron_processed_flag, true);
//        $criteria->compare('source_url', $this->source_url, true);
//        $criteria->compare('source_type', $this->source_type, true);
//        $criteria->compare('source_id', $this->source_id);
//        $criteria->compare('source_name', $this->source_name, true);
//        $criteria->compare('campaign_id', $this->campaign_id);
//        $criteria->compare('buyer_shipping_cost', $this->buyer_shipping_cost);
        $criteria->compare('order_type', $this->order_type, true);
        
        

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'delivery_date DESC, created_date DESC',
            ),

//            'pagination' => array(
//                
//                //'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
//            ),
            
         'pagination' => array(
                'pageSize' => 100,
            ),
            
            ));
    }


    public function searchledger($retailerId=null, $fromDate=null, $toDate=null)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.


        $where = '';
        if($fromDate && $toDate){
            $where = " where date >= '$fromDate' and date <= '$toDate'";
        }
        elseif ($fromDate){
            $where = " where date >= '$fromDate'";
        }
        elseif ($toDate){
            $where = " where date <= '$toDate'";
        }

        $sql="
            SELECT order_id as id, delivery_date as date, 'Order' as type, total_payable_amount as invoiceAmount, NULL as paymentAmount, NULL as outstanding,           'OrderHeader/update' as update_url 
            FROM order_header oh where oh.user_id = $retailerId and status != 'Cancelled' 
            UNION ALL 
            SELECT  id, date, 'Payment' as type, NULL as invoiceAmount, payment as paymentAmount, NULL as outstanding, 'OrderHeader/update' as update_url 
            FROM retailer_payments where retailer_id = $retailerId and status=1  
            $where ";

        $sqlCount = "
            select COUNT (*) (
            SELECT oh.id
            FROM order_header oh where oh.user_id = $retailerId and status != 'Cancelled' 
            UNION ALL 
            SELECT rp.id
            FROM retailer_payments rp where retailer_id = $retailerId and status=1  
            $where 
            )";

        $count=Yii::app()->secondaryDb->createCommand($sqlCount)->queryScalar();

        $sqlDataProvider = new CSqlDataProvider($sql, array(
            'totalItemCount'=>$count,
            'sort'=>array(
                'attributes'=>array(
                    'id', 'date', 'type',
                ),
            ),
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));

        return new $sqlDataProvider;
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

    public function allcheckproductlcsv() {
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT `order_id` FROM `order_header`";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $bsae_id = $command->queryAll();
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

        $sql="select `ol`.`order_id` AS `order_id`,`ol`.`colour` AS `color`,`ol`.`pack_unit` AS `pack_unit`,group_concat(`ol`.`base_product_id` separator ',') AS `base_product_id`,group_concat(`ol`.`subscribed_product_id` separator ',') AS `subscribed_product_id`,group_concat(`ol`.`pack_size` separator ',') AS `size`,group_concat(`ol`.`product_qty` separator ',') AS `qty` ,group_concat(`ol`.`product_name` separator ',') AS `product_name` ,group_concat(`ol`.`unit_price` separator ',') AS `unit_price` ,group_concat(`ol`.`shipping_charges` separator ',') AS `shipping_charges`,group_concat(`ol`.`seller_name` separator ',') AS `seller_name`,group_concat(`sp`.`quantity` separator ',') AS `available_quantity`,group_concat(`ol`.`id` separator ',') AS `id` ,group_concat(`ol`.`status` separator ',') AS `status`,oh.user_id AS user_id,
r.min_order_price AS min_order_price,r.shipping_charge AS shipping_charge,oh.shipping_charges as header_shipping_charge
from `order_line` `ol` 
left join order_header oh ON ol.order_id=oh.order_id
left join cb_dev_groots.retailer r ON oh.user_id=r.id
left join cb_dev_groots.base_product bp 
on bp.base_product_id=ol.base_product_id 
left join `cb_dev_groots`.subscribed_product sp 
on sp.subscribed_product_id=ol.subscribed_product_id
where ol.order_id=$order_id 
group by `ol`.`colour`,`ol`.`subscribed_product_id` 
ORDER BY ol.product_name ASC";

//echo $sql;die;
        $connection = Yii::app()->secondaryDb;
        // $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
        $row = $command->queryAll();
        return $row;
    }

//    public function updatelinedescById($lineid = null, $grand_total, $gtotal_price_discount) {
//        $lineidinfo = '';
//
//        if (!empty($lineid)) {
//            $connection = Yii::app()->secondaryDb;
//            $sql = "update order_header set grand_total='" . $grand_total . "',gtotal_price_discount='" . $gtotal_price_discount . "'  where order_id = $lineid";
//            $command = $connection->createCommand($sql);
//            $command->execute();
//        }
//        return $lineidinfo;
//    }

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
    public function StatusOrderByID($order_ids,$status_order) {
        $succ = false;

        if (!empty($order_ids)) {
            $sql = "update `order_header` set status='" . $status_order . "' where order_id in($order_ids)";
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $succ1 = $command->execute();
        }
        if ($succ1) {
            return true;
        }
        return $succ;
    }
    public static function downloadCSVByIDs($store_front_ids) {
        // $succ = false;
        if (!empty($store_front_ids)) {

            $sqlchksubsid = "SELECT  `oh`.`order_number` AS Order_ID,  `unit_price` ,  `product_qty` , CONCAT(  `bp`.`pack_size` ,  `bp`.`pack_unit` ) AS 'pack_size',  `unit_price` *  `product_qty` AS  'total_price'
FROM  `order_line`  `ol` LEFT JOIN  `order_header`  `oh` ON oh.order_id = ol.order_id
LEFT JOIN  `dev_groots`.base_product bp ON bp.base_product_id = ol.subscribed_product_id WHERE ol.`order_id` in(" . $store_front_ids . ")";
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
    

    public static function downloadCSVByID($store_front_ids) {
        // $succ = false;
        if (!empty($store_front_ids)) {

            $sqlchksubsid = "SELECT  `oh`.`order_number` AS Order_ID,  `unit_price` ,  `product_qty` , CONCAT(  `bp`.`pack_size` ,  `bp`.`pack_unit` ) AS 'pack_size',  `unit_price` *  `product_qty` AS  'total_price'
FROM  `order_line`  `ol` LEFT JOIN  `order_header`  `oh` ON oh.order_id = ol.order_id
LEFT JOIN  `dev_groots`.base_product bp ON bp.base_product_id = ol.subscribed_product_id WHERE ol.`order_id` in(" . $store_front_ids . ")";
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sqlchksubsid);
            $command->execute();
            $assocDataArray = $command->queryAll();
            $csv_name = "order_" . date("d-m-Y_H-i", time()) . ".csv";
            $csv_filename = "feeds/order_csv/" . $csv_name;
            $fp = fopen($csv_filename, 'w');
            $print_result = 'OrderID,unit_price,product_qty,pack_size,total_price';
            $val = explode(",", $print_result);
            fputcsv($fp, $val);
            if (isset($assocDataArray['0'])) {
                $fp = fopen($csv_filename, 'w');
                $columnstring = implode(',', array_keys($assocDataArray['0']));
                $updatecolumn = str_replace('_', ' ', $columnstring);

                $updatecolumn = explode(',', $updatecolumn);
                fputcsv($fp, $updatecolumn);
                foreach ($assocDataArray AS $values) {
                    fputcsv($fp, $values);
                }
                fread($fp, 10);
                fclose($fp);
            }
            ob_flush();
            $from_email = 'grootsadmin@groots.in';
            $from_name = 'Groots Dashboard Admin';
            $subject = 'Order Report';

            $body_text = 'Hi, Please find the Order Report as attached CSV file.';
            $body_html = '';
           // $body_text = '';

            $mailArray = array(
                'to' => array(
                    '0' => array(
                        'email' => 'kuldeep@canbrand.in',
                    ),
                     '1' => array(
                        'email' => 'praveen@canbrand.in',
                    )
                ),
                'from' => $from_email,
                'fromname' => $from_name,
                'subject' => $subject,
                'html' => $body_html,
                'text' => $body_text,
                'replyto' => $from_email,
                'files' => array(
                    '0' => array(
                        'name' => $csv_name,
                        'path' => $csv_filename,
                    )
                ),
            );
            $urldata = Yii::app()->params['LOG_FILE_NAME_ORDER_CSV'];
            $mailsend = new OrderLine();
            $resp = $mailsend->sgSendMail($mailArray);
            $myfile = fopen($urldata,'a') or die("Unable to open file!");
            $txt = date('Y-m-d h:i:s') . " : " . $resp . "\n";
            fwrite($myfile, $txt);
            fclose($myfile);
        }
    }

    /*
    this function use for shipping charges update
    */
    // public static function updateShippingCharge($shipping_charge, $order_id){
    //       $connection = Yii::app()->secondaryDb;
    //        echo  $sql="update order_header set shipping_charges=$shipping_charge where order_id=$order_id";
    //         $command = $connection->createCommand($sql);
    //         $command->execute();
        
    // } 
    public static function getinfo($id) {
        $connection = Yii::app()->secondaryDb;
       $sql = "SELECT order_id,order_number,user_id,created_date,total_payable_amount,agent_name,delivery_date FROM order_header WHERE `order_id` ='".$id."'"
            ;
        $command = $connection->createCommand($sql);
        $pdf = $command->queryAll();
        return $pdf;
    }

    public static function getTotalOrderOfDate($date){
        $sql = "select sum(ol.delivered_qty*bp.pack_size_in_gm/1000) as total_order_in_kg from order_header oh join order_line ol on ol.order_id=oh.order_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id where oh.delivery_date = '" . $date . "' and oh.status != 'Cancelled' group by oh.delivery_date";
        $total_order_in_kg = Yii::app()->secondaryDb->createCommand($sql)->queryScalar();
        return empty($total_order_in_kg) ? 0 : $total_order_in_kg;
    }

    public static function getAvgOrderByItem($w_id, $date){
        $avgOrders = array();
        $start_date = date('Y-m-d', strtotime('-'.SCHD_INV_AVG_DAYS.' day', strtotime($date)));
        $connection = Yii::app()->secondaryDb;
        $sql = "select ol.base_product_id as bp_id, AVG(ol.delivered_qty)*bp.pack_size_in_gm/1000 as qty  from order_header oh join order_line ol on ol.order_id=oh.order_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id where oh.delivery_date >= '".$start_date."' and oh.delivery_date < '".$date."' and oh.status != 'Cancelled' and ol.delivered_qty > 0 and oh.warehouse_id=$w_id group by ol.base_product_id";
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        foreach ($result as $row){
            $avgOrders[$row['bp_id']] = $row['qty'];
        }
        return $avgOrders;
    }

    public function getName(){
        return $this->name;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getCity(){
        return $this->city;
    }

    public function getState(){
        return $this->state;
    }

    public static function getLastOrderId(){
        $order = self::model()->find(array('select'=>'order_id', 'order'=>'order_id desc', 'limit'=>1));
        return $order->order_id;
    }

    public function getWarehouseId(){
        return $this->warehouse_id;
    }

    public function getWarehouseName(){
        return $this->warehouse_name;
    }

    public function getGrootsAddress(){
        return $this->groots_address;
    }

    public function getGrootsCity(){
        return $this->groots_city;
    }

    public function getGrootsState(){
        return $this->groots_state;
    }

    public function getGrootsCountry(){
        return $this->groots_country;
    }

    public function getGrootsPincode(){
        return $this->groots_pincode;
    }

    public function getGrootsAuthorizedName(){
        return $this->groots_authorized_name;
    }

   public function setFeedbackStatusOnDelivered($orderIds, $status){
    $sql = 'update order_header set feedback_status = "'.$status.'" where order_id in ('.$orderIds.') and feedback_status != "Submitted"';
    $connection = Yii::app()->secondaryDb;
    $command = $connection->createCommand($sql);
    $command->execute();
   }

   public function ordersStatusDeliverd($orderIds){
    $orderIdString = implode(',', $orderIds);
    $connection = Yii::app()->secondaryDb;
    $sql = 'select status from order_header where order_id in ('.$orderIdString.')';
    $command = $connection->createCommand($sql);
    $command->execute();
    $result = $command->queryAll();
    //var_dump($result);die;
    $flag = 1;
    foreach ($result as $key => $value) {
        if($value['status'] != "Delivered"){
            $flag = 0;
            break;
        }
    }
    return $flag;
   }

}


