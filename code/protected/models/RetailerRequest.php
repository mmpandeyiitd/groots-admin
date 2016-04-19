<?php

/**
 * This is the model class for table "retailer_request".
 *
 * The followings are the available columns in table 'retailer_request':
 * @property integer $id
 * @property integer $retailer_id
 * @property integer $store_id
 * @property string $comment
 * @property integer $status
 * @property string $created_date
 */
class RetailerRequest extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
     public $store_name;
    public function tableName() {
        return 'retailer_request';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('retailer_id, store_id, comment', 'required'),
            array('retailer_id, store_id, status', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
             array('store_name', 'safe', 'on' => 'search'),
            array('id, retailer_id, store_id, comment, status, created_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
       return array(
            'Store' => array(self::BELONGS_TO, 'Store', 'store_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
             'store_name' => 'Brand Name',
            'retailer_id' => 'Retailer',
            'store_id' => 'Brand',
            'comment' => 'Comment',
            'status' => 'Status',
            'created_date' => 'Created Date',
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
      
        if (isset($_GET['retailer_id'])) {
           // $adminid = $_GET['store_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'retailer_id =' . $_GET['retailer_id'];
        }
//        $criteria->select = 't.*';
//        $criteria->join ='LEFT JOIN store ON store.store_id = t.store_id';
        
         $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin == 1) {
           $adminid = Yii::app()->session['brand_admin_id'];
           
            if(!empty($adminid)){
                 if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 't.store_id ='.$adminid ;
            }
        } else {
            $adminid = Yii::app()->session['brand_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 't.store_id =' . $adminid;
        }
        
        
        $criteria->with = array('Store' => array("select" => "store_name"));
        $criteria->compare('id', $this->id);
        $criteria->compare('store_name', $this->store_name);
        $criteria->compare('retailer_id', $this->retailer_id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
     public function activateuser($rquest_id,$retailer_id){
         $var='';
         if(is_numeric($rquest_id)){
    	$connection = Yii::app()->db;
        $sql = "update retailer_request set status='2' where id='".$rquest_id."' ";
        $command = $connection->createCommand($sql);
        $command->execute();  
        
        $store_id=RetailerRequest::getBrandbyretailerid($rquest_id);
        
        $sql1 = "insert into brand_retailer_mapping set store_id='".$store_id."',retailer_id='".$retailer_id."'";
        $command1 = $connection->createCommand($sql1);
        $command1->execute();  
        $var=true;
         }
         return $var;
    }

    public function deactivateuser($rquest_id,$retailer_id){
        //echo $rquest_id.$retailer_id;
       // die;
    	$connection = Yii::app()->db;
       echo  $sql = "update retailer_request set status='1' where id='".$rquest_id."'";
        $command = $connection->createCommand($sql);
        $command->execute();  
        
        $store_id=RetailerRequest::getBrandbyretailerid($rquest_id);
        
        $sql1 = "delete from brand_retailer_mapping where store_id='".$store_id."' and retailer_id='".$retailer_id."'";
        $command1 = $connection->createCommand($sql1);
        $command1->execute(); 
        
        
    }

    
    
    public function getBrandbyretailerid($rquest_id) {
        $connection = Yii::app()->db;
        $sql = "SELECT store_id  FROM `retailer_request`  where id=" . $rquest_id . "";
        $command = $connection->createCommand($sql);
        $command->execute();
        $retailerss = $command->queryScalar();
       
        return $retailerss;
    }
    public function gettotalRequestbyid($retailer_id) {
        $retailerss='';
        if(is_numeric($retailer_id)){
        $connection = Yii::app()->db;
        $sql = "SELECT count(store_id)  FROM `retailer_request`  where retailer_id=" . $retailer_id . " and status=0";
        $command = $connection->createCommand($sql);
        $command->execute();
        $retailerss = $command->queryScalar();
        }
        return $retailerss;
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RetailerRequest the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
