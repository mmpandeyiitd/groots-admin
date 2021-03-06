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


class OrderLine extends CActiveRecord
{
    /**
    * @return string the associated database table name
    */

    private $oldAttrs = array();
    public $dbadvert = null;
    public $action;
    public $store_front_name,$delivery_request_id,$delivery_tracking_number,$unit_price_discount,$total_price_discount,$product_name;
    public $title, $parent_id;

    public function tableName()
    {
        return 'order_line';
    }

    /**
    * @return array validation rules for model attributes.
    */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

        array('order_id, subscribed_product_id, base_product_id, store_id, store_front_id', 'numerical', 'integerOnly'=>true),
            array('product_qty', 'type', 'type'=> 'float'),
        array('store_name, store_email, seller_name, status, seller_phone, seller_state, seller_city', 'length', 'max'=>150),
        array('store_front_name,delivery_request_id,delivery_tracking_number', 'length', 'max'=>250),
        array('colour', 'length', 'max'=>30),
        array('size, unit_price, price,unit_price_discount,total_price_discount', 'length', 'max'=>10),
        array('product_name', 'length', 'max'=>256),
        array('seller_address', 'safe'),
        // The following rule is used by search().
        // @todo Please remove those attributes that should not be searched.
        array('id, status, order_id, subscribed_product_id, base_product_id, store_id, store_name, store_email, store_front_id, store_front_name, seller_name, seller_phone, seller_address, seller_state, seller_city, colour, size, product_name, product_qty, unit_price, price', 'safe', 'on'=>'search'),
        );
        array('base_product_id, title', 'safe');
    }

    /**
    * @return array relational rules.
    */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabels()
    {
        return array(
        'id' => 'ID',
        'order_id' => 'Order',
        'subscribed_product_id' => 'Subscribed Product',
        'base_product_id' => 'Base Product',
        'store_id' => 'Store',
        'store_name' => 'Store Name',
        'store_email' => 'Store Email',
        'store_front_id' => 'Store Front',
        'store_front_name' => 'Store Front Name',
        'seller_name' => 'Seller Name',
        'seller_phone' => 'Seller Phone',
        'seller_address' => 'Seller Address',
        'seller_state' => 'Seller State',
        'seller_city' => 'Seller City',
        'colour' => 'Colour',
        'size' => 'Size',
        'product_name' => 'Product Name',
        'product_qty' => 'Product Qty',
        'unit_price' => 'Unit Price',
        'price' => 'Price',
        'status' => 'Status',
        'delivery_tracking_number' => 'delivery_tracking_number',
        'delivery_request_id' => 'delivery_request_id',
        'unit_price_discount' => 'unit_price_discount',
        'total_price_discount	' => 'total_price_discount'
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->order = 'product_name ASC';
        $criteria->compare('order_id',$this->order_id);
        $criteria->compare('subscribed_product_id',$this->subscribed_product_id);
        $criteria->compare('base_product_id',$this->base_product_id);
        $criteria->compare('store_id',$this->store_id);
        $criteria->compare('store_name',$this->store_name,true);
        $criteria->compare('store_email',$this->store_email,true);
        $criteria->compare('store_front_id',$this->store_front_id);
        $criteria->compare('store_front_name',$this->store_front_name,true);
        $criteria->compare('seller_name',$this->seller_name,true);
        $criteria->compare('seller_phone',$this->seller_phone,true);
        $criteria->compare('seller_address',$this->seller_address,true);
        $criteria->compare('seller_state',$this->seller_state,true);
        $criteria->compare('seller_city',$this->seller_city,true);
        $criteria->compare('colour',$this->colour,true);
        $criteria->compare('size',$this->size,true);
        $criteria->compare('product_name',$this->product_name,true);
        $criteria->compare('product_qty',$this->product_qty);
        $criteria->compare('unit_price',$this->unit_price,true);
        $criteria->compare('price',$this->price,true);
        $criteria->compare('status',$this->status,true); 
        $criteria->compare('delivery_request_id',$this->delivery_request_id,true); 
        $criteria->compare('delivery_tracking_number',$this->delivery_tracking_number,true); 

        return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
        ));
    }

    /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return OrderLine the static model class
    */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()

    {

       return Yii::app()->secondaryDb;

    }  

    public function getOrderById($OrderId = null){
        $Orderinfo ='';
        if(!empty($OrderId) AND is_numeric($OrderId)){
            $connection = Yii::app()->secondaryDb;
            $sql = "Select * FROM order_line where order_id = $OrderId";
            $command = $connection->createCommand($sql);
            $command->execute();
            $Orderinfo= $command->queryAll();
        }
        return $Orderinfo;
    } 
    
    public function getlinedetailcById($lineid = null){
        $lineidinfo ='';
       // echo $lineid;die;
        if(!empty($lineid))
        {
            $connection = Yii::app()->secondaryDb;
            $sql = "Select * FROM order_line where id = $lineid";
            $command = $connection->createCommand($sql);
            $command->execute();
            $lineidinfo = $command->queryAll();
        }
        return $lineidinfo;
    } 
    public function getlinedescById($lineid = null){
        $lineidinfo ='';
        
        if(!empty($lineid)){
            $connection = Yii::app()->secondaryDb;
            $sql = "Select * FROM line_description where line_id = $lineid";
            $command = $connection->createCommand($sql);
            $command->execute();
            $lineidinfo= $command->queryAll();
        }
        return $lineidinfo;
    } 
    
     public function Updatesizequantity($order_line_id, $baseproduct_id,$size_quantity,$shipping_charge=0){
        $lineidinfo =FALSE;
        
        if(is_numeric($order_line_id)&&is_numeric($baseproduct_id)&&is_numeric($size_quantity)){
            $connection = Yii::app()->secondaryDb;
           $sql="update order_line set product_qty=$size_quantity, shipping_charges=$shipping_charge where id = $order_line_id and base_product_id=$baseproduct_id";
            $command = $connection->createCommand($sql);
            $command->execute();
        }
    } 
     public function Updatediscountquantity($unit_price_discount, $orderline_ids_discount){
        $lineidinfo =FALSE;
       if(!empty($unit_price_discount)&&!empty($orderline_ids_discount)){
          
            $sql="update order_line set unit_price_discount=$unit_price_discount where id in ($orderline_ids_discount)";
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
        }
    } 
    public static function productname($id) {
        $title = '';
        if (is_numeric($id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT `name` FROM `retailer` WHERE `id`=$id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $title = $command->queryScalar();
        }
        return $title;
    }
      public static function buyername($id) {
        $title = '';
        if (is_numeric($id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT `name` FROM `retailer` WHERE `id`=$id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $title = $command->queryScalar();
        }
        return $title;
    }
     public static function buyernamegrid($id) {
       //  echo $id;die;
        $title = '';
        if (is_numeric($id)) {
            $connection = Yii::app()->secondaryDb;
            $sql = "SELECT `user_id` FROM `order_header` WHERE `order_id`=$id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $title1 = $command->queryScalar();
        }
        if($title1 !='')
        {
            $connection = Yii::app()->db;
            $sql = "SELECT `name` FROM `retailer` WHERE `id`=$title1";
            $command = $connection->createCommand($sql);
            $command->execute();
            $title = $command->queryScalar();
            
        }
        return $title;
    }
     public static function webiste($id) {
        $title = '';
        if (is_numeric($id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT `website` FROM `retailer` WHERE `id`=$id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $title = $command->queryScalar();
        }
        return $title;
    }
     public static function mobile($id) {
        $title = '';
        if (is_numeric($id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT `mobile` FROM `retailer` WHERE `id`=$id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $title = $command->queryScalar();
        }
        return $title;
    }
    
     public function UpdatedStatus($status,$order_id){
        $lineidinfo =FALSE;
       // echo $status;die;
       if(!empty($status)){
          
          /* $sql="update order_line set status='".$status."' where id in ($orderline_ids)";
           $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();*/
            $sql="update order_header set status='".$status."' where order_id =$order_id";
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
           
        }
    } 
    
    
    
    public  function updatelinedescById($id,$value){
        $lineidinfo ='';
        
        if(!empty($id)){
			//..................delete....................//
			$connection = Yii::app()->secondaryDb;
            $sqldel = "DELETE FROM `line_description` WHERE line_id ='".$id."'";
            $command = $connection->createCommand($sqldel);
            $command->execute();
            //$lineidinfo= $command->queryAll();			
			//.............................................//
			
			$i=4;
			foreach($value as $key=>$valueqty)
			{
				
            $connection = Yii::app()->secondaryDb;
           $sqlins = "INSERT INTO `line_description`(`line_id`, `subscribed_product_id`, `qty`, `size`) VALUES('".$id."','','".$valueqty."',".$i.")";
           
            $command = $connection->createCommand($sqlins);
            $command->execute();
           // $lineidinfo= $command->queryAll();
            $i=$i+2;
            
		   }
        }
       
    } 
    
    /** CODE EDITED AND ADDED BY MOHD ALAM **/
    protected function afterSave()
    {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id'=>'','user_id'=>Yii::app()->session['user_id'],'name'=>'order line','action'=>'update','oldAttrs'=>$oldAttrs,'newAttrs'=>$newAttrs);
            $log->insertOrderlineLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id'=>'','user_id'=>Yii::app()->session['user_id'],'name'=>'order line','action'=>'create','oldAttrs'=>$oldAttrs,'newAttrs'=>$newAttrs);
            $log->insertOrderlineLog($data);
        }
    }
     protected function beforeDelete(){
        //return parent::beforeDelete();
        $newAttrs = json_encode(array());
        $oldAttrs = json_encode($this->getOldAttributes());
        $log = new Log();
        $data = array('login_id'=>'','user_id'=>Yii::app()->session['user_id'],'name'=>'order line','action'=>'delete','oldAttrs'=>$oldAttrs,'newAttrs'=>$newAttrs);
        $log->insertOrderlineLog($data);
    }
    

    protected function afterFind()
    {
        // Save old values
        $this->setOldAttributes($this->getAttributes());

        return parent::afterFind();
    }
    public function getOldAttributes()
    {
        return $this->oldAttrs;
    }

    public function setOldAttributes($attrs)
    {
        $this->oldAttrs = $attrs;
    }
     public static function sgSendMail1($mailArray)
    {
      //echo $email.$pass;die;
        // $url  = 'http://sendgrid.com/';
    $url  = SG_URL;
    $user = SG_USER;
    $pass = SG_PASS;

    $params             = array();
    $params['api_user'] = $user;
    $params['api_key']  = $pass;
        $i                  = 0;
        $json_string        = array();
        foreach ($mailArray['to'] as $to)
        {
            if($to['email']=="grootsadmin@gmail.com")
            {
                continue;
            }
            if ($i == 0)
            {
                $params['to']        = $to['email'];
                //   $params['toname']    = $to['name'];
                $json_string['to'][] = $to['email'];
            }
            else
            {
                $json_string['to'][] = $to['email'];
            }
            $i++;
        }


    /*$params['from'] = $mailArray['from'];*/
        $params['from'] = "";

    if ($mailArray['fromname'] && $mailArray['fromname'] != '')
    {
        $params['fromname'] = $mailArray['fromname'];
    }

    $params['subject'] = $mailArray['subject'];

    if ($mailArray['html'] && $mailArray['html'] != '')
    {
        $params['html'] = $mailArray['html'];
    }

    if ($mailArray['text'] && $mailArray['text'] != '')
    {
        $params['text'] = $mailArray['text'];
    }

    if ($mailArray['replyto'] && $mailArray['replyto'] != '')
    {
        $params['replyto'] = $mailArray['replyto'];
    }

    if (isset($mailArray['files']))
    {
        foreach ($mailArray['files'] as $file)
        {
            $params['files[' . $file['name'] . ']'] = '@' . $file['path'];
        }
    }

    $params['x-smtpapi'] = json_encode($json_string);
    $request             = $url . 'api/mail.send.json';
    // Generate curl request
    $session             = curl_init($request);
    // Tell curl to use HTTP POST
    curl_setopt($session, CURLOPT_POST, true);
    // Tell curl that this is the body of the POST
    curl_setopt($session, CURLOPT_POSTFIELDS, $params);
    // Tell curl not to return headers, but do return the response
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

    // obtain response
    $response = curl_exec($session);
    curl_close($session);

    // print everything out
    return $response;
       
    }

    public static function sgSendMail($mailArray)
    {

        $sesEmail = new EmailClient();
        $sesEmail->sendMail($mailArray);
        //$sesEmail->verifyEmailToSes();
    }

    /*
    shipping charge add on view
    */
    public static function shippingChargeUpdateView($orderid,$shipping_charge) {
        if(is_numeric($orderid)){
            $connection = Yii::app()->secondaryDb;
            $sql="update order_line set shipping_charges=$shipping_charge where order_id = $orderid";
            $command = $connection->createCommand($sql);
            $command->execute();

          
           $connection = Yii::app()->secondaryDb;
           $sql = "SELECT round(sum(`product_qty`*`unit_price`)) as total_price FROM `order_line` WHERE `order_id`='".$orderid."' group by order_id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $lineidinfo= $command->queryAll();

           $connection = Yii::app()->secondaryDb;
            $sql1="UPDATE `order_header` SET `shipping_charges`='".$shipping_charge."',`total_payable_amount`='".$lineidinfo[0]['total_price']."',`total`='".$lineidinfo[0]['total_price']."' WHERE order_id ='".$orderid."' ";

           
            $command = $connection->createCommand($sql1);
            $command->execute();


        }
       
    }

    public static function getOrderLinebyOrderId($orderId){
        $orderLines = '';
        if (is_numeric($orderId)) {
            $connection = Yii::app()->secondaryDb;
            $sql = "SELECT ol.*, bp.title as product_name, bp.pack_size, bp.pack_unit  FROM `order_line` ol join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE `order_id`=$orderId and ol.delivered_qty > 0 order by bp.title asc";
            $command = $connection->createCommand($sql);
            $command->execute();
            $orderLines = $command->queryAll();
        }
        return $orderLines;
    }

    public static function getDeliveredOrderSumByDate($w_id, $date){
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT ol.base_product_id as id, SUM(ol.delivered_qty) as qty, bp.pack_size, bp.pack_unit  FROM `order_line` ol join order_header oh on oh.order_id=ol.order_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE oh.delivery_date='$date' and oh.warehouse_id=$w_id and oh.status != 'Cancelled' and oh.status= 'Delivered' group by ol.base_product_id having qty > 0 order by ol.base_product_id asc";
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $orderLines = array();
        foreach ($result as $item){
            $orderLines[$item['id']] = Utility::convertOrderToKg($item['qty'], $item['pack_size'], $item['pack_unit']);
        }

        return $orderLines;
    }

    public static function getOrderSumByDate($w_id, $date){
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT ol.base_product_id as bp_id, SUM(ol.product_qty * bp.pack_size_in_gm/1000) as qty  FROM `order_line` ol join order_header oh on oh.order_id=ol.order_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id WHERE oh.delivery_date='$date' and oh.warehouse_id=$w_id and oh.status != 'Cancelled' group by ol.base_product_id having qty > 0 order by bp.title asc";
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $orderLines = array();
        foreach ($result as $item){
            $orderLines[$item['bp_id']] = $item['qty'];
        }

        return $orderLines;
    }

    public function getProductName(){
        return $this->product_name;
    }


    public static function awsAttachmentMail($mailArray)
    {
        $sesEmail = new EmailClient();
        $sesEmail->sendEmailWithInvoices($mailArray);
    }

    public function searchMailShortOrders(){
        $date = '';
        if(isset($_POST['date'])){
            $date = $_POST['date'];
            //die($date);
        }
        else $date = date('Y-m-d');
        $criteria = new CDbCriteria;
        $criteria->select = ' case when bp.base_product_id is null then bp2.base_product_id
                                when bp.base_product_id is not null then bp.base_product_id end as base_product_id, 
                                case when bp.title is null then bp2.title 
                                when bp.title is not null then bp.title end as title';
        $criteria->distinct = true;
        $criteria->join = ' left join order_header as oh on oh.order_id = t.order_id';
        $criteria->join .= ' left join cb_dev_groots.base_product as bp2 on bp2.base_product_id = t.base_product_id';
        $criteria->join .= ' left join cb_dev_groots.base_product as bp on bp.base_product_id = bp2.parent_id';
        $criteria->condition = ' oh.status = "Confirmed" and oh.delivery_date = "'.$date.'"';
        $criteria->order = ' title';
        $criteria->compare('base_product_id', $this->base_product_id, true);
        $criteria->compare('title', $this->title, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 200,
            ),
        ));

    }

}
