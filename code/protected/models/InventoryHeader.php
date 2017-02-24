<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 15/9/16
 * Time: 3:54 PM
 */

class InventoryHeader extends CActiveRecord
{

    /*public $start_date="";
    public $end_date="";*/
    public $item_title="";
    public $grade="";
    public $date="";
    public $vendor_id;
    public $prev_day_inv=0;
    public $present_inv=0;
    public $liquid_inv=0;
    public $secondary_sale=0;
    public $extra_inv_absolute=0;
    public $wastage = 0;
    public $liquidation_wastage = 0;
    public $balance = 0;
    public $schedule_inv_absolute=0;
    public $parent_id;
    public $purchase_id;
    public $tobe_procured_qty;
    public $transfer_id;
    public $order_qty;
    public $delivered_qty;
    public $received_qty;
    public $update_type="";
    public $price;
    public $unit_price;
    public $urd_number;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'groots_orders.inventory_header';
    }


    public function getDbConnection() {
        return Yii::app()->secondaryDb;
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id,warehouse_id,base_product_id,schedule_inv,schedule_inv_type,extra_inv,extra_inv_type,created_at,item_title,date,parent_id, status', 'safe', 'on' => 'search,update'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'Warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
            'BaseProduct' => array(self::BELONGS_TO,  'BaseProduct', 'base_product_id'),
            //'Inventory' => array(self::HAS_ONE,  'Inventory', 'inv_id'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(

        );
    }

    /*
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
    /*public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }*/



    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if(empty($this->date)){
            $this->date = date('Y-m-d');
        }
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, bp.title as item_title, bp.parent_id as parent_id, bp.grade, inv.present_inv, inv.wastage, inv.liquidation_wastage, inv.extra_inv as extra_inv_absolute, inv.liquid_inv, inv.secondary_sale';
        /*$criteria->with = array(
            'BaseProduct' => array('alias'=> 't1', 'together' => true, ),
            );*/
        $criteria->join = "left join groots_orders.inventory inv on (inv.base_product_id = t.base_product_id and inv.warehouse_id=t.warehouse_id  and inv.date ='".$this->date."') ";
        $criteria->join .= " join cb_dev_groots.base_product bp on bp.base_product_id = t.base_product_id  ";
        $criteria->join .= " join cb_dev_groots.product_category_mapping pcm on bp.base_product_id = pcm.base_product_id  ";
        //$criteria->together = true;
        $criteria->compare( 'bp.title', $this->item_title, true );
        $criteria->compare( 't.warehouse_id', $this->warehouse_id, true );
        $criteria->condition .= ' and (bp.grade is null or bp.grade = "Parent" or bp.grade = "Unsorted")';
        //$criteria->compare('i.date', $this->date, true);
        $criteria->order = 'pcm.category_id asc, bp.base_title asc, bp.priority asc';
        $pageParams = $_GET;
        $pageParams['date'] = $this->date;
        $pageParams['w_id'] = $this->warehouse_id;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'attributes'=>array(
                    'item_title'=>array(
                        'asc'=>'bp.title',
                        'desc'=>'bp.title DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 80,
                //'params' => array('date'=>$this->date, 'w_id'=>$this->warehouse_id),
                'params' => $pageParams,
            ),
        ));
    }

    //transfer search
    public function transferSearch() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if(empty($this->date)){
            $this->date = date('Y-m-d');
        }
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, bp.title as item_title, bp.parent_id as parent_id, bp.grade, tl.order_qty, tl.delivered_qty, tl.received_qty';
        /*$criteria->with = array(
            'BaseProduct' => array('alias'=> 't1', 'together' => true, ),
            );*/
        //$criteria->join = "left join groots_orders.inventory inv on (inv.base_product_id = t.base_product_id and inv.warehouse_id=t.warehouse_id  and inv.date ='".$this->date."') ";
        $joinType = "";
        if($this->update_type=="add"){
            $joinType = " left ";
        }
        $criteria->join = $joinType." join groots_orders.transfer_line tl on tl.base_product_id=t.base_product_id and tl.transfer_id=".$this->transfer_id;
        $criteria->join .= " join cb_dev_groots.base_product bp on bp.base_product_id = t.base_product_id  ";
        $criteria->join .= " join cb_dev_groots.product_category_mapping pcm on bp.base_product_id = pcm.base_product_id  ";
        //$criteria->together = true;
        $criteria->compare( 'bp.title', $this->item_title, true );
        $criteria->compare( 't.warehouse_id', $this->warehouse_id, true );

        //$criteria->compare('i.date', $this->date, true);
        $criteria->order = 'pcm.category_id asc, bp.base_title asc, bp.priority asc';
        $pageParams = $_GET;
        $pageParams['date'] = $this->date;
        $pageParams['w_id'] = $this->warehouse_id;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'attributes'=>array(
                    'item_title'=>array(
                        'asc'=>'bp.title',
                        'desc'=>'bp.title DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 80,
                //'params' => array('date'=>$this->date, 'w_id'=>$this->warehouse_id),
                'params' => $pageParams,
            ),
        ));
    }

    //purchase search
    public function purchaseSearch() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if(empty($this->date)){
            $this->date = date('Y-m-d');
        }
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, bp.title as item_title, bp.parent_id as parent_id, bp.grade, pl.order_qty, pl.tobe_procured_qty, pl.received_qty, pl.vendor_id,pl.price, pl.unit_price,pl.urd_number';
        /*$criteria->with = array(
            'BaseProduct' => array('alias'=> 't1', 'together' => true, ),
            );*/
        //$criteria->join = "left join groots_orders.inventory inv on (inv.base_product_id = t.base_product_id and inv.warehouse_id=t.warehouse_id  and inv.date ='".$this->date."') ";
        $joinType = "";
        if($this->update_type=="add"){
            $joinType = " left ";
        }
        $criteria->join = $joinType." join groots_orders.purchase_line pl on pl.base_product_id=t.base_product_id and pl.purchase_id=".$this->purchase_id;
        $criteria->join .= " join cb_dev_groots.base_product bp on bp.base_product_id = t.base_product_id  ";
        $criteria->join .= " join cb_dev_groots.product_category_mapping pcm on bp.base_product_id = pcm.base_product_id  ";
        //$criteria->together = true;
        $criteria->condition = 'bp.grade is null or bp.grade = "Parent" or bp.grade = "Unsorted"';
        $criteria->compare( 'bp.title', $this->item_title, true );
        $criteria->compare( 't.warehouse_id', $this->warehouse_id, true );

        //$criteria->compare('i.date', $this->date, true);
        $criteria->order = 'pcm.category_id asc, bp.base_title asc, bp.priority asc';
        $pageParams = $_GET;
        $pageParams['date'] = $this->date;
        $pageParams['w_id'] = $this->warehouse_id;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'attributes'=>array(
                    'item_title'=>array(
                        'asc'=>'bp.title',
                        'desc'=>'bp.title DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 80,
                //'params' => array('date'=>$this->date, 'w_id'=>$this->warehouse_id),
                'params' => $pageParams,
            ),
        ));
    }



    /*public function searchNew() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
        $criteria = new CDbCriteria;
        //$criteria->condition = 'order_id > 35';
        $criteria->select = " t.*, bp.title";
        $criteria->join .= ' join cb_dev_groots.base_product bp on bp.base_product_id = t.base_product_id ';
        //$criteria->order = 'created_date DESC';
        $criteria->compare('bp.title', $this->item_title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'created_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),

        ));
    }*/


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Retailer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    /*public function getStartDate(){
        return $this->start_date;
    }

    public function getEndDate(){
        return $this->end_date;
    }*/

    public function getItemTitle(){
        return $this->item_title;
    }

    public function getDate(){
        return $this->date;
    }

    public function getPrevDayInv(){
        return $this->prev_day_inv;
    }

    public function getPresentInv(){
        return $this->present_inv;
    }

    public function getLiquidInv(){
        return $this->liquid_inv;
    }

    public function getExtraInvAbsolute(){
        return $this->extra_inv_absolute;
    }

    public function getWastage(){
        return $this->wastage;
    }

    public function getLiquidationWastage(){
        return $this->liquidation_wastage;
    }

    public function getSecondarySale(){
        return $this->secondary_sale;
    }

    public function getBalance(){
        return $this->balance;
    }

    public function getScheduleInvAbsolute(){
        return $this->schedule_inv_absolute;
    }

    public function getParentId(){
        return $this->parent_id;
    }

    public function getTobeProcuredQty(){
        return $this->tobe_procured_qty;
    }

    public function getOrderQty(){
        return $this->order_qty;
    }

    public function getDeliveredQty(){
        return $this->delivered_qty;
    }

    public function getReceivedQty(){
        return $this->received_qty;
    }

    public function getVendorId(){
        return $this->vendor_id;
    }

    public function getTransferId(){
        return $this->transfer_id;
    }

    public function getPurchaseId(){
        return $this->purchase_id;
    }

    public function getGrade(){
        return $this->grade;
    }

    public function getUpdateType(){
        return $this->update_type;
    }

    public function getCssClass(){
        $class = '';
        if($this->parent_id > 0){
            if($this->grade=='Unsorted'){
                $class .= " unsorted ";
            }
            $class .= "child parent-id_".$this->parent_id." item_".$this->parent_id;
        }
        elseif(isset($this->parent_id) && $this->parent_id == 0){
            $class .= "parent parent-id_".$this->parent_id." item_".$this->base_product_id;
        }
        elseif($this->parent_id == null){
            $class .= "fruit_".$this->base_product_id;
        }
        return $class;
    }

    public static function extraInvType(){
        $connection = Yii::app()->secondaryDb;
        $extraInvTypes = Utility::get_enum_values($connection, self::tableName(), 'extra_inv_type' );
        return $extraInvTypes;
    }
    public static function scheduleInvType(){
        $connection = Yii::app()->secondaryDb;
        $scheduleInvTypes = Utility::get_enum_values($connection, self::tableName(), 'schedule_inv_type' );
        return $scheduleInvTypes;
    }

    public function searchBaseProductUpdate($bp_id){
        $criteria = new CDbCriteria();
        $criteria->condition = 'base_product_id = '.$bp_id;
        $criteria->limit = '1';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getRowCssProductId(){
        $id = $this->base_product_id;
        $id.= $this->warehouse_id;
        return $id;
    }


    public function searchBaseProductCreate(){
        $dataprovider = array();
        $dataprovider[0]['id'] = 0;
        return new CArrayDataProvider($dataprovider);
    }

    public function updateBaseProductInInventoryHeader($warehouse_id, $procurement_center_id, $base_product_id){

        foreach ($warehouse_id as $key => $value) {
            $model = InventoryHeader::model()->findByAttributes(array('base_product_id' => $base_product_id, 'warehouse_id' => $value));
            if(isset($model) && !empty($model)){
                //var_dump($model);die;
                $model->procurement_center_id = $procurement_center_id[$key];
            }
            else{
                $model = new InventoryHeader;
                $model->warehouse_id = $value;
                $model->base_product_id = $base_product_id;
                $model->schedule_inv = 0;
                $model->extra_inv = 0;
                $model->created_at = date('Y-m-d H:i:s');
                $model->procurement_center_id = $procurement_center_id[$key];
                $model->updated_by = Yii::app()->user->id;
            }
            $model->save();
        }
    }

    public function productWarehouseMappingUpload($uploadedFile, $logFile, $indexMap){
        /*$warehouses = Warehouse::model()->findAllByAttributes(array(), array('condition' => " id != ".HD_OFFICE_WH_ID));
        $warehouseMap = array();
        foreach ($warehouses as $key => $value) {
            $warehouseMap[$value['id']] = array();
            $warehouseMap[$value['id']] = $value;
        }*/
        $first = true;
        while(!feof($uploadedFile)){
            $row = fgetcsv($uploadedFile);
            if(!$first){
                foreach ($indexMap as $key => $value) {
                    //if($row[$value['first']] == 1){
                    self::createWarehouseProductMapping($key, $row, $logFile, $indexMap);
                    /*}
                    else{
                        self::changeMappingStatusIfPresent($key, $row,$logFile, $indexMap);
                    }*/
                }
            }
            $first = false;
        }
    }


    public function createWarehouseProductMapping($w_id, $row, $logFile, $indexMap){
        $warehouse_id = $w_id;
        $isMapping = trim($row[$indexMap[$w_id]['first']]);
        $procurement_center_id = trim($row[$indexMap[$w_id]['second']]);
        $base_product_id = trim($row[0]);
        $flag = self::validateInputsFromCsv($warehouse_id, $isMapping, $procurement_center_id, $base_product_id);
        if($flag['status'] == 1){

            try{
                $model = InventoryHeader::model()->findByAttributes(array('base_product_id' => $base_product_id, 'warehouse_id' => $warehouse_id));

                if(isset($model) && !empty($model)){
                    $model->procurement_center_id = $procurement_center_id;
                    $model->status = $isMapping;
                    $action = 'Update';
                    $model->save();
                    $temp = array($model->id,$base_product_id,$action,'Success', '0');
                    fputcsv($logFile, $temp);
                }
                else if ($isMapping == 1){
                    $model = new InventoryHeader;
                    $model->warehouse_id = $warehouse_id;
                    $model->base_product_id = $base_product_id;
                    $model->schedule_inv = 0;
                    $model->extra_inv = 0;
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->procurement_center_id = $procurement_center_id;
                    $model->status = 1;
                    $model->updated_by = Yii::app()->user->id;
                    $action = 'Insert';
                    $model->save();
                    $temp = array($model->id,$base_product_id,$action,'Success', '0');
                    fputcsv($logFile, $temp);
                }


            }catch(Exception $e){
                $temp = array('0',$base_product_id,$action,'Failure',$e->getMessage());
                fputcsv($logFile, $temp);
            }
        }
        else{
            $temp = array('0',$base_product_id,'Nothing', 'Failed',$flag['msg']);
            fputcsv($logFile, $temp);
        }
    }



    public function validateInputsFromCsv($w_id, $is_mapp, $proc_id, $bp_id){
        $res = array();
        $res['status'] = 1;
        $res['msg'] = '';
        if($w_id == ''){
            $res['status'] = 0;
            $res['msg'] = 'Warehouse Id Empty';
        }
        if(!is_numeric($w_id)){
            $res['status'] = 0;
            $res['msg'] = 'Warehouse Id Not Numeric';
        }
        if($is_mapp == ''){
            $res['status'] = 0;
            $res['msg'] = 'mapping not provided';
        }
        if(!is_numeric($is_mapp)){
            $res['status'] = 0;
            $res['msg'] = 'mapping Not Numeric';
        }
        if($proc_id == ''){
            $res['status'] = 0;
            $res['msg'] = 'Procurement Center Id Empty';
        }
        if(!is_numeric($proc_id)){
            $res['status'] = 0;
            $res['msg'] = 'Procurement Center Id Not Numeric';
        }
        if($bp_id == ''){
            $res['status'] = 0;
            $res['msg'] = 'Product Id Id Empty';
        }
        if(!is_numeric($bp_id)){
            $res['status'] = 0;
            $res['msg'] = 'Product Id Not Numeric';
        }
        return $res;
    }

    public function changeMappingStatusIfPresent($w_id, $row, $logFile, $indexMap){
        $bp_id = trim($row[0]);
        $model = InventoryHeader::model()->findByAttributes(array('base_product_id' => $bp_id, 'warehouse_id' => $w_id));
        if(isset($model) && !empty($model)){
            $model->status = 0;
            try{
                $model->save();
                $temp = array($model->id, $bp_id, 'Update', 'Success', 0);
                fputcsv($logFile, $temp);
            } catch(Exception $e){
                $temp = array($model->id, $bp_id, 'Update', 'Failed', $e->getMessage());
                fputcsv($logFile, $temp);
            }
        }
    }
}