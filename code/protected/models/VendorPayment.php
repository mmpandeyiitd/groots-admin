<?php

/**
 * This is the model class for table "vendor_payments".
 *
 * The followings are the available columns in table 'vendor_payments':
 * @property integer $id
 * @property integer $vendor_id
 * @property string $paid_amount
 * @property string $date
 * @property string $payment_type
 * @property string $cheque_no
 * @property string $debit_no
 * @property string $cheque_status
 * @property string $cheque_issue_date
 * @property string $cheque_name
 * @property string $transaction_id
 * @property string $receiving_acc_no
 * @property string $bank_name
 * @property string $isfc_code
 * @property string $acc_holder_name
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Vendors $vendor
 */
class VendorPayment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $bussiness_name;
	public function tableName()
	{
		return 'vendor_payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_id, date, created_at', 'required'),
			array('vendor_id, status', 'numerical', 'integerOnly'=>true),
			array('paid_amount', 'length', 'max'=>10),
			array('payment_type', 'length', 'max'=>11),
			array('cheque_no, debit_no', 'length', 'max'=>256),
			array('cheque_status', 'length', 'max'=>7),
			array('cheque_name', 'length', 'max'=>255),
			array('transaction_id, receiving_acc_no', 'length', 'max'=>25),
			array('bank_name, acc_holder_name', 'length', 'max'=>300),
			array('isfc_code', 'length', 'max'=>15),
			array('cheque_issue_date, comment,bussiness_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, paid_amount, date, payment_type, cheque_no, debit_no, cheque_status, cheque_issue_date, cheque_name, transaction_id, receiving_acc_no, bank_name, isfc_code, acc_holder_name, comment, created_at, updated_at, status', 'safe', 'on'=>'search'),
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
			'vendor' => array(self::BELONGS_TO, 'Vendors', 'vendor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vendor_id' => 'Vendor',
			'paid_amount' => 'Paid Amount',
			'date' => 'Date',
			'payment_type' => 'Payment Type',
			'cheque_no' => 'Cheque No',
			'debit_no' => 'Debit No',
			'cheque_status' => 'Cheque Status',
			'cheque_issue_date' => 'Cheque Issue Date',
			'cheque_name' => 'Cheque Name',
			'transaction_id' => 'Transaction',
			'receiving_acc_no' => 'Receiving Acc No',
			'bank_name' => 'Bank Name',
			'isfc_code' => 'Isfc Code',
			'acc_holder_name' => 'Acc Holder Name',
			'comment' => 'Comment',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'status' => 'Status',
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
		if(isset(Yii::app()->session['w_id']) && !empty(Yii::app()->session['w_id'])){
			$w_id = Yii::app()->session['w_id'];
			$criteria->select = 't.*,v.bussiness_name ';
			$criteria->join = 'left join cb_dev_groots.vendors as v on t.vendor_id = v.id';
			$criteria->condition = 'v.allocated_warehouse_id = '.$w_id;

		}


        $criteria->compare('id',$this->id);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('paid_amount',$this->paid_amount,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('cheque_no',$this->cheque_no,true);
		$criteria->compare('debit_no',$this->debit_no,true);
		$criteria->compare('cheque_status',$this->cheque_status,true);
		$criteria->compare('cheque_issue_date',$this->cheque_issue_date,true);
		$criteria->compare('cheque_name',$this->cheque_name,true);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('receiving_acc_no',$this->receiving_acc_no,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('isfc_code',$this->isfc_code,true);
		$criteria->compare('acc_holder_name',$this->acc_holder_name,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('status',$this->status);
        $criteria->compare('v.bussiness_name',$this->bussiness_name);

        $sort = new CSort();
        $sort->attributes = array(
            'id'=>array(
                'asc'=>'id',
                'desc'=>'id desc',
            ),
            'vendor_id'=>array(
                'asc'=>'t.vendor_id',
                'desc'=>'t.vendor_id desc',
            ),
            'bussiness_name'=>array(
                'asc'=>'v.bussiness_name',
                'desc'=>'v.bussiness_name',
            ),
            'paid_amount'=>array(
                'asc'=>'t.paid_amount',
                'desc'=>'t.paid_amount desc',
            ),
            'date'=>array(
                'asc'=>'t.date',
                'desc'=>'t.date desc',
            ),
            'cheque_status'=>array(
                'asc'=>'t.cheque_status',
                'desc'=>'t.cheque_status desc',
            ),
            'cheque_no'=>array(
                'asc'=>'t.cheque_no',
                'desc'=>'t.cheque_no desc',
            ),
            'payment_type'=>array(
                'asc'=>'t.payment_type',
                'desc'=>'t.payment_type desc',
            ),

        );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=> $sort,
            'pagination' => array(
                'pageSize' => 45,
            ),
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
	 * @return VendorPayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function vendorPaymentTypes(){
		$connection = Yii::app()->secondaryDb;
		$type = Utility::get_enum_values($connection, 'vendor_payments', 'payment_type');
		$result = array();
		foreach ($type as $key => $value) {
			$result[$value['value']] = $value['value'];
		}
		return $result;
	}

	public function getChequeStatus(){
		$connection = Yii::app()->secondaryDb;
		$status = Utility::get_enum_values($connection, 'vendor_payments', 'cheque_status');
		$result = array();
		foreach ($status as $key => $value) {
			$result[$value['value']] = $value['value'];
		}
		return $result;
	}

	public function saveVendorCashPayment($vendorId, $amount,$date){
		$vendorPayment = new VendorPayment;
		$vendorPayment->vendor_id = $vendorId;
		$vendorPayment->paid_amount = $amount;
		$vendorPayment->date = $date;
		$vendorPayment->payment_type = 'Cash';
		$vendorPayment->created_at =  date('Y-m-d H:i:s');
		if($vendorPayment->save()){
			return true;
		}
		else die(print_r($vendorPayment->getErrors()));
	}
}
