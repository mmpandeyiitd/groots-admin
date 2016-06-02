<?php

/**
 * This is the model class for table "subscribed_product".
 *
 * The followings are the available columns in table 'subscribed_product':
 * @property string $subscribed_product_id
 * @property string $base_product_id
 * @property string $store_id
 * @property string $store_price
 * @property string $store_offer_price
 * @property string $weight
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $warranty
 * @property integer $prompt
 * @property string $prompt_key
 * @property integer $status
 * @property string $checkout_url
 * @property string $created_date
 * @property string $modified_date
 * @property integer $is_deleted
 * @property string $sku
 * @property integer $quantity
 * @property integer $is_cod
 * @property integer $subscribe_shipping_charge
 *
 * The followings are the available model relations:
 * @property StoreFront[] $storeFronts
 * @property BaseProduct $baseProduct
 * @property Store $store
 */
class SubscribedProduct extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $action;
    public $title;
    public $effective_price;
    public $discout_per;

    public function tableName() {
        return 'subscribed_product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('base_product_id, store_id,subscribed_product_id', 'required'),
            array('diameter, status, is_deleted, quantity, subscribe_shipping_charge', 'numerical', 'integerOnly' => true),
            array('base_product_id, store_id, weight, length', 'length', 'max' => 10),
            array('store_price, store_offer_price', 'length', 'max' => 12),
            array('grade', 'length', 'max' => 100),
            //  array('checkout_url', 'length', 'max' => 2083),
            array('sku', 'length', 'max' => 128),
            array('created_date, modified_date', 'safe'),
            array('title,effective_price,discout_per', 'safe', 'on' => 'search'),
            //array('', 'safe', 'on'=>'search'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('subscribed_product_id, base_product_id, store_id, store_price, store_offer_price, weight, length,grade, status, created_date, modified_date, is_deleted, sku, diameter,quantity, is_cod, subscribe_shipping_charge', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            // 'RetailerProductQuotation' => array(self::MANY_MANY, 'RetailerProductQuotation', ' retailer_product_quotation(subscribed_product_id,effective_price)'),
            // 'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'BaseProduct' => array(self::BELONGS_TO, 'BaseProduct', 'base_product_id'),
                //'RetailerProductQuotation' => array(self::BELONGS_TO, 'RetailerProductQuotation', 'subscribed_product_id','joinType'=>'FULL JOIN'),
                // 'RetailerProductQuotation' => array(self::BELONGS_TO, 'RetailerProductQuotation', 'subscribed_product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'subscribed_product_id' => 'Subscribed Product',
            'base_product_id' => 'Base Product',
            'store_id' => 'Store',
            'store_price' => 'Store Price',
            'store_offer_price' => 'Store Offer Price',
            'weight' => 'Weight',
            'length' => 'Length',
            'diameter' => 'diameter',
            'grade' => 'grade',
            'status' => 'Status',
//            'checkout_url' => 'Checkout Url',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
//            'is_deleted' => 'Is Deleted',
            'sku' => 'Sku',
            'quantity' => 'Quantity',
//            'is_cod' => 'Is Cod',
            'subscribe_shipping_charge' => 'Subscribe Shipping Charge',
            'title' => 'Title',
            'effective_price' => 'effective_price',
            'discout_per' => 'discout_per',
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
        // echo "hello";die;
        //$model->mapp_product(); getSubcribeid_all
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $retailer_id = $_GET['id'];
            $sub_ids = $this->getSubcribeid($retailer_id);
            $sub_ids_all = $this->getSubcribeid_all();

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
            if (count($sub_ids) > 0) {
                $criteria->condition .= 'subscribed_product_id not in (' . $subpro_id_new . ')';
            } else {
                $criteria->condition .= 'subscribed_product_id in (' . $subpro_id_new_all . ')';
            }
        }

        // $criteria->order = 'subscribed_product_id DESC';
        $criteria->join = "left join base_product bp on bp.base_product_id=t.base_product_id";
        $criteria->order = "subscribed_product_id DESC";
        // $criteria->join = "left join retailer_product_quotation rp on rp.subscribed_product_id=t.subscribed_product_id";
        //$criteria->compare('effective_price', $this->effective_price, true);
        //$criteria->with = array('BaseProduct' => array("select" => "title"));
        $criteria->compare('bp.title', $this->title, true);
        // $criteria->compare('discout_per', $this->discout_per, true);
        $criteria->compare('subscribed_product_id', $this->subscribed_product_id, true);
        $criteria->compare('base_product_id', $this->base_product_id, true);
        $criteria->compare('store_id', $this->store_id, true);
        $criteria->compare('store_price', $this->store_price, true);
        $criteria->compare('store_offer_price', $this->store_offer_price, true);
        $criteria->compare('weight', $this->weight, true);
        $criteria->compare('length', $this->length, true);
//        $criteria->compare('width', $this->width, true);
//        $criteria->compare('height', $this->height, true);
        // $criteria->compare('title', $this->title, true);
        //$criteria->compare('warranty', $this->warranty, true);
//        $criteria->compare('prompt', $this->prompt);
//        $criteria->compare('prompt_key', $this->prompt_key, true);
        $criteria->compare('t.status', $this->status);
        //  $criteria->compare('checkout_url', $this->checkout_url, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        // $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('sku', $this->sku, true);
        $criteria->compare('quantity', $this->quantity);
        // $criteria->compare('is_cod', $this->is_cod);
        $criteria->compare('subscribe_shipping_charge', $this->subscribe_shipping_charge);



        // $criteria->with=array('RetailerProductQuotation'=>array("select"=>"discout_per"));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SubscribedProduct the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getinfobyid($id) {
        $connection = Yii::app()->db;
        $sql = " SELECT sp.sku,sp.`subscribe_shipping_charge`,s.seller_name,s.store_id,s.mobile_numbers,group_concat(`category_name` separator '>') as cate_info FROM `subscribed_product` as sp join base_product as bp on bp.base_product_id=sp.`base_product_id` join store as s on s.`store_id`=sp.`store_id` join product_category_mapping as pcm on pcm.`base_product_id`=sp.`base_product_id` join category as c on c.category_id=pcm.category_id WHERE sp.`subscribed_product_id`='" . $id . "'";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del = $command->queryAll();
    }

    public function getcategoryid($id) {
        $connection = Yii::app()->db;
        $sql = "SELECT c.category_id,c.category_name FROM `subscribed_product` as sp join base_product as bp on bp.base_product_id=sp.`base_product_id` join product_category_mapping as pcm on pcm.`base_product_id`=sp.`base_product_id` join category as c on c.category_id=pcm.category_id WHERE sp.`subscribed_product_id`='" . $id . "'";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del1 = $command->queryAll();
    }

    public function getSubcribeid($id) {
        $connection = Yii::app()->db;
        $sql = "SELECT subscribed_product_id FROM `retailer_product_quotation` where retailer_id=$id";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del1 = $command->queryAll();
    }

    public function getSubcribeid_all() {
        $connection = Yii::app()->db;
        $sql = "SELECT subscribed_product_id FROM subscribed_product";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del1 = $command->queryAll();
    }

    public function getdatarecords($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT `grade` FROM `subscribed_product` where base_product_id='" . $_REQUEST['id'] . "' and store_id='" . $_REQUEST['store_id'] . "' ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del2 = $command->queryAll();
    }

    public function getdatarecords_data($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT `weight` FROM `subscribed_product` where base_product_id='" . $_REQUEST['id'] . "' and store_id='" . $_REQUEST['store_id'] . "' ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del2 = $command->queryAll();
    }

    public function getdatarecords_data1($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT `weight`,weight_unit,length,length_unit FROM `subscribed_product` where base_product_id='" . $_REQUEST['id'] . "' and store_id='" . $_REQUEST['store_id'] . "' ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del2 = $command->queryAll();
    }

    public function getdatarecords_data2($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT `weight`,weight_unit,length,length_unit FROM `subscribed_product` where base_product_id='" . $_REQUEST['id'] . "' and store_id='" . $_REQUEST['store_id'] . "' ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del2 = $command->queryAll();
    }

    public function getdatarecords_data3($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT `weight`,weight_unit,length,length_unit FROM `subscribed_product` where base_product_id='" . $_REQUEST['id'] . "' and store_id='" . $_REQUEST['store_id'] . "' ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del2 = $command->queryAll();
    }

    public function getdatarecords_new($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT `diameter` FROM `subscribed_product` where base_product_id='" . $_REQUEST['id'] . "' and store_id='" . $_REQUEST['store_id'] . "' ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del3 = $command->queryAll();
    }

    public function getdatarecords_new1($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT `quantity` FROM `subscribed_product` where base_product_id='" . $_REQUEST['id'] . "' and store_id='" . $_REQUEST['store_id'] . "' ";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del3 = $command->queryAll();
    }

    public function data_sub($bp, $sid, $mrp, $new_data, $a, $qunt, $wsp, $Weight, $WeightUnit, $Length, $LengthUnit) {
        // echo "hello";die;

        $connection = Yii::app()->db;
        $sql = "insert into subscribed_product set store_offer_price='" . $wsp . "',store_price='" . $mrp . "', base_product_id='" . $bp . "' ,grade ='" . $a . " ',diameter ='" . $new_data . "',quantity ='" . $qunt . "', store_id='" . $sid . "' ,weight ='" . $Weight . " ',weight_unit =' " . $WeightUnit . " ',length ='" . $Length . " ',length_unit ='" . $LengthUnit . "  '";
        $command = $connection->createCommand($sql);
        $command->execute();
        $sql = "INSERT INTO solr_back_log(subscribed_product_id,is_deleted)SELECT subscribed_product_id, is_deleted
         FROM subscribed_product WHERE base_product_id =$bp";
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function data_sub_csv($bp, $sid, $mrp, $sprice, $grade, $diameter, $quantity, $weight, $weight_unit, $length, $length_unit) {
        //echo $diameter;die;
        $connection = Yii::app()->db;
        $sql = "insert into subscribed_product set store_offer_price='" . $sprice . " ' ,store_price= " . $mrp . ", base_product_id= " . $bp . ",grade ='" . $grade . " ',diameter =' " . $diameter . " ',quantity =$quantity, store_id=$sid,weight='" . $weight . " ',weight_unit='" . $weight_unit . " ',length='" . $length . " ',length_unit='" . $length_unit . " '";
        $command = $connection->createCommand($sql);
        $command->execute();
        $sql = "INSERT INTO solr_back_log(subscribed_product_id,is_deleted)SELECT subscribed_product_id, is_deleted
         FROM subscribed_product WHERE base_product_id =$bp";
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function update_mrp_wsp($mrp, $wsp, $diameter, $grade, $store_id, $base_product_id, $quantity, $Weight, $WeightUnit, $Length, $LengthUnit, $status) {
        $connection = Yii::app()->db;
        $sql = "update subscribed_product set store_offer_price='" . $wsp . "',grade ='" . $grade . "',diameter ='" . $diameter . "',quantity ='" . $quantity . "',store_price='" . $mrp . "', weight='" . $Weight . "',weight_unit='" . $WeightUnit . " ',length='" . $Length . " ',status='" . $status . " ',length_unit='" . $LengthUnit . " ' where base_product_id='" . $base_product_id . "' and store_id='" . $store_id . "' ";
        $command = $connection->createCommand($sql);

        $command->execute();

        /* if (!$command->execute()) {
          $connection = Yii::app()->db;
          echo$sql = "insert into  subscribed_product set store_offer_price='" . $wsp . "',store_price='" . $mrp . "', base_product_id='" . $base_product_id . "' ,grade ='" . $grade . "',diameter ='" . $diameter . "', store_id='" . $store_id . "' ";
          die;$command = $connection->createCommand($sql);
          $command->execute();
          } */
        //return $category_id_del= $command->queryAll();
    }

    public function solrbacklogRetailerProductQuotation($sid, $rid) {
        $connection = Yii::app()->db;
        $sql = "INSERT INTO special_price_solr_back_log(id,is_deleted)SELECT id,0
         FROM retailer_product_quotation WHERE retailer_id =$rid AND subscribed_product_id =$sid";
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function solrbacklogRetailerProductQuotationdel($rid) {
        $connection = Yii::app()->db;
        $sql = "INSERT INTO special_price_solr_back_log(id,is_deleted)SELECT id,0
         FROM retailer_product_quotation WHERE retailer_id =$rid";
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function removeselectdata($id) {
        $connection = Yii::app()->db;
        $sql = "DELETE FROM `retailer_product_quotation` WHERE `retailer_id` =$id";
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function productnamelist($val) {
        // echo $val;die;
        $connection = Yii::app()->db;
        $sql = "SELECT bp.title FROM `subscribed_product` as sp left join base_product as bp on bp. `base_product_id`=sp.`base_product_id`
WHERE `subscribed_product_id`=$val";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $category_id_del3 = $command->queryAll();
    }

    public function savedatagridview($id, $pro, $ef, $pf, $status) {
        $ef = trim($ef);
        $pf = trim($pf);

        if (empty($ef))
            $ef = 0;
        if (empty($pf))
            $pf = 0;
        $connection = Yii::app()->db;
        $sql = "SELECT `retailer_id` FROM `retailerproductquotation_gridview` where subscribed_product_id='" . $pro . "' and retailer_id='" . $id . "' ";
        $command = $connection->createCommand($sql);
        $command->execute();
        $category_id_del3 = $command->queryAll();
        if ($status == '0') {
            $connection = Yii::app()->db;
            $sql = "INSERT INTO special_price_solr_back_log(id,is_deleted)SELECT id,0
         FROM retailer_product_quotation WHERE retailer_id =$id AND subscribed_product_id =$pro";
            $command = $connection->createCommand($sql);
            $command->execute();
            $connection = Yii::app()->db;
            $sql = "INSERT INTO retailer_product_quotation_log(action,effective_price,discount_per,subscribed_product_id,retailer_id,status) VALUES('DELETE','$ef', '$pf', '$pro', '$id','$status')";
            $command = $connection->createCommand($sql);
            $command->execute();
            $connection = Yii::app()->db;
            $sql = "DELETE FROM `retailer_product_quotation` where subscribed_product_id='" . $pro . "' and retailer_id='" . $id . "'";
            $command = $connection->createCommand($sql);
            $command->execute();
        } else if ($category_id_del3 != Array()) {
            $connection = Yii::app()->db;
            $sql = "update retailer_product_quotation set effective_price='" . $ef . "',discount_per ='" . $pf . "' where subscribed_product_id='" . $pro . "' and retailer_id='" . $id . "'";
            $command = $connection->createCommand($sql);
            $command->execute();
            $connection = Yii::app()->db;
            $sql = "INSERT INTO retailer_product_quotation_log(action,effective_price,discount_per,subscribed_product_id,retailer_id,status) VALUES('UPDATE','$ef', '$pf', '$pro', '$id','$status')";
            $command = $connection->createCommand($sql);
            $command->execute();
        } else {
            $connection = Yii::app()->db;
            $sql = "INSERT INTO retailer_product_quotation(effective_price,discount_per,subscribed_product_id,retailer_id,status) VALUES('$ef', $pf, '$pro', '$id','$status')";
            $command = $connection->createCommand($sql);
            $command->execute();
            $connection = Yii::app()->db;
            $sql = "INSERT INTO retailer_product_quotation_log(action,effective_price,discount_per,subscribed_product_id,retailer_id,status) VALUES('INSERT','$ef', '$pf', '$pro', '$id','$status')";
            $command = $connection->createCommand($sql);
            $command->execute();
            //return $category_id_del= $command->queryAll();
        }
    }

    public function allcheckproductlcsv() {
        $connection = Yii::app()->db;
        $sql = "SELECT `base_product_id` FROM `subscribed_product`";
        $command = $connection->createCommand($sql);
        $command->execute();
        return $bsae_id = $command->queryAll();
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

}
