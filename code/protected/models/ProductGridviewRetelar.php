<?php

/**
 * This is the model class for table "product_gridviewRetelar".
 *
 * The followings are the available columns in table 'product_gridviewRetelar':
 * @property integer $retailer_id
 * @property integer $subscribed_product_id
 * @property string $effective_price
 * @property string $title
 * @property integer $discount_per
 * @property integer $status
 */
class ProductGridviewRetelar extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_gridviewRetelar';
    }
     //public $title;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('retailer_id', 'required'),
            array('retailer_id, subscribed_product_id, discount_per, status', 'numerical', 'integerOnly' => true),
            array('effective_price', 'length', 'max' => 11),
            array('title', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('retailer_id, subscribed_product_id, effective_price, title, discount_per, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Retailer' => array(self::BELONGS_TO, 'Retailer', 'retailer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'retailer_id' => 'Retailer',
            'subscribed_product_id' => 'Subscribed Product',
            'effective_price' => 'Effective Price',
            'title' => 'Title',
            'discount_per' => 'Discount Per',
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
    public function search() {
       //  echo "hello";die;
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        // echo $this->title;die;
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $retailer_id = $_GET['id'];
            if (!empty($criteria->conditions)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'retailer_id =' . $retailer_id;
        }
       

        $criteria->compare('retailer_id', $this->retailer_id);
        $criteria->compare('subscribed_product_id', $this->subscribed_product_id);
        $criteria->compare('effective_price', $this->effective_price, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('discount_per', $this->discount_per, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductGridviewRetelar the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
