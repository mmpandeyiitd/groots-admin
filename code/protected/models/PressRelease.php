<?php

/**
 * This is the model class for table "press_release".
 *
 * The followings are the available columns in table 'press_release':
 * @property integer $id
 * @property string $comment
 * @property string $start_date
 * @property string $end_date
 * @property integer $status
 * @property integer $brand_id
 * @property string $image
 */
class PressRelease extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'press_release';
    }

    private $oldAttrs = array();

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, brand_id', 'required'),
           // array('title', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in Title.'),
            array('status, brand_id', 'numerical', 'integerOnly' => true),
            array('description,front_url', 'length', 'max' => 1000),
            array('image', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),
            array('front_url', 'url', 'defaultScheme' => 'http'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, description, start_date, end_date, status, brand_id, image', 'safe', 'on' => 'search'),
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
            'description' => 'description',
            'title' => 'title',
            'front_url' => 'Front Link',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'brand_id' => 'Brand',
            'image_thumb_url' => 'image_thumb_url',
            'image' => 'Image',
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
        if ($issuperadmin == 1) {
            $store_id = Yii::app()->session['brand_admin_id'];
            $criteria->condition .= 'brand_id  =' . $store_id;
        } else {
            $store_id = Yii::app()->session['user_id'];
            if (!empty($criteria->condition)) {

                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'brand_id  =' . $store_id;
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('front_url', $this->front_url, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('brand_id', $this->brand_id);
        $criteria->compare('image', $this->image, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PressRelease the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    
    /**
	 * 
	 * Remove & delete a media from table & directory
	 * @param int $media_id
	 */
	public function deletePresrelease($id = null){
		if(!empty($id) AND is_numeric($id)){
			$datat = $this->findByPk($id);
			$this->deleteByPk($id);
			return true;
		}
		return false;
	}
	

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'Press release ', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertPressreleasLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'Press release', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertPressreleasLog($data);
        }
    }

    protected function afterDelete($id=null) {
        if (!empty($id) AND is_numeric($id)) {
            $delete_data = $this->findByPk($media_id);
            //$delete_data-titile;
//            @unlink($media->media_url);
//            @unlink($media->thumb_url);
            $this->deleteByPk($media_id);
            return true;

            $newAttrs = json_encode(array());
            $r = Yii::app()->session['last_json'];
            $oldAttrs = json_encode($r);
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'presrelease', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertUserLog($data);
        }


        return false;
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

    public function Update_image($image_url, $media_main, $image_name, $insert_id) {
        $connection = Yii::app()->db;
        $sqlup = "update `press_release` set image='" . $image_name . "' ,image_thumb_url='" . $image_url . "',image_main_url='" . $media_main . "'   WHERE `id`='" . $insert_id . "' ";
        $command = $connection->createCommand($sqlup);
        $command->execute();
    }

}
