<?php

/**
* This is the model class for table "solr_back_log".
*
* The followings are the available columns in table 'solr_back_log':
* @property string $subscribed_product_id
* @property integer $is_deleted
*/
class SolrBackLog extends CActiveRecord
{
    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'solr_back_log';
    }

    /**
    * @return array validation rules for model attributes.
    */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        array('subscribed_product_id', 'required'),
        array('is_deleted', 'numerical', 'integerOnly'=>true),
        array('subscribed_product_id', 'length', 'max'=>10),
        // The following rule is used by search().
        // @todo Please remove those attributes that should not be searched.
        array('subscribed_product_id, is_deleted', 'safe', 'on'=>'search'),
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
        'subscribed_product_id' => 'Subscribed Product',
        'is_deleted' => 'Is Deleted',
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

        $criteria->compare('subscribed_product_id',$this->subscribed_product_id,true);
        $criteria->compare('is_deleted',$this->is_deleted);

        return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
        ));
    }

    /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return SolrBackLog the static model class
    */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
    * Insert subscribed product ids in solr back log from store id 
    */
    public function insertByStoreId($storeId, $is_deleted) {
        $sql = "DELETE FROM {$this->tableName()} WHERE subscribed_product_id IN (
        SELECT subscribed_product_id FROM subscribed_product WHERE store_id = {$storeId}
        )";

        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();

        $sql = "INSERT INTO {$this->tableName()} (subscribed_product_id, is_deleted)
        SELECT subscribed_product_id, {$is_deleted} FROM subscribed_product WHERE store_id = {$storeId} AND is_deleted = 0";

        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute(); 

    }

    /**
    * Insert subscribed product ids in solr back log from base product id 
    */
    public function insertByBaseProductId($baseProductId, $is_deleted) {
        $sql = "DELETE FROM {$this->tableName()} WHERE subscribed_product_id IN (
        SELECT subscribed_product_id FROM subscribed_product WHERE base_product_id = {$baseProductId}
        )";

        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();

        $sql = "INSERT INTO {$this->tableName()} (subscribed_product_id, is_deleted)
        SELECT subscribed_product_id, {$is_deleted} FROM subscribed_product WHERE base_product_id = {$baseProductId} AND is_deleted = 0 AND status = 1";

        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();    



    }

    /**
    * Insert subscribed product ids in solr back log from subscribed product id 
    */
    public function insertBySubscribedProductId($subscribedProductId, $is_deleted) {
        $sql = "DELETE FROM {$this->tableName()} WHERE subscribed_product_id  = {$subscribedProductId}";

        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();

        $sql = "INSERT INTO {$this->tableName()} (subscribed_product_id, is_deleted) VALUES ($subscribedProductId, {$is_deleted})";

        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();
   


    }

    /**
    * Insert subscribed product ids in solr back log from category id 
    */
    public function insertByCategoryId($categoryId, $is_deleted) {
        $sql = "DELETE FROM {$this->tableName()} WHERE subscribed_product_id IN (
        SELECT subscribed_product_id FROM subscribed_product sp
        JOIN product_category_mapping pcm ON sp.base_product_id = pcm.base_product_id
        WHERE pcm.category_id = {$categoryId}
        )";

        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();

        $sql = "INSERT INTO {$this->tableName()} (subscribed_product_id, is_deleted)
        SELECT subscribed_product_id, {$is_deleted} FROM subscribed_product sp
        JOIN product_category_mapping pcm ON sp.base_product_id = pcm.base_product_id
        WHERE pcm.category_id = {$categoryId} AND sp.is_deleted = 0 AND sp.status = 1";

        $connection             = Yii::app() -> db;
        $command                = $connection -> createCommand($sql);
        $command -> execute();

        
    }
}
