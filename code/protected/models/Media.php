<?php

/**
 * This is the model class for table "media".
 *
 * The followings are the available columns in table 'media':
 * @property string $media_id
 * @property string $media_url
 * @property string $thumb_url
 * @property string $media_type
 * @property string $base_product_id
 * @property integer $is_default
 *
 * The followings are the available model relations:
 * @property BaseProduct $baseProduct
 */
class Media extends CActiveRecord
{
	public static $allowedMimeTypes = 	array(
											'image/jpeg',
											'image/jpg',
											'image/png',
											'image/gif'
										);
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('base_product_id', 'required'),
			array('is_default', 'numerical', 'integerOnly'=>true),
			array('media_url, thumb_url', 'length', 'max'=>255),
			array('media_type', 'length', 'max'=>45),
			array('base_product_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('media_id, media_url, thumb_url, media_type, base_product_id, is_default', 'safe', 'on'=>'search'),
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
			'baseProduct' => array(self::BELONGS_TO, 'BaseProduct', 'base_product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'media_id' => 'Media',
			'media_url' => 'Media Url',
			'thumb_url' => 'Thumb Url',
			'media_type' => 'Media Type',
			'base_product_id' => 'Base Product',
			'is_default' => 'Is Default',
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

		$criteria->compare('media_id',$this->media_id,true);
		$criteria->compare('media_url',$this->media_url,true);
		$criteria->compare('thumb_url',$this->thumb_url,true);
		$criteria->compare('media_type',$this->media_type,true);
		$criteria->compare('base_product_id',$this->base_product_id,true);
		$criteria->compare('is_default',$this->is_default);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Media the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 
	 * Get media data from base product id
	 * @param int $base_product_id
	 */
	public function getMediaByBaseProductId($base_product_id = null){
		if(!empty($base_product_id) AND is_numeric($base_product_id)){
			$criteria = new CDbCriteria();
			$criteria->condition = "base_product_id = $base_product_id";
			$criteria->order = 'is_default DESC';
			return $this->findAll($criteria);
		}
	}
        public function getOneMediaByBaseProductId($base_product_id = null){
           
	$connection = Yii::app()->db;
        $sql = "SELECT media_url  FROM `media`  where base_product_id=" . $base_product_id . " order by is_default DESC";
        $command = $connection->createCommand($sql);
        $command->execute();
        $img = $command->queryScalar();
        return $img;
	}
	
	/**
	 * 
	 * Set is_default for a media
	 * @param int $media_id
	 * @param int $base_product_id
	 */
	public function updateDefaultMediaByBaseProductId($media_id = null,$base_product_id = null){
		if(!empty($media_id) AND is_numeric($media_id) AND
			!empty($base_product_id) AND is_numeric($base_product_id))
		{
		
			$criteria = new CDbCriteria();
			$criteria->condition = "base_product_id = $base_product_id";
			$attributes = array(
				'is_default'=>0
			);
			$this->updateAll($attributes, $criteria);
			
			$attributes = array(
				'is_default'=>1
			);
			$this->updateByPk($media_id, $attributes);
			/*Logging*/
			
			return true;
		}
		return false;
	} 
	
	/**
	 * 
	 * Remove & delete a media from table & directory
	 * @param int $media_id
	 */
	public function deleteMediaByMediaId($media_id = null){
		if(!empty($media_id) AND is_numeric($media_id)){
			$media = $this->findByPk($media_id);
			@unlink($media->media_url);
			@unlink($media->thumb_url);
			$this->deleteByPk($media_id);
			return true;
		}
		return false;
	}
	
	/**
     * Overriding afterSave method for logging
     * 
     * @see framework/CActiveRecord::afterSave()
     */
	public function afterSave() {
		
		/*log save attributes*/
		//Logging::log($this->tableName(),$this->getIsNewRecord()?Logging::INSERT:Logging::UPDATE,$this->attributes);
		
		return true;
	}
	
	public static function isAllowedMimeType($mime_type = null){
		foreach(self::$allowedMimeTypes as $_allowedMimeType){
			if(strpos($mime_type, $_allowedMimeType) !== FALSE){
				return true;
			}
		}
		return false;
	}
}
