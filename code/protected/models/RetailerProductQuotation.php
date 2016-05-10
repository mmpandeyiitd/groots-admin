    <?php

/**
 * This is the model class for table "retailer_product_quotation".
 *
 * The followings are the available columns in table 'retailer_product_quotation':
 * @property integer $id
 * @property integer $retailer_id
 * @property integer $subscribed_product_id
 * @property integer $effective_price
 * @property integer $discout_per
 * @property integer $status
 */
class RetailerProductQuotation extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $base_product_id;
    public $title;

    public function tableName() {
        return 'retailer_product_quotation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('retailer_id, subscribed_product_id, status', 'required'),
            array('retailer_id, subscribed_product_id, effective_price, discount_per, status', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('base_product_id,title,', 'safe', 'on' => 'search'),
            array('id, retailer_id, subscribed_product_id, effective_price, discount_per, status,', 'safe', 'on' => 'search'),
        );
    }

    public function admin_retailer_id($id) {
        $connection = Yii::app()->db;
        $sql = "SELECT `subscribed_product_id`,effective_price,discount_per FROM `retailer_product_quotation` WHERE `retailer_id` ='" . $id . "'";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del = $command->queryAll();
        $style = $command->queryScalar();
        return $style;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Retailer' => array(self::BELONGS_TO, 'Retailer', 'retailer_id'),
                // 'BaseProduct' => array(self::MANY_MANY, 'BaseProduct', 'retailer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'retailer_id' => 'Retailer',
            'subscribed_product_id' => 'Subscribed Product',
            'effective_price' => 'Effective Price',
            'discount_per' => 'Discount Per',
            'status' => 'Status',
            'base_product_id' => 'base_product_id',
            'title' => 'title',
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
     
        //echo "ss";die;
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $retailer_id = $_GET['id'];
            $sub_ids_all = $this->getSubcribeid($retailer_id);
            //  print_r($sub_ids_all);die;
            if (count($sub_ids_all) > 0) {
                for ($i = 0; $i < count($sub_ids_all); $i++) {
                    $subpro_id_all[] = implode(',', $sub_ids_all[$i]);
                    //$subpro_id_new=  implode(',', $subpro_id_all[$i]);
                }
                if (count($sub_ids_all) > 0) {
                    //echo "hello222";die;
                    $subpro_id_new_all = implode(',', $subpro_id_all);
                }
            }

            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            if (count($sub_ids_all) > 0) {

                $criteria->join = "INNER JOIN base_product bp ON bp.base_product_id in ($subpro_id_new_all)";
                //$criteria->join = "left join retailer as r on r.id=t.retailer_id left join subscribed_product as sp on sp.subscribed_product_id=t.subscribed_product_id left join base_product as bp ON bp.base_product_id=sp.base_product_id";
            }

            //echo $subpro_id_new;die;



            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'retailer_id =' . $retailer_id;
        }
        $criteria->with = array('Retailer' => array("select" => "id"));
        //$criteria->with = array('BaseProduct' => array("select" => "id"));

        $criteria->compare('base_product_id', $this->base_product_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('retailer_id', $this->retailer_id, true);
        $criteria->compare('subscribed_product_id', $this->subscribed_product_id, true);
        $criteria->compare('effective_price', $this->effective_price);
        $criteria->compare('discount_per', $this->discout_per, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function updatedatalist($id, $rid) {
        $connection = Yii::app()->db;
        $sql = "SELECT `retailer_id`, `subscribed_product_id`,`effective_price`, `discount_per` FROM `retailer_product_quotation` WHERE retailer_id = $rid AND subscribed_product_id =$id ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $bsae_id = $command->queryAll();
    }

    public function updatesubproduct($id) {
        $connection = Yii::app()->db;
        $sql = "SELECT `store_price`, `store_offer_price` FROM `subscribed_product` WHERE subscribed_product_id =$id ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $bsae_id = $command->queryAll();
    }

    public function updatedata_retelar($ef, $dp, $rid, $sid) {
        $connection = Yii::app()->db;
        $sql = "update retailer_product_quotation set effective_price=$ef ,discount_per =$dp where retailer_id=$rid and subscribed_product_id=$sid";
        $command = $connection->createCommand($sql);
        $command->execute();
        $sql = "INSERT INTO special_price_solr_back_log(id,is_deleted)SELECT id,0
         FROM retailer_product_quotation WHERE retailer_id =$rid AND subscribed_product_id =$sid";
         $command = $connection->createCommand($sql);
         $command->execute();
    }
    public function solrbacklogRetailerProductQuotation($sid,$rid)
    {
        $connection = Yii::app()->db;
        $sql = "INSERT INTO special_price_solr_back_log(id,is_deleted)SELECT id,0
         FROM retailer_product_quotation WHERE retailer_id =$rid AND subscribed_product_id =$sid";
         $command = $connection->createCommand($sql);
         $command->execute();
    }

    public function check_retailer_id($s_id, $r_id) {


        $connection = Yii::app()->db;
        $sql = "SELECT `id` FROM `retailer_product_quotation` WHERE `retailer_id` = $r_id AND `subscribed_product_id` = $s_id";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del = $command->queryAll();
    }

    public function numeric($str) {
        // echo "hello";die;
        return (bool) preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
    }

    public function is_natural_no_zero($str) {
        if (!preg_match('/^[0-9]+$/', $str)) {
            return FALSE;
        }

        if ($str == 0) {
            return FALSE;
        }

        return TRUE;
    }

    public function getSubcribeid($r_id) {
        $connection = Yii::app()->db;
        $sql = "SELECT `subscribed_product_id` FROM `retailer_product_quotation` WHERE `retailer_id` ='" . $r_id . "'";
        $command = $connection->createCommand($sql);
        $command->execute();
        $sub_ids = $command->queryAll();
        if (count($sub_ids) > 0) {
            for ($i = 0; $i < count($sub_ids); $i++) {
                $subpro_id[] = implode(',', $sub_ids[$i]);
                // $subpro_id_new=  implode(',', $subpro_id[$i]);
            }
            if (count($sub_ids) > 0) {
                //echo "hello222";die;
                $subpro_id_new = implode(',', $subpro_id);
            }
        }
        if ($sub_ids != Array()) {
            $sql = "SELECT `base_product_id` FROM `subscribed_product` WHERE `subscribed_product_id` in (" . $subpro_id_new . ")";
            $command = $connection->createCommand($sql);
            $command->execute();
            return $sub_ids_data = $command->queryAll();
        }

        //echo $subpro_id_new;die;
    }

    public function updatelog($id, $rid) {
        //  echo "hello";die;
        $connection = Yii::app()->db;
        $sql = "INSERT INTO retailer_product_quotation_log (retailer_id,subscribed_product_id,effective_price,discount_per,status) (SELECT retailer_id,subscribed_product_id,effective_price,discount_per,status FROM retailer_product_quotation WHERE retailer_id =$rid AND subscribed_product_id=$id)";
        $command = $connection->createCommand($sql);
        $command->execute();
        // DELETE FROM `retailer_product_quotation` WHERE 
    }

    public function Delete_retelar($id, $rid) {
        //  echo "hello";die;
        $connection = Yii::app()->db;
        $sql = "DELETE FROM `retailer_product_quotation` WHERE retailer_id =$rid AND subscribed_product_id=$id";
        $command = $connection->createCommand($sql);
        $command->execute();
        // DELETE FROM `retailer_product_quotation` WHERE 
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RetailerProductQuotation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
