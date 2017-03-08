<?php

class StoreFront extends CActiveRecord {

    private $oldAttrs = array();
    public $password2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'store_front';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('store_front_name,end_date,start_date,store_id', 'required'),
            //  array('store_front_name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Invalid characters in Line sheet name.'),
            array('is_deleted,store_id,visibletoall', 'numerical', 'integerOnly' => true),
            array('store_front_name,season', 'length', 'max' => 250),
            array('store_front_name', 'unique', 'on' => 'insert', 'message' => 'store_front_name:(value) already exists!'),
            array('pdf_url,pdf_url', 'length', 'max' => 500),
            array('start_date,end_date', 'date', 'format' => 'dd/mm/yyyy'),
            array(
                'end_date',
                'compare',
                'compareAttribute' => 'start_date',
                'operator' => '>',
                'allowEmpty' => false,
                'message' => '{attribute} must be greater than "{compareValue}".'
            ),
            array(
                'start_date',
                'compare',
                'compareAttribute' => 'end_date',
                'operator' => '<',
                'allowEmpty' => false,
                'message' => '{attribute} must be less than "{compareValue}".'
            ),
            array('image', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true, 'maxSize' => IMAGE_SIZE),
            array('pdf', 'file', 'types' => 'pdf', 'allowEmpty' => true, 'maxSize' => LOOKBOOK_PDF_SIZE),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('store_front_id,status,store_id,visibletoall,store_front_name,season,start_date,end_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {

        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'store_front_name' => 'Linesheet Name',
            'store_front_api_key' => 'store_front_api_key',
            'store_front_api_password' => 'store_front_api_password',
            'season' => 'Season',
            'status' => 'status',
            'image' => 'image',
            'pdf' => 'pdf',
            'is_deleted' => 'is_deleted',
            'start_date' => 'Start date',
            'end_date' => 'End date',
            'store_front_id' => 'store front id',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $adminid = Yii::app()->session['brand_id'];
        $issuperadmin = Yii::app()->session['is_super_admin'];

        if ($issuperadmin == 1) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            //  $criteria->condition .= 'store_front_id != '."";
        } else {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'store_id =' . $adminid;
        }
        $criteria->compare('store_front_id', $this->store_front_id, true);
        $criteria->compare('season', $this->season, true);
        $criteria->compare('is_deleted', $this->is_deleted, true);
        $criteria->compare('pdf', $this->pdf, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('start_date', $this->start_date, true);
         $criteria->compare('end_date', $this->end_date, true);
         $criteria->compare('status', $this->status, true);

        $criteria->compare('store_front_name', $this->store_front_name, true);
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public function doActiveLinsheetByID($store_front_ids, $store_id) {
        $succ = false;

        if ((!empty($store_front_ids)) && (is_numeric($store_id))) {
            $sql = "update `store_front` set status=1 where store_front_id in($store_front_ids) and store_id=$store_id";
            //  echo $sql;die;
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $succ = $command->execute();
        }
        return $succ;
    }

    public function doInActiveLinsheetByID($store_front_ids, $store_id) {
        $succ = false;
        if (!empty($store_front_ids) && is_numeric($store_id)) {

            $sql = "update `store_front` set status=0 where store_front_id in($store_front_ids) and store_id=$store_id";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $succ = $command->execute();
        }
        return $succ;
    }

    public static function downloadCSVByIDs($store_front_ids, $store_id) {
        // $succ = false;
        if (!empty($store_front_ids) && is_numeric($store_id)) {

            $sqlchksubsid = "select store_front_id as ID,store_front_name as Name,season as Season,start_date as Start_Date,end_date as End_Date, CASE status   WHEN 1 THEN 'Enable'  ELSE 'Disable'END as Status from `store_front` where store_front_id in(" . $store_front_ids . ") and store_id=$store_id";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sqlchksubsid);
            $command->execute();
            $assocDataArray = $command->queryAll();
            $fileName = "Linesheet.csv";
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
                    fputcsv($fp, $values);
                }
                fclose($fp);
            }
            ob_flush();
        }
    }

    public function getLinsheetNameByID($store_front_id, $store_id) {
        $linesheet_name = '';
        if (is_numeric($store_front_id)) {
            $connection = Yii::app()->db;
            $sql = "SELECT store_front_name FROM `store_front` where store_front_id=$store_front_id and store_id=$store_id";
            $command = $connection->createCommand($sql);
            $command->execute();
            $linesheet_name = $command->queryScalar();
        }
        return $linesheet_name;
    }

    public function ChkStoreFront($StoreFrontinfo) {
        $connection = Yii::app()->db;
        $sqlchk = "select store_front_id from  store_front where store_front_name ='" . $StoreFrontinfo['store_front_name'] . "'";
        $command = $connection->createCommand($sqlchk);
        $command->execute();
        $rs = $command->queryAll();
        if (isset($rs[0]['store_front_id'])) {
            return false;
        } else {
            return true;
        }
    }

    public function UpdateStoreFront($apikey) {
        $connection = Yii::app()->db;
        $sqlmaxid = "SELECT MAX(`store_front_id`) as id  FROM `store_front`";
        $command = $connection->createCommand($sqlmaxid);
        $command->execute();
        $rs1 = $command->queryAll();

        $insert_id = $rs1[0]['id'];
        $apikey = $apikey . $insert_id;
        $password = md5($apikey);
        $sqlup = "update `store_front` set store_front_api_key='" . $apikey . "',store_front_api_password='" . $password . "' WHERE `store_front_id`='" . $insert_id . "' ";
        $command = $connection->createCommand($sqlup);
        $command->execute();
    }

    public function SaveStoreFront($StoreFrontinfo) {

        $apikey = substr($StoreFrontinfo['store_front_name'], 0, 2);
        $password = md5($StoreFrontinfo['store_front_api_password']);
        $connection = Yii::app()->db;
        $sqlchk = "select store_front_id from  store_front where store_front_name ='" . $StoreFrontinfo['store_front_name'] . "'";
        $command = $connection->createCommand($sqlchk);
        $command->execute();
        $rs = $command->queryAll();


        if (isset($rs[0]['store_front_id'])) {
            Yii::app()->user->setFlash('error', 'Store Front is already  created !.');
        } else {
            $connection = Yii::app()->db;
            $sql = "INSERT INTO `store_front`(`store_front_name`,`is_tagline`) VALUES ('" . $StoreFrontinfo['store_front_name'] . "','1','0')";
            $command = $connection->createCommand($sql);
            $command->execute();

            $sqlmaxid = "SELECT MAX(`store_front_id`) as id  FROM `store_front`";
            $command = $connection->createCommand($sqlmaxid);
            $command->execute();
            $rs1 = $command->queryAll();

            $insert_id = $rs1[0]['id'];
            $apikey = $apikey . $insert_id;

            $sqlup = "update `store_front` set store_front_api_key='" . $apikey . "' WHERE `store_front_id`='" . $insert_id . "' ";
            $command = $connection->createCommand($sqlup);
            $command->execute();
        }
    }

    public function storefrnt_retailer_mapping($store_front_id, $retailers) {

        $connection = Yii::app()->db;
        $sql = "delete from `linesheet_retailer_mapping` where store_front_id=" . $store_front_id;
        $command = $connection->createCommand($sql);
        $command->execute();

        $string = '';
        foreach ($retailers as $value) {
            $string .="('" . $store_front_id . "','" . $value . "'),";
        }
        $string = substr($string, 0, -1);

        $connection = Yii::app()->db;
        $sqlins = "INSERT INTO `linesheet_retailer_mapping`(`store_front_id`, `retailer_id`) VALUES " . $string;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sqlins);
        $command->execute();

        $newAttrs = json_encode($string);
        $oldAttrs = json_encode($this->getOldAttributes());
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store front', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertStoreFrontLog($data);
    }

    public function storefrnt_products_mapping($store_front_id, $products) {

        $val = false;

        if (count($products) > 0) {
            $string = '';
            foreach ($products as $value) {
                $string .="('" . $store_front_id . "','" . $value . "'),";
            }
            $string = substr($string, 0, -1);

            $connection = Yii::app()->db;
            $sqlins = "INSERT INTO `linesheet_products_mapping`(`store_front_id`, `base_product_id`) VALUES " . $string;
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sqlins);
            $command->execute();

            $newAttrs = json_encode($string);
            $oldAttrs = json_encode($this->getOldAttributes());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store front', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertStoreFrontLog($data);
            $val = true;
        }
        return $val;
    }

    public function getMappedRetailersbystorefront($storefront_id) {
        $retailers = array();
        $connection = Yii::app()->db;
        $sql = "SELECT retailer_id  FROM `linesheet_retailer_mapping`  where store_front_id=" . $storefront_id . "";
        $command = $connection->createCommand($sql);
        $command->execute();
        $base_product_ids = $command->queryAll();
        $baseproducts = array();
        foreach ($base_product_ids as $val) {
            $retailers[] = $val['retailer_id'];
        }

        $retailers_str = '';
        if (count($retailers) > 0) {
            $retailers_str = implode(',', $retailers);



            $connection = Yii::app()->db;
            $sql = "SELECT id,name  FROM `retailer`  where id in($retailers_str) order by name ASC";
            $command = $connection->createCommand($sql);
            $command->execute();
            $retailers_arr = $command->queryAll();
            foreach ($retailers_arr as $val) {
                $baseproducts[$val['id']] = $val['name'];
            }
        }
        return $baseproducts;
    }

    public function getMappedbaseproductbystorefront($storefront_id) {
        $connection = Yii::app()->db;
        $sql = "SELECT base_product_id  FROM `linesheet_products_mapping`  where store_front_id=" . $storefront_id . "";
        $command = $connection->createCommand($sql);
        $command->execute();
        $base_product_ids = $command->queryAll();
        $baseproducts = array();
        foreach ($base_product_ids as $val) {
            $max = count($baseproducts);
            $baseproducts[$max] = $val['base_product_id'];
        }

        return $baseproducts;
    }

    public function Deletebaseproductfromstorefront($storefront_id, $baseproduct_id) {
        $return_value = false;
        if (is_numeric($storefront_id) && !empty($baseproduct_id)) {
            $connection = Yii::app()->db;
            $sql = "delete FROM `linesheet_products_mapping`  where store_front_id=" . $storefront_id . " and base_product_id in(" . $baseproduct_id . ") ";
            $command = $connection->createCommand($sql);
            $command->execute();

            $newAttrs = '';
            $oldAttrs = $baseproduct_id;
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store front', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertStoreFrontLog($data);
            $return_value = true;
        }
        return $return_value;
    }

    public function beforeSave() {
        //$pass = md5($this->password);
        // $this->password = $pass;
        return true;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Store the static model class
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
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store front', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertStoreFrontLog($data);
        }
        if ($this->isNewRecord) {
            $newAttrs = json_encode($this->getAttributes());
            $oldAttrs = json_encode(array());
            $log = new Log();
            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store front', 'action' => 'create', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
            $log->insertStoreFrontLog($data);
        }
    }

    protected function beforeDelete() {
        //return parent::beforeDelete();
        $newAttrs = json_encode(array());
        $oldAttrs = json_encode($this->getOldAttributes());
        $log = new Log();
        $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'store front', 'action' => 'delete', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);
        $log->insertStoreFrontLog($data);
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

    public function Update_image($image_url, $image_name, $insert_id) {
        $connection = Yii::app()->db;
        $sqlup = "update `store_front` set image='" . $image_name . "' ,image_url='" . $image_url . "'  WHERE `store_front_id`='" . $insert_id . "' ";
        $command = $connection->createCommand($sqlup);
        $command->execute();
    }

    public function Update_pdf($image_url, $pdf_name, $insert_id) {
        $connection = Yii::app()->db;
        $sqlup = "update `store_front` set pdf='" . $pdf_name . "' ,pdf_url='" . $image_url . "'  WHERE `store_front_id`='" . $insert_id . "' ";
        $command = $connection->createCommand($sqlup);
        $command->execute();
    }

    /**
     * 
     * Remove & delete a media from table & directory
     * @param int $media_id
     */
    public function deleteSTOREFRONT($id = null) {
        if (!empty($id) AND is_numeric($id)) {
            $datat = $this->findByPk($id);
            $this->deleteByPk($id);
            return true;
        }
        return false;
    }

}
