<?php

/**
 * This is the model class for table "lookbook".
 *
 * The followings are the available columns in table 'lookbook':
 * @property integer $id
 * @property integer $store_id
 * @property string $headline
 * @property string $main_img_url
 * @property string $thumb_url
 * @property string $org_img_url
 * @property string $pdf_url
 * @property integer $status
 * @property string $type
 * @property string $created_at
 */
class Lookbook extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lookbook';
    }

    private $oldAttrs = array();

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('store_id, headline', 'required'),
          //  array('headline', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in Title.'),
            array('headline', 'unique', 'on' => 'insert', 'message' => 'This Title already exists!'),
            array('store_id', 'numerical', 'integerOnly' => true),
            array('headline, type,doc_type', 'length', 'max' => 255),
            array('desciption,image_main_url,image_thumb_url', 'length', 'max' => 1000),
           // array('desciption', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in desciption.'),
            //array('image', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, store_id, headline, image_main_url, status, type, created_at', 'safe', 'on' => 'search'),
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
            'id' => 'lookbook Id',
            'store_id' => 'Brand Id',
            'headline' => 'title',
            'desciption' => 'Desciption',
            'image_thumb_url' => 'image_thumb_url',
            'status' => 'Status',
            'type' => 'Type',
            'doc_type' => 'Doc Type',
            'created_at' => 'Created At',
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
    public function search($photo = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.



        $criteria = new CDbCriteria;

        $current_url = Yii::app()->request->requestUri;
        if (strstr($current_url, 'lookbook/Adminphoto')) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= "type='photo'";
        } else if (strstr($current_url, 'lookbook/admin')) {

            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            //  echo "sds";die;
            $criteria->condition .= "type='lookbook'";
        }
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin == 1) {
            $adminid = $_GET['store_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'store_id =' . $adminid;
        } else {
            $adminid = Yii::app()->session['brand_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'store_id =' . $adminid;
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('doc_type', $this->doc_type);

        $criteria->compare('headline', $this->headline, true);
        $criteria->compare('image_thumb_url', $this->image_thumb_url, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            )
        ));
    }

    public static function getMediaByBrand($lookbook_id, $media_type, $type_page) {
        $connection = Yii::app()->db;
        $sql = "select media_url from media_linesheet where lookbook_id='" . $lookbook_id . "' and type_page='" . $type_page . "' and media_type='" . $media_type . "' order by media_id DESC limit 0,1";
        $command = $connection->createCommand($sql);
        $image = $command->queryScalar();
        return $image;
    }

    public static function getMediaByBrandphoto($lookbook_id) {
        $connection = Yii::app()->db;
        $sql = "select media_id,media_url from media_linesheet where lookbook_id='$lookbook_id' and type_page='photo' and media_type='image'";
        $command = $connection->createCommand($sql);
        $image = $command->queryAll();
        return $image;
    }

    public static function getPDFByBrand($lookbook_id, $pdf_type, $type_page) {
        $connection = Yii::app()->db;
        $sql = "select media_url from media_linesheet where lookbook_id='" . $lookbook_id . "' and type_page='" . $type_page . "' and media_type='" . $pdf_type . "' order by media_id DESC limit 0,1";
        $command = $connection->createCommand($sql);
        $pdf = $command->queryScalar();
        return $pdf;
    }

    public static function getSearchByTitle($word, $store_id) {
        $connection = Yii::app()->db;
        $sql = "select * from lookbook where headline like '%" . $word . "%' and store_id=$store_id order by id DESC";
        //  echo $sql;die;
        $command = $connection->createCommand($sql);
        $pdf = $command->queryAll();
        return $pdf;
    }

    public function deleteMediaByMediaId($media_id = null) {
        if (!empty($media_id) AND is_numeric($media_id)) {
            $media = $this->findByPk($media_id);
            @unlink($media->media_url);
            @unlink($media->thumb_url);
            $this->deleteByPk($media_id);
            return true;
        }
        return false;
    }

    /**
	 * 
	 * Remove & delete a media from table & directory
	 * @param int $media_id
	 */
	public function deletelookbook($id = null){
		if(!empty($id) AND is_numeric($id)){
			$datat = $this->findByPk($id);
			$this->deleteByPk($id);
			return true;
		}
		return false;
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Lookbook the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'Lookbook-photogallery', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertLookbookLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'Lookbook-photogallery', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertLookbookLog($data);
        }
    }

    protected function afterDelete() {
        //return parent::beforeDelete();
        $newAttrs = json_encode(array());
        $r = Yii::app()->session['last_json'];
        $oldAttrs = json_encode($r);
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'user', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertUserLog($data);
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

}
