<?php

/**
 * This is the model class for table "csv".
 *
 * The followings are the available columns in table 'csv':
 * @property integer $id
 * @property string $name
 * @property string $age
 * @property string $model
 * @property string $max
 * @property string $accept
 * @property string $duplicate
 * @property string $denied
 */
class Bulk extends CActiveRecord {

   
    public $visible;
	public $action;
    public $date;
    /**
     * @return string the associated database table name
     */
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
            array('csv_file',
                'file', 'types' => 'csv',
                'maxSize' => 5242880,
                'allowEmpty' => true,
                'wrongType' => 'Only csv allowed.',
                'tooLarge' => 'File too large! 5MB is the limit'),
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
            'csv_file' => 'Upload CSV File',
        );
    }

    public function run() {
        if ($this->visible) {
            $this->renderContent();
        }
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
        $criteria->compare('column_35', $this->column_35, true);
        

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
        
     

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Csv the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDate(){
        return $this->date;
    }

}
