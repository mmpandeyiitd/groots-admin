<?php

/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 1/10/16
 * Time: 11:39 PM
 */
class InventoryHeaderDao
{
    public static function getInventoryHeaderMapByBpId($w_id){
        $inv_head_arr = array();
        $inv_heads = InventoryHeader::model()->findAllByAttributes(array('warehouse_id'=>$w_id));
        foreach ($inv_heads as $inv_head){
            $inv_head_arr[$inv_head->base_product_id] = $inv_head;
        }
        return $inv_head_arr;
    }

}