<?php

/**
 * This is the model class for table "retailer_associated".
 *
 * The followings are the available columns in table 'retailer_associated':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $telephone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $retailer_code
 * @property string $created_date
 * @property string $Brand
 */
class RetailerAssociated extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'retailer_associated';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id', 'numerical', 'integerOnly' => true),
            array('name, email, address', 'length', 'max' => 255),
            array('mobile, retailer_code', 'length', 'max' => 10),
            array('telephone', 'length', 'max' => 15),
            array('city', 'length', 'max' => 200),
            array('state', 'length', 'max' => 150),
            array('created_date, Brand', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, mobile, telephone, address, city, state, retailer_code, created_date, Brand', 'safe', 'on' => 'search'),
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
            'mobile' => 'Mobile',
            'telephone' => 'Telephone',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'retailer_code' => 'Retailer Code',
            'created_date' => 'Created Date',
            'Brand' => 'Brand',
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
                $criteria->condition .= 'id =""';
            }
        }

        if (strstr(Yii::app()->request->requestUri, 'map_linesheet_retailers')) {
            if (!empty($criteria->condition)) {

                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'status  ="1"';
        }
 
        $criteria->order = 'request_status DESC';
       

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('retailer_code', $this->retailer_code, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('Brand', $this->Brand, true);
        //$criteria->distinct = true;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RetailerAssociated the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
