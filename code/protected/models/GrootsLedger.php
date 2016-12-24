<?php

/**
 * This is the model class for table "groots_ledger".
 *
 * The followings are the available columns in table 'groots_ledger':
 * @property integer $id
 * @property string $order_id
 * @property string $order_number
 * @property integer $user_id
 * @property string $agent_name
 * @property double $total_amount
 * @property double $due_amount
 * @property double $paid_amount
 * @property integer $paid_value
 * @property string $delivery_date
 * @property string $created_at
 * @property string $inv_created_at
 */
class GrootsLedger extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'groots_ledger';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_number, delivery_date, created_at', 'required'),
			array('user_id, paid_value', 'numerical', 'integerOnly'=>true),
			array('total_amount, due_amount, paid_amount', 'numerical'),
			array('order_id, order_number, agent_name', 'length', 'max'=>155),
			array('inv_created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, order_number, user_id, agent_name, total_amount, due_amount, paid_amount, paid_value, delivery_date, created_at, inv_created_at', 'safe', 'on'=>'search'),
		);
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
			'order_number' => 'Order Number',
			'user_id' => 'User',
			'agent_name' => 'Agent Name',
			'total_amount' => 'Total Amount',
			'due_amount' => 'Due Amount',
			'paid_amount' => 'Paid Amount',
			'paid_value' => 'Paid Value',
			'delivery_date' => 'Delivery Date',
			'created_at' => 'Created At',
			'inv_created_at' => 'Inv Created At',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('order_number',$this->order_number,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('agent_name',$this->agent_name,true);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('due_amount',$this->due_amount);
		$criteria->compare('paid_amount',$this->paid_amount);
		$criteria->compare('paid_value',$this->paid_value);
		$criteria->compare('delivery_date',$this->delivery_date,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('inv_created_at',$this->inv_created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->secondaryDb;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GrootsLedger the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getinfo($id) {
        $connection = Yii::app()->secondaryDb;
        $sql = "SELECT *
			FROM groots_ledger
			WHERE `order_id` ='".$id."'
			ORDER BY id DESC
			LIMIT 0 , 1";


        $command = $connection->createCommand($sql);
        $pdf = $command->queryAll();
        return $pdf;
    }

    public static function putinfo($id,$value, $dueamount) {
        


        $connection = Yii::app()->secondaryDb;
        $sql = "INSERT INTO `groots_ledger`( `order_id`, `order_number`, `user_id`, `agent_name`, `total_amount`, `due_amount`, `paid_amount`, `paid_value`, `delivery_date`, `inv_created_at`) 
         select `order_id`,`order_number`,`user_id`,`agent_name`,`total_amount`,'".$dueamount."','".$value."', `paid_value`,`delivery_date`,`inv_created_at` from groots_ledger  where `id`='".$id."'";

         
        $command = $connection->createCommand($sql);
       $command->execute();
       
    }
    public static function putreturninfo($id,$value, $dueamount) {     


        $connection = Yii::app()->secondaryDb;
        $sql = "UPDATE `groots_ledger` SET `return_amount`='".$value."',due_amount=(due_amount+".$value.")  where `id`='".$id."'";         
        $command = $connection->createCommand($sql);
        $command->execute();
       
    }

    public static function putinfonew($id,$value) {
        
     $dueamount=$id[0]['total_payable_amount']-$value;

        $connection = Yii::app()->secondaryDb;
       $sql = "INSERT INTO `groots_ledger`( `order_id`, `order_number`, `user_id`, `agent_name`, `total_amount`, `due_amount`, `paid_amount`, `delivery_date`, `inv_created_at`)values('".$id[0]['order_id']."','".$id[0]['order_number']."','".$id[0]['user_id']."','".$id[0]['agent_name']."','".$id[0]['total_payable_amount']."','".$dueamount."','".$value."','".$id[0]['delivery_date']."','".$id[0]['created_date']."')
          ";

         
        $command = $connection->createCommand($sql);
       $command->execute();
       
    }

    public static function downloadCSVByIDs($cDate,$cdate1) {


        $sqlchksubsid = "SELECT oh.`delivery_date`as 'Delivery Date',r.name as 'Client Name',r.retailer_type as 'Retailer Type', ge.name as 'Sales Representative',bp.title as 'Item Name',bp.base_title as 'Parent Item', bp.pack_size as 'Pack Size', bp.pack_unit as 'Pack Unit', bp.pack_size_in_gm as 'Pack Size In Gm', ol.product_qty*bp.pack_size_in_gm/1000 as 'Order Quantity (Kg)', ol.delivered_qty*bp.pack_size_in_gm/1000 as 'Delivered Quantity (Kg)',TRUNCATE((ol.unit_price *ol.delivered_qty),2) as 'Total Amount', oh.`invoice_number` as 'Invoice ID', oh.order_id as 'Order Id', ca.category_name as `Category Name` FROM `order_header` oh
left join order_line as ol on ol.`order_id`=oh.`order_id` left join cb_dev_groots.retailer r on r.id=oh.user_id
left join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id
left join cb_dev_groots.groots_employee as ge on r.sales_rep_id = ge.id
left join cb_dev_groots.product_category_mapping cpm on bp.base_product_id = cpm.base_product_id		
left join cb_dev_groots.category ca on ca.category_id = cpm.category_id
WHERE oh.delivery_date between('".$cDate."') and ('".$cdate1."') and oh.status not in ('Cancelled')";
	
//echo $sqlchksubsid; die;
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sqlchksubsid);
        $command->execute();
        $assocDataArray = $command->queryAll();
        //var_dump($assocDataArray);die;
        $fileName = "totalOrderByClientsProduct.csv";
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
            foreach ($assocDataArray AS $key=>$values) {
                //var_dump($values);die;
                $delvQuantityInKg = '';
                $deliveryDateArray = explode("-", $values['Delivery Date']);
                $invoice_no =  INVOICE_TEXT.$deliveryDateArray[0].$deliveryDateArray[1].$values['Order Id'];
                $values['Invoice ID'] = $invoice_no;

                /*$delvQuantityInKg = $values['Total Quantity (Kg)'] * $values['Pack Size In Gm']/1000;
                $values['Total Quantity (Kg)'] = $delvQuantityInKg;*/
                //print_r($values);die;
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }

    public static function  downloadCSVByCIDs($cDate) {

         
      $transaction = Yii::app()->secondaryDb->beginTransaction();
     $sqlchksubsid = "SELECT oh.user_id AS 'Client ID', oh.`delivery_date` AS 'Delivery Date', r.name AS 'Client Name',r.retailer_type as 'Retailer Type', TRUNCATE((SUM(bp.pack_size_in_gm *ol.product_qty))/1000,2) AS 'Total Ordered Quantity(Kg)', TRUNCATE((SUM(bp.pack_size_in_gm *ol.delivered_qty))/1000,2) AS 'Total Delivered Quantity(Kg)', TRUNCATE(SUM(oh.total_payable_amount),2) AS 'Total Amount'
				FROM `order_header` oh
			   JOIN order_line AS ol ON ol.`order_id` = oh.`order_id` 
			   left join cb_dev_groots.retailer r on r.id=oh.user_id
			   JOIN  cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id
				WHERE oh.delivery_date = '".$cDate."' and oh.status not in ('Cancelled')
				GROUP BY oh.`user_id` order by r.name ";

        $sqlTotalAmount = "SELECT oh.user_id AS 'Client ID', TRUNCATE(SUM(oh.total_payable_amount),2) AS 'Total Amount'
				FROM `order_header` oh
			   left join cb_dev_groots.retailer r on r.id=oh.user_id
				WHERE oh.delivery_date = '".$cDate."' and oh.status not in ('Cancelled')
				GROUP BY oh.`user_id` ";
//echo  $sqlchksubsid;die;
        $connection = Yii::app()->secondaryDb;
     try {
        $command = $connection->createCommand($sqlchksubsid);
        $command->execute();
        $assocDataArray = $command->queryAll();

         $command = $connection->createCommand($sqlTotalAmount);
         $command->execute();
         $totalAmountArray = $command->queryAll();

        $transaction->commit();
        } 
        catch (Exception $e) {
         $transaction->rollback();
        }
        $amountMap = array();
        foreach ($totalAmountArray as $value){
            $amountMap[$value['Client ID']] = $value['Total Amount'];
        }
        $fileName = "totalOrderByClient.csv";
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
                $values['Total Amount'] = $amountMap[$values['Client ID']];
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }
}
