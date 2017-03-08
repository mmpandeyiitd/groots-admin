<?php

/**
 * This is the model class for table "media_linesheet".
 *
 * The followings are the available columns in table 'media_linesheet':
 * @property string $media_id
 * @property string $media_url
 * @property string $thumb_url
 * @property string $media_type
 * @property string $type_page
 * @property string $lookbook_id
 * @property integer $is_default
 */
class MediaLinesheet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'media_linesheet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_page, lookbook_id', 'required'),
			array('is_default', 'numerical', 'integerOnly'=>true),
			array('media_url, thumb_url', 'length', 'max'=>255),
			array('media_type', 'length', 'max'=>45),
			array('type_page', 'length', 'max'=>100),
			array('lookbook_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('media_id, media_url, thumb_url, media_type, type_page, lookbook_id, is_default', 'safe', 'on'=>'search'),
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
			'media_id' => 'Media',
			'media_url' => 'Media Url',
			'thumb_url' => 'Thumb Url',
			'media_type' => 'Media Type',
			'type_page' => 'Type Page',
			'lookbook_id' => 'Lookbook',
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
		$criteria->compare('type_page',$this->type_page,true);
		$criteria->compare('lookbook_id',$this->lookbook_id,true);
		$criteria->compare('is_default',$this->is_default);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MediaLinesheet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
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
    
    public function deletePdfByPdfId($media_id = null){
        if(!empty($media_id) AND is_numeric($media_id)){
            $media = $this->findByPk($media_id);
            // @unlink($media->media_url);
            // @unlink($media->thumb_url);
            $this->deleteByPk($media_id);
            return true;
        }
        return false;
    }
        
}
