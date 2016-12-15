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
			array('cheque_status', 'length', 'max'=>10),
			array('comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, paid_amount, date, payment_type, cheque_no, debit_no, cheque_status, comment, created_at, updated_at, status', 'safe', 'on'=>'search'),
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
			'vendor_id' => 'Vendor Id',
			'paid_amount' => 'Paid Amount',
			'date' => 'Date',
			'payment_type' => 'Payment Type',
			'cheque_no' => 'Cheque No',
			'debit_no' => 'Debit No',
			'cheque_status' => 'Cheque Status',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('paid_amount',$this->paid_amount,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('cheque_no',$this->cheque_no,true);
		$criteria->compare('debit_no',$this->debit_no,true);
		$criteria->compare('cheque_status',$this->cheque_status,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('status',$this->status);

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
	 * @return VendorPayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function vendorPaymentTypes(){
        $connection = Yii::app()->secondaryDb;
        $paymentTypes = Utility::get_enum_values($connection, "vendor_payments", 'payment_type' );
        return $paymentTypes;
    }

    public static function getChequeStatus(){
        $connection = Yii::app()->secondaryDb;
        $chequeStatus = Utility::get_enum_values($connection, "vendor_payments", 'cheque_status' );
        return $chequeStatus;
    }
}
