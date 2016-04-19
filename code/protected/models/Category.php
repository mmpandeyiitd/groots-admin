<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $category_id
 * @property string $category_name
 * @property string $parent_category_id
 * @property integer $level
 * @property string $path
 * @property string $created_date
 * @property string $modified_date
 * @property integer $is_deleted
 * @property integer $is_mega_category
 * @property integer $category_shipping_charge
 */
class Category extends CActiveRecord {

    private $oldAttrs = array();
    public $cat_base_product_ids;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_name', 'required'),
            //array('category_name', 'required'),
            array('category_name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in Category Name.'),
            array('level, is_deleted,category_shipping_charge, is_mega_category, status, category_shipping_charge', 'numerical', 'integerOnly' => true),
            array(' parent_category_id', 'length', 'max' => 10),
            array('category_name, path', 'length', 'max' => 255),
            array('created_date, modified_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('category_id, category_name, parent_category_id, level, path, created_date, modified_date, is_deleted, is_mega_category, category_shipping_charge', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parent' => array(self::BELONGS_TO, 'Category', 'parent_category_id', 'condition' => 't.parent_category_id <> 0'),
            'children' => array(self::HAS_MANY, 'Category', 'parent_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'category_id' => 'Category',
            'category_name' => 'Category Name',
            'parent_category_id' => 'Parent Category',
            'level' => 'Level',
            'path' => 'Path',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
            'is_deleted' => 'Is Deleted',
            'is_mega_category' => 'Is Mega Category',
            'status' => 'Status',
            'category_shipping_charge' => 'Category Shipping Charge',
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
        $criteria->condition .= 'created_date DESC';

        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('category_name', $this->category_name, true);
        $criteria->compare('parent_category_id', $this->parent_category_id, true);
        $criteria->compare('level', $this->level);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('is_mega_category', $this->is_mega_category);
        $criteria->compare('category_shipping_charge', $this->category_shipping_charge);
        $criteria->compare('status', $this->status);
        $criteria->compare('cat_tax_per', $this->cat_tax_per);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getRecordById($store_id) {

        $connection = Yii::app()->db;
        $command = $connection->createCommand("SELECT t1.category_name AS lev1, t2.category_name as lev2, t3.category_name as lev3, t4.category_name as lev4
        FROM category AS t1
        Left JOIN category AS t2 ON t2.parent_category_id = t1.category_id
        left JOIN category AS t3 ON t3.parent_category_id = t2.category_id
        left JOIN category AS t4 ON t4.parent_category_id = t3.category_id
        WHERE t1.category_name = 'Mobile'");
        $row = $command->queryAll();
        return $row;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Category the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Get default category id
     */
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

    public function getCategoryMappingByProduId($baseProductId = null) {
        $categories = array();
        if (!empty($baseProductId) AND is_numeric($baseProductId)) {
            $connection = Yii::app()->db;
            $sql = "Select category_id FROM product_category_mapping where base_product_id = $baseProductId";
            $command = $connection->createCommand($sql);
            if ($command->execute()) {

                foreach ($command->queryAll() as $value) {
                    $categories[] = $value['category_id'];
                }
            }
        }
        return $categories;
    }

    public function getCategoriesByLevel($level = 2) {
        $criteria = new CDbCriteria();
        $criteria->condition = "level = $level AND is_deleted = 0";
        $criteria->order = 'category_name ASC';
        return $this->findAll($criteria);
    }

    public function getBaseProductIdsByCategory($category_id = null) {
        $base_pdt_ids = null;
        if (isset($category_id) AND is_numeric($category_id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT DISTINCT pcm.base_product_id 
            FROM `product_category_mapping` pcm
            INNER JOIN category c ON c.category_id = pcm.category_id
            WHERE (c.path LIKE '%/$category_id/%' OR c.category_id = $category_id)
            AND c.is_deleted = 0";

            $command = $connection->createCommand($sql);
            $command->execute();

            foreach ($command->queryAll() as $pcm) {
                $base_pdt_ids[] = $pcm['base_product_id'];
            }
        }
        return $base_pdt_ids;
    }

    public function getBaseProductIdsByCategoryone($category_id = null, $id = null) {
        $base_pdt_ids = null;
        if (isset($id) AND is_numeric($id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT category_id FROM `product_category_mapping` WHERE `base_product_id`='" . $id . "' order by category_id DESC limit 0,1";
            $command = $connection->createCommand($sql);
            $command->execute();
            $catid = $command->queryAll();
           
            if (isset($catid[0]['category_id'])) {
                $catid[0]['category_id'];
                $sqlbaseid = "SELECT distinct(base_product_id) FROM `product_category_mapping` WHERE category_id='" . $catid[0]['category_id'] . "' and `base_product_id`!='" . $id . "'";
                $command = $connection->createCommand($sqlbaseid);
                $command->execute();
                $basiinfo = $command->queryAll();
                if (isset($basiinfo) && !empty($basiinfo)) {
                    foreach ($basiinfo as $pcm) {
                        $base_pdt_ids[] = $pcm['base_product_id'];
                    }
                }
            }
        }
        return $base_pdt_ids;
    }

    public function deleteCategoryMappingByProduId($baseProductId = null) {
        if (!empty($baseProductId) AND is_numeric($baseProductId)) {
            $connection = Yii::app()->db;
            $sql = "DELETE FROM product_category_mapping where base_product_id = $baseProductId";
            $command = $connection->createCommand($sql);
            $command->execute();
            /* Logging */
            // Logging::log('product_category_mapping', Logging::DELETE, array('base_product_id'=>$baseProductId));
        }
        return true;
    }

    public function insertCategoryMappings($baseProductId = null, $categoryIds = null) {


        if (!empty($baseProductId)) {
            //delete all previous mapping for the product   ''
            $this->deleteCategoryMappingByProduId($baseProductId);
            if (!empty($categoryIds) AND is_array($categoryIds)) {
                $sql = array();
                foreach ($categoryIds as $category_id) {
                    $sql[] = "($baseProductId,$category_id)";
                }
                if (!empty($sql)) {
                    $connection = Yii::app()->db;
                    $queryStr = "INSERT INTO product_category_mapping values " . implode(',', $sql);
                    $command = $connection->createCommand($queryStr);
                    $command->execute();
                }
            }
        }
    }

    public function CategoryMappings($baseProductId = null, $categoryIds = null) {
        if (!empty($baseProductId)) {
            //delete all previous mapping for the product
            if (!empty($categoryIds) AND is_array($categoryIds)) {
                $sql = array();
                foreach ($categoryIds as $category_id) {
                    $sql[] = "($baseProductId,$category_id)";
                }
                if (!empty($sql)) {
                    $connection = Yii::app()->db;
                    $queryStr = "INSERT INTO product_category_mapping values " . implode(',', $sql);
                    $command = $connection->createCommand($queryStr);
                    $command->execute();
                }
            }
        }
    }

    public function getcatbylevel($level) {
        $connection = Yii::app()->db;
        $sql = "Select category_id,category_name FROM category where level = $level";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $rs = $command->queryAll();
    }

    public function getcatbyparrentid($pid) {
        $connection = Yii::app()->db;
        $sql = "Select category_id,category_name FROM category where parent_category_id = $pid";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $rs = $command->queryAll();
    }

    public function getBaseProducts($category_id = null) {
        $base_pdt_ids = null;
        if (isset($category_id) AND is_numeric($category_id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT DISTINCT pcm.base_product_id 
            FROM `product_category_mapping` pcm
            INNER JOIN category c ON c.category_id = pcm.category_id
            INNER JOIN base_product bp ON bp.base_product_id = pcm.base_product_id
            WHERE (c.category_id = $category_id)
            AND c.is_deleted = 0 AND bp.is_deleted = 0";

            $command = $connection->createCommand($sql);
            $command->execute();

            foreach ($command->queryAll() as $pcm) {
                $base_pdt_ids[] = $pcm['base_product_id'];
            }
        }
        return $base_pdt_ids;
    }

    public function chkchildById($category_id) {
        $category_id_del = '';
        if (isset($category_id) AND is_numeric($category_id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT category_id from category where parent_category_id='" . $category_id . "'";

            $command = $connection->createCommand($sql);
            $command->execute();
            $category_id_del = $command->queryAll();
        }
        return $category_id_del;
    }

    public function delcatById($category_id) {
        $category_id_del = '';
        if (isset($category_id) AND is_numeric($category_id)) {
            $connection = Yii::app()->db;
            //  $sql = "delete from category where category_id='".$category_id."'";
            $sql = "Update category  set is_deleted =1 where category_id='" . $category_id . "'";
            $command = $connection->createCommand($sql);
            $command->execute();
            //..................insert solor backlog.........................// 
            $connectionsolr = Yii::app()->db;
            $sqlsolr = "INSERT INTO `cat_solr_back_log`(`category_id`, `is_deleted`) VALUES ('" . $category_id . "','1')";
           $commandsolr = $connectionsolr->createCommand($sqlsolr);
            $commandsolr->execute();
        }
        $category_id_del = $this->getDefaultCategoryId();
        return $category_id_del;
    }

    public function insertBaseproductMappings($userids, $category_id) {


        $connection = Yii::app()->db;
        $sql = "delete from product_category_mapping where category_id='" . $category_id . "'";
        $command = $connection->createCommand($sql);
        $command->execute();

        foreach ($userids as $key => $value) {

            $sqlins = "INSERT INTO `product_category_mapping`(`base_product_id`, `category_id`) VALUES ('" . $value . "','" . $category_id . "')";
            $command = $connection->createCommand($sqlins);
            $command->execute();
        }

        return true;
    }

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'category', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertCategoryLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'category', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertCategoryLog($data);
        }
    }

    protected function beforeDelete() {
        //return parent::beforeDelete();
        $newAttrs = json_encode(array());
        $oldAttrs = json_encode($this->getOldAttributes());
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'category', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertCategoryLog($data);
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
    
     public function createBaseproductMappings($baseproduct_id, $category_id) {


        $connection = Yii::app()->db;
        $sql = "delete from product_category_mapping where category_id='" . $category_id . "'";
        $command = $connection->createCommand($sql);
        $command->execute();


            $sqlins = "INSERT INTO `product_category_mapping`(`base_product_id`, `category_id`) VALUES ('" . $baseproduct_id . "','" . $category_id . "')";
            $command = $connection->createCommand($sqlins);
            $command->execute();

        return true;
    }

}
