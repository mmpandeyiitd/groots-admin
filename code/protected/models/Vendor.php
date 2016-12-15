<?php

/**
 * This is the model class for table "vendors".
 *
 * The followings are the available columns in table 'vendors':
 * @property integer $id
 * @property string $name
 * @property string $vendor_code
 * @property string $VAT_number
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $telephone
 * @property string $address
 * @property string $pincode
 * @property string $owner_phone
 * @property string $owner_email
 * @property string $settlement_days
 * @property string $time_of_delivery
 * @property string $date_of_onboarding
 * @property string $city
 * @property string $state
 * @property string $image
 * @property string $image_url
 * @property string $website
 * @property string $contact_person1
 * @property string $contact_person2
 * @property integer $status
 * @property integer $credit_limit
 * @property string $created_date
 * @property string $updated_at
 * @property string $allocated_warehouse_id
 * @property string $initial_pending_amount
 * @property string $total_pending_amount
 * @property string $bussiness_name
 * @property integer $payment_terms
 * @property integer $proc_exec_id
 * @property string $vendor_type
 *
 * The followings are the available model relations:
 * @property Warehouses $allocatedWarehouse
 */
class Vendor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vendors';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, mobile, address, date_of_onboarding, credit_limit, created_date, updated_at, bussiness_name, payment_terms, proc_exec_id, vendor_type', 'required'),
			array('status, credit_limit, payment_terms, proc_exec_id', 'numerical', 'integerOnly'=>true),
			array('name, email, password, owner_email, settlement_days, time_of_delivery, bussiness_name', 'length', 'max'=>255),
			array('vendor_code, pincode, owner_phone, initial_pending_amount, total_pending_amount', 'length', 'max'=>10),
			array('VAT_number', 'length', 'max'=>50),
			array('mobile', 'length', 'max'=>100),
			array('telephone', 'length', 'max'=>15),
			array('address', 'length', 'max'=>300),
			array('city', 'length', 'max'=>200),
			array('state', 'length', 'max'=>150),
			array('image, website, contact_person1, contact_person2', 'length', 'max'=>250),
			array('allocated_warehouse_id', 'length', 'max'=>11),
			array('vendor_type', 'length', 'max'=>12),
			array('image_url, credit_days, due_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, vendor_code, VAT_number, email, password, mobile, telephone, address, pincode, owner_phone, owner_email, settlement_days, time_of_delivery, date_of_onboarding, city, state, image, image_url, website, contact_person1, contact_person2, status, credit_limit, created_date, updated_at, allocated_warehouse_id, initial_pending_amount, total_pending_amount, bussiness_name, payment_terms, proc_exec_id, vendor_type, credit_days, due_date', 'safe', 'on'=>'search'),
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
			'allocatedWarehouse' => array(self::BELONGS_TO, 'Warehouses', 'allocated_warehouse_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'vendor_code' => 'Vendor Code',
			'VAT_number' => 'Vat Number',
			'email' => 'Email',
			'password' => 'Password',
			'mobile' => 'Mobile',
			'telephone' => 'Telephone',
			'address' => 'Address',
			'pincode' => 'Pincode',
			'owner_phone' => 'Owner Phone',
			'owner_email' => 'Owner Email',
			'settlement_days' => 'Settlement Days',
			'time_of_delivery' => 'Time Of Delivery',
			'date_of_onboarding' => 'Date Of Onboarding',
			'city' => 'City',
			'state' => 'State',
			'image' => 'Image',
			'image_url' => 'Image Url',
			'website' => 'Website',
			'contact_person1' => 'Contact Person1',
			'contact_person2' => 'Contact Person2',
			'status' => 'Status',
			'credit_limit' => 'Credit Limit',
			'created_date' => 'Created Date',
			'updated_at' => 'Updated At',
			'allocated_warehouse_id' => 'Allocated Warehouse',
			'initial_pending_amount' => 'Initial Pending Amount',
			'total_pending_amount' => 'Total Pending Amount',
			'bussiness_name' => 'Bussiness Name',
			'payment_terms' => 'Payment Terms',
			'proc_exec_id' => 'Proc Exec',
			'vendor_type' => 'Vendor Type',
			'credit_days' => 'Credit Days',
			'due_date' => 'Due Date',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('vendor_code',$this->vendor_code,true);
		$criteria->compare('VAT_number',$this->VAT_number,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('pincode',$this->pincode,true);
		$criteria->compare('owner_phone',$this->owner_phone,true);
		$criteria->compare('owner_email',$this->owner_email,true);
		$criteria->compare('settlement_days',$this->settlement_days,true);
		$criteria->compare('time_of_delivery',$this->time_of_delivery,true);
		$criteria->compare('date_of_onboarding',$this->date_of_onboarding,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('image_url',$this->image_url,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('contact_person1',$this->contact_person1,true);
		$criteria->compare('contact_person2',$this->contact_person2,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('credit_limit',$this->credit_limit);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('allocated_warehouse_id',$this->allocated_warehouse_id,true);
		$criteria->compare('initial_pending_amount',$this->initial_pending_amount,true);
		$criteria->compare('total_pending_amount',$this->total_pending_amount,true);
		$criteria->compare('bussiness_name',$this->bussiness_name,true);
		$criteria->compare('payment_terms',$this->payment_terms);
		$criteria->compare('proc_exec_id',$this->proc_exec_id);
		$criteria->compare('vendor_type',$this->vendor_type,true);
		$criteria->compare('credit_days',$this->credit_days,true);
		$criteria->compare('due_date',$this->due_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vendor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchcredit(){
		$criteria = new CDbCriteria; 
        $criteria->select = 't.id, t.name, t.total_pending_amount, t.vendor_type';
        $criteria->compare('id' , $this->id, true);
       	$criteria->compare('name',$this->name,true);
       	$criteria->compare('vendor_type',$this->vendor_type,true);
       	$criteria->compare('total_pending_amount',$this->total_pending_amount,true);
       	return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

	}

	public function getCssClass(){
        $class = '';
        //var_dump($isChecked);die;
        //$isChecked = VendorDao::getVendorProductIds($vendor_id);
        // if(in_array($this->base_product_id, $isChecked)){
        //     $class .= 'isChecked';
        // }
       // else{
            if($this->parent_id > 0){
                if($this->grade=='Unsorted'){
                    $class .= " unsorted ";
                }
                $class .= "child parent-id_".$this->parent_id." item_".$this->parent_id;
            }
            elseif(isset($this->parent_id) && $this->parent_id == 0){
                $class .= "parent parent-id_".$this->parent_id." item_".$this->base_product_id;
            }
        //}
        return $class;
    }

}
