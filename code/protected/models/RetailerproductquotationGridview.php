<?php

/**
 * This is the model class for table "retailerproductquotation_gridview".
 *
 * The followings are the available columns in table 'retailerproductquotation_gridview':
 * @property string $title
 * @property string $store_price
 * @property string $store_offer_price
 * @property integer $quantity
 * @property string $store
 * @property string $retailer_id
 * @property string $effective_price
 * @property string $discount_price
 */
class RetailerproductquotationGridview extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'retailerproductquotation_gridview';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('quantity', 'numerical', 'integerOnly' => true),
            array('title, store', 'length', 'max' => 255),
            array('store_price, store_offer_price', 'length', 'max' => 12),
            array('retailer_id, effective_price, discount_price', 'length', 'max' => 11),
            array('discount_price','compare','compareValue'=>'100','operator'=>'<','message'=>'Percentage must be less than 100'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('title, store_price, store_offer_price, quantity, store, retailer_id, effective_price, discount_price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'BaseProduct' => array(self::BELONGS_TO, 'BaseProduct', 'base_product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'title' => 'Title',
            'store_price' => 'Store Price',
            'store_offer_price' => 'Store Offer Price',
            'quantity' => 'Quantity',
            'store' => 'Store',
            'retailer_id' => 'Retailer',
            'effective_price' => 'Effective Price',
            'discount_price' => 'Discount Price',
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

        $criteria = new CDbCriteria;
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $retailer_id = $_GET['id'];
            $sub_ids = $this->getSubcribeid($retailer_id);
            // $criteria->alias = 'rp2';
             $criteria->select = "rp2.status,t.subscribed_product_id,t.title,t.store_price,t.store_offer_price,IF(rp2.`effective_price` IS NULL,0,rp2.`effective_price`) AS effective_price,
IF(rp2.`discount_price` IS NULL,0,rp2.`discount_price`) AS discount_price";
            $criteria->join = "left join `retailerproductquotation_gridview` as rp2 on rp2.subscribed_product_id=t.subscribed_product_id and rp2.retailer_id=$retailer_id";
            $criteria->group = "t.subscribed_product_id";

          // $criteria->order = "rp2.effective_price DESC,rp2.discount_price DESC";
         //  echo '<pre>';print_r($criteria);die;
            
        }
       
        
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.store_price', $this->store_price, true);
        $criteria->compare('t.store_offer_price', $this->store_offer_price, true);
        $criteria->compare('t.quantity', $this->quantity);
        $criteria->compare('t.store', $this->store, true);
        $criteria->compare('t.status', $this->status, FALSE);
        $criteria->compare('retailer_id', $this->retailer_id, true);
        $criteria->compare('rp2.effective_price', $this->effective_price, true);
        $criteria->compare('rp2.discount_price', $this->discount_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
//            'pagination' => array(
//                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
//            ),
              'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public function getSubcribeid($id) {
        $connection = Yii::app()->db;
        $sql = "SELECT rp.title,rp.store_price,rp.store_offer_price,
IF(rp2.`effective_price` IS NULL,0,rp2.`effective_price`) AS effective_price,
IF(rp2.`discount_price` IS NULL,0,rp2.`discount_price`) AS discount_price
FROM `retailerproductquotation_gridview` as rp
left join `retailerproductquotation_gridview` as rp2 on  rp2.subscribed_product_id=rp.subscribed_product_id and rp2.retailer_id=$id";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del1 = $command->queryAll();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RetailerproductquotationGridview the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
   

}
