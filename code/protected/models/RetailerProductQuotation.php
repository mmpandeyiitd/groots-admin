<?php

/**
 * This is the model class for table "retailer_product_quotation".
 *
 * The followings are the available columns in table 'retailer_product_quotation':
 * @property integer $id
 * @property integer $retailer_id
 * @property integer $subscribed_product_id
 * @property integer $effective_price
 * @property integer $discout_per
 * @property integer $status
 */
class RetailerProductQuotation extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'retailer_product_quotation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('retailer_id, subscribed_product_id, status', 'required'),
            array('retailer_id, subscribed_product_id, effective_price, discout_per, status', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, retailer_id, subscribed_product_id, effective_price, discout_per, status', 'safe', 'on' => 'search'),
        );
    }
    public function admin_retailer_id($id){
         $connection = Yii::app()->db;
       $sql = "SELECT `subscribed_product_id`,effective_price,discout_per FROM `retailer_product_quotation` WHERE `retailer_id` ='" . $id . "'";
       $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del = $command->queryAll();
         $style = $command->queryScalar();
        return $style;
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
            'retailer_id' => 'Retailer',
            'subscribed_product_id' => 'Subscribed Product',
            'effective_price' => 'Effective Price',
            'discout_per' => 'Discout Per',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('retailer_id', $this->retailer_id);
        $criteria->compare('subscribed_product_id', $this->subscribed_product_id);
        $criteria->compare('effective_price', $this->effective_price);
        $criteria->compare('discout_per', $this->discout_per);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function check_retailer_id($s_id,$r_id) {
 

        $connection = Yii::app()->db;
       $sql = "SELECT `id` FROM `retailer_product_quotation` WHERE `retailer_id` ='" . $r_id . "' AND `subscribed_product_id` ='" . $s_id . "'";
       $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del = $command->queryAll();
    }

    public function numeric($str) {
      // echo "hello";die;
        return (bool) preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
    }

    public function is_natural_no_zero($str) {
        if (!preg_match('/^[0-9]+$/', $str)) {
            return FALSE;
        }

        if ($str == 0) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RetailerProductQuotation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
