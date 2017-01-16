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
class BaseProduct extends CActiveRecord {

    private $oldAttrs = array();

    /**
     * @return string the associated database table name
     */
    public $image;
    public $base_product_id;
    public $action;
    public $categoryIds = null;
    public $store_offer_price;
    public $size_chart;
    public $shiping;
    public $grade;
    public $diameter;
    public $qunt;

    public function tableName() {
        return 'cb_dev_groots.base_product';
    }

    public function getDbConnection() {
        return Yii::app()->db;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('title,store_id,pack_size,pack_unit', 'required'),
            array('store_id,status', 'numerical', 'integerOnly' => true),
            array('title', 'match', 'pattern' => '/^[a-zA-Z0-9-_)(\s]+$/', 'message' => 'Invalid characters in Product title.'),
            array('pack_unit', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in pack unit.'),
            array('pack_size', 'numerical', 'integerOnly' => true, 'min' => 1,),
            array('title,pack_unit', 'length', 'max' => 255),
            array('color', 'length', 'max' => 15),
            array('color', 'length', 'min' => 2),
            array('description', 'length', 'max' => 2000),
            //array('specofic_keys', 'length', 'max' => 1500),
            //array('order_placement_cut_off_date,delevry_date', 'date', 'format' => 'dd/mm/yyyy'),
            // array('admin_type', 'length', 'max' => 250),
            array('created_date, modified_date,parent_id,base_title', 'safe'),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            //   array('image', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),
            array('size_chart', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),
            array('store_price,store_offer_price,parent_id,grade,priority,base_title', 'safe', 'on' => 'search'),
            array('base_product_id,pack_size,pack_unit,description,title,color,store_id,status,created_date,modified_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public $uploadedFile;

// Gravar imagem na base de dados - cria blob field
    public function beforeSave() {

        if ($file = CUploadedFile::getInstance($this, 'uploadedFile')) {
            $this->fileName = $file->name;
            $this->fileType = $file->type;
            $this->binaryfile = file_get_contents($file->tempName);
        }
        return parent::beforeSave();
    }

    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            //'medias' => array(self::HAS_MANY, 'Media', 'base_product_id'),
            //'productAttributeMappings' => array(self::HAS_MANY, 'ProductAttributeMapping', 'base_product_id'),
            // 'categoryBaks' => array(self::MANY_MANY, 'CategoryBak', 'product_category_mapping(base_product_id, category_id)'),
            'subscribed_product' => array(self::BELONGS_TO, 'SubscribedProduct', 'base_product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'base_product_id' => 'base_product_id.',
            'title' => 'title',
            'size_chart' => 'Size Chart',
            // 'gender' => 'Gender',
            // 'recommended' => 'Recommended',
            //'featured' => 'Featured',
            'description' => 'Description',
            'color' => 'Color',
            'grade' => 'grade',
            // 'size_brand' => 'Size Brand',
            'size' => 'Size',
            //'admin_id' => 'admin_id',
            'image' => 'Image',
            'store_id' => 'Brand',
            'is_configurable' => 'Is Configurable',
            'configurable_with' => 'Configurable With',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
            'available_quantity' => 'Available Quantity',
            //'minimum_order_quantity' => 'minimum order quantity',
            //'order_placement_cut_off_date' => 'Order Placement cutoff date',
            'tags' => 'tags',
            //'delevry_date' => 'delivery Date',
            'store_price' => 'Store Price',
            'store_offer_price' => 'Store Offer Price',
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
    public function search($cat_base_product_ids = null, $category_id = null) {
// @todo Please modify the following code to remove attributes that should not be searched.


        $criteria = new CDbCriteria;
        if (!empty($category_id) AND empty($cat_base_product_ids)) {
            $cat_base_product_ids = array(0);
        }

        if (!empty($cat_base_product_ids) AND is_array($cat_base_product_ids)) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'base_product_id IN (' . implode(',', $cat_base_product_ids) . ')';
        }

        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin == 1) {
            $adminid = $_GET['store_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 't.store_id =' . $adminid;
        } else {
            $adminid = Yii::app()->session['brand_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 't.store_id =' . $adminid;
        }

        if (strstr(Yii::app()->request->requestUri, 'map_linesheet_products')) {
            if (!empty($criteria->condition)) {

                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'status  ="1"';
        }
        $criteria->with = array('subscribed_product' => array("select" => "store_price,store_offer_price"));
        // $criteria->join = 'left JOIN order_line ON order_line.order_id = t.order_id';
        $criteria->compare('base_product_id', $this->base_product_id, true);
        $criteria->compare('grade', $this->grade, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('color', $this->color, true);
        //$criteria->compare('size', $this->size, true);
        // $criteria->compare('image', $this->image, true);
        $criteria->compare('store_id', $this->store_id, true);
        $criteria->compare('is_configurable', $this->is_configurable);
        $criteria->compare('configurable_with', $this->configurable_with, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        //$criteria->compare('featured', $this->featured, true);
        $criteria->compare('store_price', $this->store_price, true);
        $criteria->compare('store_offer_price', $this->store_offer_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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

    public function getBaseProductWithStoreId($storeid) {
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

    public function getBaseProductTitle_id($id) {
        $sql = "select title from base_product where base_product_id =" . $id . " order by title limit 1";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
        $title = $command->queryScalar();
        if (!empty($title)) {
            $sql = "select base_product_id from base_product where title = '" . $title . "' order by title ASC";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $dataids = $command->queryAll();

            $base_pdt_ids = array();
            foreach ($dataids as $pcm) {

                $base_pdt_ids[] = $pcm['base_product_id'];
            }
            return $base_pdt_ids;
        }
        return false;
    }

    public function configurablegrid($cat_base_product_ids = null, $category_id = null, $base_product_id_to_ommit = null) {

// @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if (!empty($category_id) AND empty($cat_base_product_ids)) {
            $cat_base_product_ids = array(0);
        }

        if (!empty($cat_base_product_ids) AND is_array($cat_base_product_ids)) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'base_product_id IN (' . implode(',', $cat_base_product_ids) . ')';
        }

        if (!empty($base_product_id_to_ommit)) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'base_product_id not in(' . $base_product_id_to_ommit . ')';
        }
        if (isset($_GET['id'])) {
            $current_style = $_GET['id'];
            if (is_numeric($current_style)) {

                if (!empty($criteria->condition)) {
                    $criteria->condition .= ' AND ';
                }
                $criteria->condition .= 'base_product_id!=' . $current_style . '';
            }
        }

        if (isset($_GET['store_id'])) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $store_id = $_GET['store_id'];
            if (is_numeric($_GET['store_id'])) {
                $criteria->condition .= 'store_id=' . $store_id;
            }
        }


        $criteria->compare('base_product_id', $this->base_product_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('is_configurable', $this->is_configurable);
        $criteria->compare('configurable_with', $this->configurable_with, true);
        $criteria->compare('status', $this->status);
// $criteria->compare('is_serial_required', $this->is_serial_required);
//  $criteria->compare('ISBN', $this->ISBN);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        $criteria->compare('is_deleted', $this->is_deleted);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function configur_InGroup($cat_base_product_ids = null, $category_id = null, $id = null) {

// @todo Please modify the following code to remove attributes that should not be searched.
        $cate_obj = new Category();
        $criteria = new CDbCriteria;
        if (!empty($category_id) AND empty($cat_base_product_ids)) {
            $cat_base_product_ids = array(0);
        }
        $baseproductids_title = BaseProduct::model()->getBaseProductTitle_id($id);
        $basproduct_list = $cate_obj->getBaseProductIdsByCategoryone($category_id, $id);
        if (!empty($basproduct_list) && !empty($baseproductids_title)) {
            $basproduct_list = array_intersect($basproduct_list, $baseproductids_title);
            $baseproduct_ids = implode(',', $basproduct_list);

            if (!empty($base_product_id_to_ommit)) {
                if (!empty($criteria->condition)) {
                    $criteria->condition .= ' AND ';
                }
                $criteria->condition .= 'base_product_id != ' . $_GET['id'];
            }
            if (!empty($basproduct_list)) {
                if (!empty($criteria->condition)) {
                    $criteria->condition .= ' AND ';
                }
                $criteria->condition .= 'base_product_id in(' . $baseproduct_ids . ')';
            }
        }
        if (empty($basproduct_list)) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'base_product_id =' . '""';
        }

        $criteria->compare('base_product_id', $this->base_product_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('is_configurable', $this->is_configurable);
        $criteria->compare('configurable_with', $this->configurable_with, true);
        $criteria->compare('status', $this->status);
// $criteria->compare('is_serial_required', $this->is_serial_required);
// $criteria->compare('ISBN', $this->ISBN);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        $criteria->compare('is_deleted', $this->is_deleted);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    /**
     * Update Base Product configurable data
     * @param string $newConfigurableIds
     * @param string $oldConfigurableIds
     * @throws Exception to be handled in caller
     * 
     * @return boolean
     */
    public function updateConfigurations($newConfigurableIds = null, $oldConfigurableIds = null) {
        try {
            $obj_solr = new SolrBackLog();
//copy ne and old ids to new variables. If empty replace by 0 to 
//avoid sql exception
            $newIds = !empty($newConfigurableIds) ? $newConfigurableIds : 0;
            $oldIds = !empty($oldConfigurableIds) ? $oldConfigurableIds : 0;



            if ($this->_validateConfigurableProducts($this->base_product_id, explode(',', $newIds))) {

                $base_pdt_ids_to_update_arr = array();
                $base_pdt_ids_to_update_arr[] = "$newIds,$oldIds";


//get all base product ids those will be affected
                $cmd = Yii::app()->db->createCommand()
                        ->select('configurable_with')
                        ->from('base_product')
                        ->where("base_product_id IN ($this->base_product_id,$newIds,$oldIds) AND configurable_with != ''");

                foreach ($cmd->queryAll() as $bp) {
                    $base_pdt_ids_to_update_arr[] = $bp['configurable_with'];
                }
                $base_pdt_ids_to_update_arr[] = $this->base_product_id;
//fetch unique base pdt ids
                $unique_base_pdt_ids_to_update_arr = array_unique(explode(',', implode(',', $base_pdt_ids_to_update_arr)));
                if (array_search(0, $unique_base_pdt_ids_to_update_arr)) {
                    unset($unique_base_pdt_ids_to_update_arr[array_search(0, $unique_base_pdt_ids_to_update_arr)]);
                }
                $base_pdt_ids_to_update_str = implode(',', $unique_base_pdt_ids_to_update_arr);

//set configurable_with of all related products to ''
                $cmd = Yii::app()->db->createCommand()
                        ->update('base_product', array(
                    'is_configurable' => 0,
                    'configurable_with' => '',
                    'modified_date' => date('Y-m-d H:i:s'),
                        ), "base_product_id IN ($base_pdt_ids_to_update_str)"
                );

                if (!empty($newIds)) {
//generate array of main product id => configurable_with
                    $configurable_ids = explode(',', $newIds);
                    $configurable_ids[] = $this->base_product_id;
                    sort($configurable_ids);
                    $finalArr = array();

                    foreach ($configurable_ids as $value) {
                        $temp = $configurable_ids;
                        unset($temp[array_search($value, $temp)]);
                        $finalArr[$value] = implode(',', $temp);
                    }

//update new configuration in base product table 
                    foreach ($finalArr as $mainId => $configurable_with) {
                        $cmd = Yii::app()->db->createCommand()
                                ->update('base_product', array(
                            'is_configurable' => 1,
                            'configurable_with' => $configurable_with,
                            'modified_date' => date('Y-m-d H:i:s'),
                                ), "base_product_id = $mainId"
                        );
                    }
                }

//push ids to solr backlog
                foreach ($unique_base_pdt_ids_to_update_arr as $value) {
                    $obj_solr->insertByBaseProductId($value, 0);
                }
                $newIds = $newIds != 0 ? $newIds : '';
                $oldIds = $oldIds != 0 ? $oldIds : '';
//log base_productid, old ids and new ids
//  Logging::log($this->tableName(),Logging::UPDATE,array('base_product_id'=>$this->base_product_id,'old_configuration'=>$oldIds,'new_configuration'=>$newIds));
                return true;
            }
        } catch (Exception $e) {
            throw $e;
        }
        return false;
    }

    public function updateConfigurations_Group($newConfigurableIds, $oldConfigurableIds, $baseproducts) {
        try {
//copy ne and old ids to new variables. If empty replace by 0 to 
//avoid sql exception
            $newIds = !empty($newConfigurableIds) ? $newConfigurableIds : 0;
            $oldIds = !empty($oldConfigurableIds) ? $oldConfigurableIds : 0;

            $baseproducts_backup = array();
            $baseproducts_backup = $baseproducts;
//  if($this->_validateConfigurableProducts($this->base_product_id,explode(',', $newIds))){
            $check = count($baseproducts);
            if ($check > 1) {
                foreach ($baseproducts as $key => $val_ids) {
                    $id = $val_ids;
                    unset($baseproducts_backup[$key]);
                    $base_ids_str = implode(',', $baseproducts_backup);
                    $baseproducts_backup = $baseproducts;
                    $connection = Yii::app()->db;
                    $queryStr = "update  base_product set configurable_with ='" . $base_ids_str . "', modified_date='" . date('Y-m-d H:i:s') . "' where base_product_id=" . $id;
                    $command = $connection->createCommand($queryStr);
                    $command->execute();
                }
            } else {
                $baseproducts = $this->configurable_with;

                $connection = Yii::app()->db;
                $queryStr = "update  base_product set configurable_with ='', modified_date='" . date('Y-m-d H:i:s') . "' where base_product_id in(" . $baseproducts . ',' . $_GET['id'] . ")";
                $command = $connection->createCommand($queryStr);
                $command->execute();
// }
            }


// }
            $newIds = $newIds != 0 ? $newIds : '';
            $oldIds = $oldIds != 0 ? $oldIds : '';
//log base_productid, old ids and new ids
            $newAttrs = json_encode($baseproducts_backup);
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'base product config', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertBaseproductLog($data);
            return true;
//}
        } catch (Exception $e) {
            throw $e;
        }
        return false;
    }

    /**
     * 
     * Validate configurable products for same category
     * and configurable attributes(color and size) 
     * @param array $confg_base_product_ids
     * @throws Exception
     * @return boolean
     */
    protected function _validateConfigurableProducts($main_base_product_id = null, $confg_base_product_ids = null) {
        if (!empty($main_base_product_id)) {
            if (!empty($confg_base_product_ids) AND is_array($confg_base_product_ids)) {
//check if category of all selected products match
                $cmd = Yii::app()->db->createCommand()
                        ->select('GROUP_CONCAT(category_id) as cats')
                        ->from('product_category_mapping')
                        ->where("base_product_id IN ($this->base_product_id," . implode(',', $confg_base_product_ids) . ")")
                        ->group('base_product_id')
                        ->order('base_product_id,category_id');

                $cats = array();
                foreach ($cmd->queryAll() as $value) {
                    $cats[] = $value['cats'];
                }

                if (count(array_unique($cats)) != 1) {
                    throw new Exception("Category Ids of selected products don't match");
                }
            }
            return true;
        } else {
            throw new Exception('Invalid Main Base Product Id');
        }
        return false;
    }

    public function getproductCount($start_date, $end_date) {
        $issuperadmin = Yii::app()->session['is_super_admin'];
        /* if ($issuperadmin) {
          $store_id = Yii::app()->session['brand_admin_id'];
          } else {
          $store_id = Yii::app()->session['brand_id'];
          } */
        $cDate = date("Y-m-d H:i:s", strtotime($start_date));
        $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
        $store_id = 1;
        $row = 0;
        if (is_numeric($store_id)) {
            $sql = "select count(base_product_id) from subscribed_product where store_id=" . $store_id;
        }
        if (!empty($start_date) && !empty($end_date)) {
            $sql = $sql . " and (created_date BETWEEN '" . "$cDate" . "' AND '" . "$cdate1" . "')";
        }
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        if ($command->execute()) {
            $row = $command->queryScalar();
        }
        return $row;
    }

    public function getBaseProductListByIds($ids) {

        $row = array();



        if (!empty($ids)) {
            $baseproduct_id = $_GET['id'];
            $ids = explode(',', $ids);
            $array[] = $baseproduct_id;

            $ids = array_diff($ids, $array);
            $ids = implode(',', array_unique($ids));
            $sql = "select * from base_product where base_product_id in(" . $ids . ")";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $row = $command->queryAll();
        }
        return $row;
    }

    public function RemovefromConfigureIds($newConfigurableIds, $oldConfigurableIds, $baseproducts) {

        try {
//copy ne and old ids to new variables. If empty replace by 0 to 
//avoid sql exception
            $newIds = !empty($newConfigurableIds) ? $newConfigurableIds : 0;
            $oldIds = !empty($oldConfigurableIds) ? $oldConfigurableIds : 0;

            $baseproducts_backup = array();
            $baseproducts_backup = $baseproducts;
//  if($this->_validateConfigurableProducts($this->base_product_id,explode(',', $newIds))){
            $check = count($baseproducts);
// echo $check;die;
            if ($check > 1) {
                foreach ($baseproducts as $key => $val_ids) {
                    $id = $val_ids;
                    unset($baseproducts_backup[$key]);
                    $base_ids_str = implode(',', $baseproducts_backup);
                    $baseproducts_backup = $baseproducts;

                    $sql = "select configurable_with from base_product where base_product_id='" . $id . "'";
                    $connection = Yii::app()->db;
                    $command = $connection->createCommand($sql);
                    $command->execute();
                    $row = $command->queryScalar();
                    $modify_configure = array_unique(explode(',', $row));

                    $modify_configure = array_diff($modify_configure, $baseproducts_backup);
                    $modify_configure = implode(',', $modify_configure);

                    $connection = Yii::app()->db;
                    $queryStr = "update  base_product set configurable_with ='" . $modify_configure . "', modified_date='" . date('Y-m-d H:i:s') . "' where base_product_id=" . $id;
                    $command = $connection->createCommand($queryStr);
                    $command->execute();
                }
            } else {
                $baseproducts = $this->configurable_with;

                $connection = Yii::app()->db;
                $queryStr = "update  base_product set configurable_with ='', modified_date='" . date('Y-m-d H:i:s') . "' where base_product_id in(" . $baseproducts . ',' . $_GET['id'] . ")";
                $command = $connection->createCommand($queryStr);
                $command->execute();
// }
            }


// }
            $newIds = $newIds != 0 ? $newIds : '';
            $oldIds = $oldIds != 0 ? $oldIds : '';
//log base_productid, old ids and new ids
            $newAttrs = json_encode($baseproducts_backup);
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'base product config', 'action' => 'remove', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertBaseproductLog($data);
            return true;
//}
        } catch (Exception $e) {
            throw $e;
        }
        return false;
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

    /** CODE EDITED AND ADDED BY MOHD ALAM * */
    protected function afterSave() {
        parent::afterSave();
        if (!$this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'base product', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertBaseproductLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'base product', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertBaseproductLog($data);
        }
    }

    protected function beforeDelete() {
//return parent::beforeDelete();
        $newAttrs = json_encode(array());
        $oldAttrs = json_encode($this->getOldAttributes());
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'base product', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertBaseproductLog($data);
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

    public function getTotalproductofBrand($store_id) {
        $connection = Yii::app()->db;
        $sql = "SELECT count(store_id) FROM `base_product`  where store_id='" . $store_id . "'";
        $command = $connection->createCommand($sql);
        $command->execute();
        $style = $command->queryScalar();
        return $style;
    }

    public function getProductMappedWithLinesheet($storefront_id, $store_id) {
        $mapped_producs11 = '';
        $store_front = new StoreFront();
        $mapped_producs = $store_front->getMappedbaseproductbystorefront($storefront_id);
        if (count($mapped_producs) > 0) {
            $mapped_producs11 = implode(',', $mapped_producs);

            $sql = "SELECT * FROM `base_product`  where base_product_id in($mapped_producs11) and store_id=$store_id order by base_product_id DESC";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $style = $command->queryAll();
            return $style;
        }
    }

    public function getProducforMappingLinesheet($storefront_id, $store_id) {
        $style = array();
        $store_front = new StoreFront();
        $mapped_producs = $store_front->getMappedbaseproductbystorefront($storefront_id);
        if (count($mapped_producs) > 0 && is_numeric($store_id)) {
            $mapped_producs11 = implode(',', $mapped_producs);
            $sql = "SELECT * FROM `base_product`  where  store_id=$store_id and base_product_id not in($mapped_producs11) order by base_product_id DESC";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $style = $command->queryAll();
        } else if (is_numeric($store_id)) {
            $sql = "SELECT * FROM `base_product`  where  store_id=$store_id  order by base_product_id DESC";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
            $style = $command->queryAll();
        }

        return $style;
    }

    public static function getSearchByTitle($word, $store_id) {
        $connection = Yii::app()->db;
        $sql = "select * from base_product where title like '%" . $word . "%' and store_id=$store_id order by base_product_id DESC";
        $command = $connection->createCommand($sql);
        $pdf = $command->queryAll();
        return $pdf;
    }

    public function insertMedia($media_main, $media_thumb_url, $base_product_id, $midia_type, $is_default) {
        $sql = "INSERT INTO media(media_url, thumb_url, base_product_id, media_type,is_default) VALUES('$media_main', '$media_thumb_url', '$base_product_id', '$midia_type','$is_default')";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function getStyleTitleByID($baseproduct_id, $store_id) {
        $title = '';
        if (is_numeric($baseproduct_id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT title FROM `base_product` where base_product_id=$baseproduct_id and store_id=$store_id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $title = $command->queryScalar();
        }
        return $title;
    }

    public static function Update_subscribed_product($baseid, $s_id, $store_price, $store_offer_price, $qunt,$diameter=null,$grade=null) {
        if(!empty($diameter) && !empty($grade) ){
            $sql = 'update subscribed_product set store_price="' . $store_price . '",store_offer_price="' . $store_offer_price . '",quantity="' . $qunt . '",diameter ="' . $diameter . '", grade ="' . $grade . '" where base_product_id="' . $baseid . '" AND store_id="' . $s_id . '"';
        }else if(empty($diameter) && !empty($grade)){
            $sql = 'update subscribed_product set store_price="' . $store_price . '",store_offer_price="' . $store_offer_price . '",quantity="' . $qunt . '",grade ="' . $grade . '" where base_product_id="' . $baseid . '" AND store_id="' . $s_id . '"';

        }else if(!empty($diameter) && empty($grade)){
             $sql = 'update subscribed_product set store_price="' . $store_price . '",store_offer_price="' . $store_offer_price . '",quantity="' . $qunt . '",diameter ="' . $diameter . '" where base_product_id="' . $baseid . '" AND store_id="' . $s_id . '"';

        }else{
            $sql = 'update subscribed_product set store_price="' . $store_price . '",store_offer_price="' . $store_offer_price . '",quantity="' . $qunt . '" where base_product_id="' . $baseid . '" AND store_id="' . $s_id . '"';
        }


        //$sql = 'update subscribed_product set store_price="' . $store_price . '",store_offer_price="' . $store_offer_price . '",quantity="' . $qunt . '" where base_product_id="' . $baseid . '" AND store_id="' . $s_id . '"';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();

//        if (!$command->execute()) {
//          $connection = Yii::app()->db;
//            $sql ="insert into subscribed_product set store_offer_price='" . $store_offer_price . "',store_price='" . $store_price . "', base_product_id='" . $baseid . "' ,grade ='" . $grade . "',diameter ='" . $diameter . "',quantity ='" . $qunt . "', store_id='" . $s_id . "' ";
//            $command = $connection->createCommand($sql);
//            $command->execute();
//          }
    }

    public static function Update_product_title($title, $bp) {

        $sql = 'update base_product set title="' . $title . '" where base_product_id="' . $bp . '"';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
//        if (!$command->execute()) {
//          $connection = Yii::app()->db;
//            $sql ="insert into subscribed_product set store_offer_price='" . $store_offer_price . "',store_price='" . $store_price . "', base_product_id='" . $baseid . "' ,grade ='" . $grade . "',diameter ='" . $diameter . "',quantity ='" . $qunt . "', store_id='" . $s_id . "' ";
//            $command = $connection->createCommand($sql);
//            $command->execute();
//          }
    }

    public static function Update_sizechart($base_product_id, $mage, $image_url) {

        $sql = "update base_product set size_chart='" . $image_url . "' where base_product_id='" . $base_product_id . "'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public static function getStyleReport($base_product_ids) {
        $title = '';
        if (is_numeric($baseproduct_id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT title FROM `base_product` where base_product_id=$baseproduct_id and store_id=$store_id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $title = $command->queryScalar();
        }
        return $title;
    }

    public static function downloadCSVByIDs($base_product_ids) {
        if (!empty($base_product_ids)) {
            //$sqlchksubsid = "select `bp`.`base_product_id` AS `Base product_id`,`bp`.`title` AS `title`,`bp`.`description` AS `Description`,`bp`.`color` AS `Color`,`bp`.`size` AS `Size`,`bp`.`configurable_with` AS `Configurable_With`,`bp`.`minimum_order_quantity` AS `Available_Quantity`,`bp`.`order_placement_cut_off_date` AS `Order_Placement_Cut_Off_Date`,`bp`.`delevry_date` AS `Delevry_Date`,`bp`.`tags` AS `Tags`,`bp`.`specofic_keys` AS `Attributes`,(case `bp`.`status` when 1 then 'Enable' else 'Disable' end) AS `status`,(case `bp`.`gender` when 1 then 'Men' when 2 then 'Women' else 'unisex' end) AS `gender`,`sp`.`store_price` AS `MRP`,`sp`.`store_offer_price` AS `WSP`,`bp`.`available_quantity` AS `available_quantity`,`s`.`store_name` AS `store_name`,group_concat(distinct `sf`.`store_front_name` separator ',') AS `linesheet` from ((((`base_product` `bp` left join `linesheet_products_mapping` `lp` on((`bp`.`base_product_id` = `lp`.`base_product_id`))) left join `store_front` `sf` on((`sf`.`store_front_id` = `lp`.`store_front_id`))) left join `store` `s` on((`s`.`store_id` = `bp`.`store_id`))) left join `subscribed_product` `sp` on((`bp`.`base_product_id` = `sp`.`base_product_id`))) where `bp`.base_product_id in($base_product_ids) group by `bp`.`base_product_id`";
            $sqlchksubsid = "select `bp`.`base_product_id` AS `Base product id`,`bp`.`title` AS `title`,`bp`.`description` AS `Description`,`bp`.`color` AS `Color`,(case `bp`.`status` when 1 then 'Enable' else 'Disable' end) AS `status`,`sp`.`store_price` AS `store price`,`sp`.`store_offer_price` AS `store offer price`,`sp`.`quantity` AS `quantity`,`s`.`store_name` AS `store_name` from ((((`base_product` `bp` left join `store_front_products_mapping` `lp` on((`bp`.`base_product_id` = `lp`.`base_product_id`))) left join `store_front` `sf` on((`sf`.`store_front_id` = `lp`.`store_front_id`))) left join `store` `s` on((`s`.`store_id` = `bp`.`store_id`))) left join `subscribed_product` `sp` on((`bp`.`base_product_id` = `sp`.`base_product_id`))) where `bp`.base_product_id in($base_product_ids) group by `bp`.`base_product_id`";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sqlchksubsid);
            $command->execute();
            $assocDataArray = $command->queryAll();
            $fileName = "ProductList.csv";
            ob_clean();
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($assocDataArray['0'])) {
                $fp = fopen('php://output', 'w');
                $columnstring = implode(',', array_keys($assocDataArray['0']));
                $updatecolumn = str_replace('_', ' ', $columnstring);
                $updatecolumn = explode(',', $updatecolumn);
                fputcsv($fp, $updatecolumn);
                foreach ($assocDataArray AS $values) {
                    if (!empty($values['Attributes'])) {

                        $json_array = json_decode($values['Attributes'], true);

                        if (count($json_array) > 0) {
                            $json_var = array();
                            foreach ($json_array['specific_key'] as $key => $value) {
                                $json_var[] = trim($key) . ATTRIBUTE_SEPARATOR . trim($value);
                            }

                            $values['Attributes'] = implode(NEXT_ATTRIBUTE_SEPARATOR, $json_var);
                        }
                    }
                    fputcsv($fp, $values);
                }
                fclose($fp);
            }
            ob_flush();
        }
    }

    public static function downloadproductCSV() {

        //$sqlchksubsid = "select `bp`.`base_product_id` AS `Base product_id`,`bp`.`title` AS `title`,`bp`.`description` AS `Description`,`bp`.`color` AS `Color`,`bp`.`size` AS `Size`,`bp`.`configurable_with` AS `Configurable_With`,`bp`.`minimum_order_quantity` AS `Available_Quantity`,`bp`.`order_placement_cut_off_date` AS `Order_Placement_Cut_Off_Date`,`bp`.`delevry_date` AS `Delevry_Date`,`bp`.`tags` AS `Tags`,`bp`.`specofic_keys` AS `Attributes`,(case `bp`.`status` when 1 then 'Enable' else 'Disable' end) AS `status`,(case `bp`.`gender` when 1 then 'Men' when 2 then 'Women' else 'unisex' end) AS `gender`,`sp`.`store_price` AS `MRP`,`sp`.`store_offer_price` AS `WSP`,`bp`.`available_quantity` AS `available_quantity`,`s`.`store_name` AS `store_name`,group_concat(distinct `sf`.`store_front_name` separator ',') AS `linesheet` from ((((`base_product` `bp` left join `linesheet_products_mapping` `lp` on((`bp`.`base_product_id` = `lp`.`base_product_id`))) left join `store_front` `sf` on((`sf`.`store_front_id` = `lp`.`store_front_id`))) left join `store` `s` on((`s`.`store_id` = `bp`.`store_id`))) left join `subscribed_product` `sp` on((`bp`.`base_product_id` = `sp`.`base_product_id`))) where `bp`.base_product_id in($base_product_ids) group by `bp`.`base_product_id`";

        $effective_date =Utility::getDefaultDeliveryDate();
        $sqlchksubsid = "SELECT bp.base_product_id AS 'Base Product ID',title AS Name,sp.store_price AS 'Store Price',sp.store_offer_price AS 'Price(Store Offer Price)','$effective_date' as 'Effective Price Date',bp.image as image,bp.pack_size AS 'Pack Size',bp.pack_unit AS 'Pack Unit',bp.status AS Status,sp.grade AS Grade,sp.diameter AS Diameter, bp.parent_id as 'parent id', pcm.category_id as categoryId, bp.grade as grade, bp.priority as priority, bp.base_title as baseTitle  FROM `base_product` `bp` LEFT JOIN `subscribed_product` `sp` ON sp.base_product_id = bp.base_product_id LEFT JOIN product_category_mapping pcm on pcm.base_product_id=bp.base_product_id order by categoryId asc, base_title asc, priority asc";
        //$sqlchksubsid = "SELECT bp.base_product_id AS 'Subscribed Product ID',title AS Name,sp.store_price AS  'Store Price',sp.store_offer_price AS 'Price(Store Offer Price)' FROM `base_product` `bp` LEFT JOIN  `subscribed_product` `sp` ON sp.base_product_id = bp.base_product_id ";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sqlchksubsid);
        $command->execute();
        $assocDataArray = $command->queryAll();
        $fileName = "Bulk_Upload_product_Update.csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);
        if (isset($assocDataArray['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($assocDataArray['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);
            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($assocDataArray AS $values) {
                if (!empty($values['Attributes'])) {

                    $json_array = json_decode($values['Attributes'], true);

                    if (count($json_array) > 0) {
                        $json_var = array();
                        foreach ($json_array['specific_key'] as $key => $value) {
                            $json_var[] = trim($key) . ATTRIBUTE_SEPARATOR . trim($value);
                        }

                        $values['Attributes'] = implode(NEXT_ATTRIBUTE_SEPARATOR, $json_var);
                    }
                }
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }


    public static function  PopularItems(){
        //echo "<pre>";
        //$popularItems = BaseProduct::model()->findAllByAttributes(array('parent_id'=>null, 'popularity'=>1,'status'=>1));
        //$popularItems = BaseProduct::model()->findAllByAttributes(array('parent_id'=>null,'status'=>1), array('condition'=> ' popularity in (1)', 'order'=> 'title asc' ));
        $connection = Yii::app()->secondaryDb;
        $sqlLastDelDate = "select max(delivery_date) from transfer_header where transfer_type='regular'";
        $command = $connection->createCommand($sqlLastDelDate);
        $command->execute();
        //var_dump($command);die;
        $lastDelDate = $command->queryScalar();
        if(empty($lastDelDate)){
            $lastDelDate = date('Y-m-d');
        }
           // ->queryScalar();
        //$date_prev = date('Y-m-d', strtotime($lastDelDate." -1 days"));

        $sql = "SELECT bp.base_product_id,bp.title,bp.parent_id FROM `order_line` ol join order_header oh on oh.order_id=ol.order_id join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id where oh.delivery_date >= '".$lastDelDate."' and oh.status != 'Cancelled' group by ol.base_product_id order by title asc";
        //die($sql);
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        $parent_id = array();
        foreach ($result as $item){
            if( $item['parent_id'] > 0){
               array_push($parent_id, $item['parent_id']);
            }
        }
        $sqlParent = "SELECT bp.base_product_id,bp.title,bp.parent_id from cb_dev_groots.base_product bp left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id where bp.base_product_id in (".implode(",", $parent_id).") group by bp.base_product_id order by title asc";
        //echo $sqlParent;die;
        $command = $connection->createCommand($sqlParent);
        $command->execute();
        $resultParent = $command->queryAll();
        $parentIdMap = array();
        foreach ($resultParent as $item){
            $purchaseLine = new PurchaseLine();
            $purchaseLine->base_product_id = $item['base_product_id'];
            $purchaseLine->title = $item['title'];
            $purchaseLine->parent_id = $item['parent_id'];
            $parentIdMap[$item['base_product_id']] = $purchaseLine;
        }

        $purchaseLineArr = array();
        foreach ($result as $item){
            $purchaseLine = new PurchaseLine();
            $purchaseLine->base_product_id = $item['base_product_id'];
            $purchaseLine->title = $item['title'];
            $purchaseLine->parent_id = $item['parent_id'];

            if($item['parent_id'] > 0 && isset($parentIdMap[$item['parent_id']])){
                array_push($purchaseLineArr, $parentIdMap[$item['parent_id']]);
                unset($parentIdMap[$item['parent_id']]);
            }
            array_push($purchaseLineArr, $purchaseLine);
        }
        //print_r($parentIdMap);die;
        $otherItems = BaseProduct::model()->findAllByAttributes(array('status'=>1), array( 'select'=>'base_product_id,title,parent_id', 'order'=>'title asc'));
        $otherItemArray = array();
        foreach ($otherItems as $item){
            $tmp = array();
            $tmp['bp_id'] = $item->base_product_id;
            $tmp['title'] = $item->title;
            $tmp['parent_id'] = $item->parent_id;
            array_push($otherItemArray, $tmp);
        }

        return [$purchaseLineArr, $otherItemArray];
    }

    public static function getChildBPIds($parentId){
        $bpIds = array();
        $query = "select base_product_id from base_product where parent_id =".$parentId;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($query);
        $command->execute();
        $result = $command->queryAll();
        foreach ($result as $res){
            array_push($bpIds, $res['base_product_id']);
        }
        return $bpIds;

    }

    public function updateBaseProductInInventoryHeader($warehouse_id, $procurement_center_id, $base_product_id){
        
    }

}
