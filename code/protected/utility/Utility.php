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

    public static function convertOrderToKg($qty, $pack_size, $pack_unit ){
        $quantityInKg = '';
        if ($pack_unit == 'g') {
            $quantityInKg = $qty * ((int)$pack_size)/1000;
        }
        else {
            $quantityInKg = $qty * ((int)$pack_size);
        }
        return $quantityInKg;
    }

    public static function converOrderToUnit(){

    }
}
