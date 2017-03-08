<?php

/**
 * This is the model class for table "retailer".
 *
 * The followings are the available columns in table 'retailer':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $address
 * @property integer $city
 * @property string $state
 * @property string $product_mapped
 * @property string $brand_mapped
 * @property integer $status
 * @property string $created_date
 * @property string $modified_date
 */
class Retailer extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'retailer';
    }

    private $oldAttrs = array();

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, city', 'required'),
            array('mobile,status,store_size,request_status', 'numerical', 'integerOnly' => true),
            array('name, address,email,image_url', 'length', 'max' => 255),
            array('email', 'email'),
            array('state,retailer_code,VAT_number,contact_person1,contact_person2', 'length', 'max' => 150),
            array('mobile,telephone', 'length', 'min' => 10),
            array('name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in name.'),
            array('city', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in city.'),
            array('email', 'unique', 'on' => 'insert', 'message' => 'email:(value) already exists!'),
            array('mobile', 'unique', 'on' => 'insert', 'message' => 'mobile:(value) already exists!'),
            array('product_categories,key_brand_stocked,categories_of_interest', 'length', 'max' => 500),
            array('website', 'url', 'defaultScheme' => 'http'),
            array('modified_date', 'safe'),
            array('image', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email,request_status, status,mobile,address, city, state, status, created_date, modified_date', 'safe', 'on' => 'search'),
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
            'name' => 'Name',
            'email' => 'Email',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'image' => 'image',
            'request_status' => 'Request Status',
            'status' => 'Status',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $issuperadmin = Yii::app()->session['is_super_admin'];
        $retailers = '';

        if ($issuperadmin == 1) {

            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            if (count($retailers) > 0) {
                $criteria->condition .= 'id  !=""';
            }
        } else {
            $store_id = Yii::app()->session['brand_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $retailers = Retailer::model()->getMappedretailersByBrandAdmin($store_id);


            if (count($retailers) > 0) {
                $retailers = implode(',', $retailers);
                $criteria->condition .= 'id  in(' . $retailers . ')';
            } else {
                $criteria->condition .= 'id  =""';
            }
        }

        if (strstr(Yii::app()->request->requestUri, 'map_linesheet_retailers')) {
            if (!empty($criteria->condition)) {

                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'status  ="1"';
        }
        $criteria->distinct = true;
        $criteria->order = 'request_status DESC';
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address);
        $criteria->compare('city', $this->city);
        $criteria->compare('image', $this->image);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('request_status', $this->request_status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
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

    public function getAssociatedbrnadwithRetailer($retailerId = null) {
        $reatailer_str = '';
        if (is_numeric($retailerId)) {
            $sql = "select distinct s.store_name from store s left JOIN brand_retailer_mapping br ON br.store_id =s.store_id where  br.retailer_id=$retailerId";

            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $row = $command->queryAll();
            $num_retailer = count($row);
            if ($num_retailer > 0) {
                for ($i = 0; $i < $num_retailer; $i++) {
                    if ($i == 0) {
                        $reatailer_str = $row[$i]['store_name'];
                    } else {
                        $reatailer_str .=',' . $row[$i]['store_name'];
                    }
                }
            }
        }
        return $reatailer_str;
    }

    public function getMappedretailersByBrandAdmin($store_id) {
        $baseproducts = array();
        if (is_numeric($store_id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT *  FROM `brand_retailer_mapping`  where store_id=" . $store_id . "";
            $command = $connection->createCommand($sql);
            $command->execute();
            $retailerss = $command->queryAll();
            $baseproducts = array();
            foreach ($retailerss as $val) {
                $baseproducts[] = $val['retailer_id'];
            }
        }

        return $baseproducts;
    }

    public function getRetailerNameId() {
        $baseproducts = array();
        $connection = Yii::app()->db;
        $sql = "SELECT id,name,retailer_code,city  FROM `retailer`  where status=1 order by name ASC";
        $command = $connection->createCommand($sql);
        $command->execute();
        $retailerss = $command->queryAll();
        if (count($retailerss) > 0) {
            foreach ($retailerss as $val) {
                $baseproducts[$val['id']] = $val['name'] . '-' . $val['retailer_code'] . '-' . $val['city'];
            }
        }

        return $baseproducts;
    }

    public function insertMediaretailer($media_main, $media_thumb_url, $retailer_id) {
        $sql = "INSERT INTO media_retailer(media_url, thumb_url, retailer_id) VALUES('$media_main', '$media_thumb_url', '$retailer_id')";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function getTotalBrandWithRetailer($store_id) {
        $retailerss = 0;
        if (is_numeric($store_id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT count(store_id) FROM `brand_retailer_mapping`  where store_id='" . $store_id . "'";
            $command = $connection->createCommand($sql);
            $command->execute();
            $retailerss = $command->queryScalar();
        }

        return $retailerss;
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
