<?php

/**
 * This is the model class for table "base_product".
 *
 * The followings are the available columns in table 'base_product':
 * @property string $base_product_id
 * @property string $getit_base_product_id
 * @property string $title
 * @property string $small_description
 * @property string $description
 * @property string $color
 * @property string $size
 * @property string $product_weight
 * @property string $brand
 * @property string $model_name
 * @property string $model_number
 * @property string $manufacture
 * @property string $manufacture_country
 * @property integer $manufacture_year
 * @property string $specifications
 * @property string $key_features
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_description
 * @property integer $average_rating
 * @property integer $other_website_rating
 * @property integer $is_configurable
 * @property string $configurable_with
 * @property integer $status
 * @property string $created_date
 * @property string $modified_date
 * @property integer $campaign_id
 * @property integer $is_deleted
 * @property integer $is_serial_required
 * @property string $product_content_type
 * @property string $ISBN
 * @property integer $product_shipping_charge
 * @property string $video_url
 *
 * The followings are the available model relations:
 * @property Media[] $medias
 * @property ProductAttributeMapping[] $productAttributeMappings
 * @property CategoryBak[] $categoryBaks
 * @property SubscribedProduct[] $subscribedProducts
 */
class BaseSubscibedProduct extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $image;
    public $base_product_id;

    public function tableName() {
        return 'base_product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('manufacture_year, average_rating, other_website_rating, is_configurable, status, campaign_id, is_deleted, is_serial_required, product_shipping_charge', 'numerical', 'integerOnly' => true),
            array('getit_base_product_id', 'length', 'max' => 10),
            array('title, color, size, image, brand, model_name, model_number, manufacture, meta_keyword, product_content_type, ISBN, video_url', 'length', 'max' => 255),
            array('product_weight', 'length', 'max' => 12),
            array('manufacture_country', 'length', 'max' => 100),
            array('meta_title, meta_description', 'length', 'max' => 150),
            array('small_description, description, specifications, key_features, configurable_with, created_date, modified_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
             array('image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true,  'maxSize'=>1024 * 1024 * 2),
            array('base_product_id, getit_base_product_id, title, small_description, description, color, size, product_weight, brand, model_name, model_number, manufacture, manufacture_country, manufacture_year, specifications, key_features, meta_title, meta_keyword, meta_description, average_rating, other_website_rating, is_configurable, configurable_with, status, created_date, modified_date, campaign_id, is_deleted, is_serial_required, product_content_type, ISBN, product_shipping_charge, video_url', 'safe', 'on' => 'search'),
            
        );
    }

    /**
     * @return array relational rules.
     */
    public $uploadedFile;

// Gravar imagem na base de dados - cria blob field
   
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'medias' => array(self::HAS_MANY, 'Media', 'base_product_id'),
            'productAttributeMappings' => array(self::HAS_MANY, 'ProductAttributeMapping', 'base_product_id'),
            'categoryBaks' => array(self::MANY_MANY, 'CategoryBak', 'product_category_mapping(base_product_id, category_id)'),
            'subscribedProducts' => array(self::HAS_MANY, 'SubscribedProduct', 'base_product_id'),
        );
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'base_product_id' => 'Base Product',
            'getit_base_product_id' => 'Getit Base Product',
            'title' => 'Title',
            'small_description' => 'Small Description',
            'description' => 'Description',
            'color' => 'Color',
            'size' => 'Size',
            'image' => 'Image',
            'product_weight' => 'Product Weight',
            'brand' => 'Brand',
            'model_name' => 'Model Name',
            'model_number' => 'Model Number',
            'manufacture' => 'Manufacture',
            'manufacture_country' => 'Manufacture Country',
            'manufacture_year' => 'Manufacture Year',
            'specifications' => 'Specifications',
            'key_features' => 'Key Features',
            'meta_title' => 'Meta Title',
            'meta_keyword' => 'Meta Keyword',
            'meta_description' => 'Meta Description',
            'average_rating' => 'Average Rating',
            'other_website_rating' => 'Other Website Rating',
            'is_configurable' => 'Is Configurable',
            'configurable_with' => 'Configurable With',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
            'campaign_id' => 'Campaign',
            'is_deleted' => 'Is Deleted',
            'is_serial_required' => 'Is Serial Required',
            'product_content_type' => 'Product Content Type',
            'ISBN' => 'Isbn',
            'product_shipping_charge' => 'Product Shipping Charge',
            'video_url' => 'Video Url',
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

        $criteria->compare('base_product_id', $this->base_product_id, true);
        $criteria->compare('getit_base_product_id', $this->getit_base_product_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('small_description', $this->small_description, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('product_weight', $this->product_weight, true);
        $criteria->compare('brand', $this->brand, true);
        $criteria->compare('model_name', $this->model_name, true);
        $criteria->compare('model_number', $this->model_number, true);
        $criteria->compare('manufacture', $this->manufacture, true);
        $criteria->compare('manufacture_country', $this->manufacture_country, true);
        $criteria->compare('manufacture_year', $this->manufacture_year);
        $criteria->compare('specifications', $this->specifications, true);
        $criteria->compare('key_features', $this->key_features, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keyword', $this->meta_keyword, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('average_rating', $this->average_rating);
        $criteria->compare('other_website_rating', $this->other_website_rating);
        $criteria->compare('is_configurable', $this->is_configurable);
        $criteria->compare('configurable_with', $this->configurable_with, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        $criteria->compare('campaign_id', $this->campaign_id);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('is_serial_required', $this->is_serial_required);
        $criteria->compare('product_content_type', $this->product_content_type, true);
        $criteria->compare('ISBN', $this->ISBN, true);
        $criteria->compare('product_shipping_charge', $this->product_shipping_charge);
        $criteria->compare('video_url', $this->video_url, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getRecordById($base_product_id) {
	

            $connection = Yii::app()->db;
            $command = $connection->createCommand("SELECT b.`title`,b.`base_product_id`,b.`title`,b.`description`,b.`color`,b.`size`,m.thumb_url 
FROM `base_product` as b
left join media as m on m.`base_product_id`=b.base_product_id
where b.base_product_id=".$base_product_id);
            $row = $command->queryAll();
            return $row;
        }
    
    
    public function getDefaultCategoryId() {
    $cmd = Yii::app()->db->createCommand()
    ->select('category_id')
    ->from('category')
    ->where('level = 2 AND is_deleted = 0')
    ->order('category_id ASC')
    ->limit(1)
    ->queryRow();

    if (!empty($cmd)) {
        return $cmd['category_id'];
    }
    return null;
}


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BaseProduct the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
