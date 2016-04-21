<?php

/**
 * This is the model class for table "retailer".
 *
 * The followings are the available columns in table 'retailer':
 * @property integer $id
 * @property string $name
 * @property string $retailer_code
 * @property string $VAT_number
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $telephone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $image
 * @property string $image_url
 * @property string $website
 * @property string $contact_person1
 * @property string $contact_person2
 * @property string $key_brand_stocked
 * @property string $product_categories
 * @property string $categories_of_interest
 * @property integer $store_size
 * @property integer $status
 * @property integer $request_status
 * @property string $created_date
 * @property string $modified_date
 */
class Retailer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'retailer';
	}
    private $oldAttrs = array();
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, retailer_code, VAT_number, email, password, mobile, address, city, state, website, contact_person1, contact_person2, product_categories, categories_of_interest, store_size, status', 'required'),
			array('id, store_size, status', 'numerical', 'integerOnly'=>true),
			array('name, image, website, contact_person1, contact_person2, categories_of_interest', 'length', 'max'=>250),
			array('retailer_code, mobile', 'length', 'max'=>10),
                        array('state,retailer_code,VAT_number,contact_person1,contact_person2', 'length', 'max' => 150),
                        array('mobile,telephone', 'length', 'min' => 10),
                        array('name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in name.'),
                        array('city', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in city.'),
                        array('email', 'unique', 'on' => 'insert', 'message' => 'email:(value) already exists!'),
                        array('mobile', 'unique', 'on' => 'insert', 'message' => 'mobile:(value) already exists!'),
                        array('product_categories,categories_of_interest', 'length', 'max' => 500),
                        array('website', 'url', 'defaultScheme' => 'http'),
                        array('modified_date', 'safe'),
                        array('image', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),

                                    // The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, retailer_code, VAT_number, email, password, mobile, telephone, address, city, state, image, image_url, website, contact_person1, contact_person2,product_categories, categories_of_interest, store_size, status, created_date, modified_date', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'retailer_code' => 'Retailer Code',
			'VAT_number' => 'Vat Number',
			'email' => 'Email',
			'password' => 'Password',
			'mobile' => 'Mobile',
			'telephone' => 'Telephone',
			'address' => 'Address',
			'city' => 'City',
			'state' => 'State',
			'image' => 'Image',
			'image_url' => 'Image Url',
			'website' => 'Website',
			'contact_person1' => 'Contact Person1',
			'contact_person2' => 'Contact Person2',
			//'key_brand_stocked' => 'Key Brand Stocked',
			'product_categories' => 'Product Categories',
			'categories_of_interest' => 'Categories Of Interest',
			'store_size' => 'Store Size',
			'status' => 'Status',
			'request_status' => 'Request Status',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
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
		$criteria->compare('retailer_code',$this->retailer_code,true);
		$criteria->compare('VAT_number',$this->VAT_number,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('image_url',$this->image_url,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('contact_person1',$this->contact_person1,true);
		$criteria->compare('contact_person2',$this->contact_person2,true);
		//$criteria->compare('key_brand_stocked',$this->key_brand_stocked,true);
		$criteria->compare('product_categories',$this->product_categories,true);
		$criteria->compare('categories_of_interest',$this->categories_of_interest,true);
		$criteria->compare('store_size',$this->store_size);
		$criteria->compare('status',$this->status);
		//$criteria->compare('request_status',$this->request_status);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Retailer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function gettotal_retailers() {
        $adminid = Yii::app()->session['brand_id'];
        $issuperadmin = Yii::app()->session['is_super_admin'];
        $row = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(id) from retailer";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $row = $command->queryScalar();
        } else {
            $row = Retailer::model()->getMappedretailersByBrandAdmin($adminid);
            $row = count($row);
        }
        return $row;
    }

    public function gettotal_retailersForindex() {
        $adminid = Yii::app()->session['brand_id'];
        $issuperadmin = Yii::app()->session['is_super_admin'];
        $row = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(id) from retailer";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$start_date" . "' AND '" . "$end_date" . "')";
            }
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $row = $command->queryScalar();
        } else {
            $row = $this->getMappedretailersByBrandAdmin($adminid);
            $row = count($row);
        }
        return $row;
    }
    public function data_retailers($rid){
      //  echo "hello";die;
         $connection = Yii::app()->db;
            $sql = "SELECT name,email,mobile FROM `retailer` where id=$rid";
            $command = $connection->createCommand($sql);
            $command->execute();
           // $retailer_name = $command->queryScalar();
            return $category_id_del = $command->queryAll();
         }

    public function getRetailerNameByID($retialerid) {
        $retailer_name = '';
        if (is_numeric($retialerid)) {
            $connection = Yii::app()->db;
            $sql = "SELECT name  FROM `retailer`  where id=$retialerid";
            $command = $connection->createCommand($sql);
            $command->execute();
            $retailer_name = $command->queryScalar();
        }
        return $retailer_name;
    }

    
   public function insertMediaretailer($media_main, $media_thumb_url, $retailer_id) {
        $sql = "INSERT INTO media_retailer(media_url, thumb_url, retailer_id) VALUES('$media_main', '$media_thumb_url', '$retailer_id')";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

   
    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'retailer ', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertRetailerListLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'retailer', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertRetailerListLog($data);
        }
    }

    protected function afterDelete() {
        parent::beforeDelete();
        $newAttrs = json_encode(array());
        // $r = Yii::app()->session['last_json'];
        $oldAttrs = json_encode($this->getAttributes());
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'user', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertRetailerListLog($data);
        //  $this->redirect(array('retailer/admin'));
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
