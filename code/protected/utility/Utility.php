<?php

/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 23/8/16
 * Time: 12:47 PM
 */
class Utility
{
    public static function getDefaultDeliveryDate(){
        $time=strtotime("+12 hour");
        return date("Y-m-d",$time);
    }

    public static function get_enum_values($connection, $table, $field )
    {
        $enums = array();
        $sql = "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}' ";

        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        //var_dump($result);die;
        $type = $result[0]['Type'];
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);

        $enumArray = explode("','", $matches[1]);
        foreach($enumArray as $enum){
            $a = array();
            $a["value"] = $enum;
            array_push($enums, $a);
        }
        //var_dump($enums);die;
        return $enums;
    }

    public static function array_sort($array, $on, $order=SORT_ASC){

        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public function getWarehouseDropdownData(){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select id , name from cb_dev_groots.warehouses';
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        $array = array();
        foreach ($data as $key => $value) {
            $array[$value['id']] = $value['name'];
        }
        return $array;
    }

    public function getWarehouseNameById($w_id){
        $sql = 'select name from cb_dev_groots.warehouses where id = '.$w_id.' limit 1';
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $name = $command->queryAll();
        return $name[0]['name'];
    }

    public function calTotPayAmoByRetailer($retailerId){
        $retailerOrders = OrderHeader::model()->findAllByAttributes(array('user_id'=>$retailerId ),array('select'=>'total_payable_amount','condition'=>'status = "Delivered" and delivery_date >= "2016-09-01"' ,'order'=> 'delivery_date ASC'));
        $retailerPayments = RetailerPayment::model()->findAllByAttributes(array('retailer_id'=>$retailerId), array('select'=>'paid_amount', 'condition'=>'status != 0 and date >= "2016-09-01"', 'order'=> 'date ASC'));
        $outstanding = Retailer::getInitialPayableAmount($retailerId);
        foreach ($retailerOrders as $key => $value) {
            $outstanding += $value['total_payable_amount'];
        }
        foreach ($retailerPayments as $key => $value) {
            $outstanding -= $value['paid_amount'];
        }
        return $outstanding;
    }

    public function calLastPayAmoByRetailer($retailerId){
        $outstanding = Retailer::getInitialPayableAmount($retailerId);
        $last_due_date = Retailer::getLastDueDate($retailerId);
        $retailerOrders = OrderHeader::model()->findAllByAttributes(array('user_id'=>$retailerId ),array('select'=>'total_payable_amount','condition'=>'status = "Delivered" and delivery_date >= "2016-09-01" and delivery_date <= "'.$last_due_date.'"' ,'order'=> 'delivery_date ASC'));
        $retailerPayments = RetailerPayment::model()->findAllByAttributes(array('retailer_id'=>$retailerId), array('select'=>'paid_amount', 'condition'=>'status != 0 and date >= "2016-09-01" and date <= "'.$last_due_date.'"', 'order'=> 'date ASC'));
        foreach ($retailerOrders as $key => $value) {
            $outstanding += $value['total_payable_amount'];
        }
        foreach ($retailerPayments as $key => $value) {
            $outstanding -= $value['paid_amount'];
        }
        return $outstanding;
    }
}
