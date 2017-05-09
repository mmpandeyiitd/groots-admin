<?php
class OrderHeaderDao{

    public function getCurrentConfirmedOrderSku($date){
        $connection= Yii::app()->secondaryDb;
        $sql = 'select distinct ol.base_product_id,bp.title from order_line as ol left join order_header as oh on oh.order_id = ol.order_id 
                left join cb_dev_groots.base_product as bp on bp.base_product_id = ol.base_product_id where oh.status = "Confirmed" 
                and oh.delivery_date = "'.$date.'" order by bp.title';
        //die($sql);
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        //var_dump($result);die;
        return  new CArrayDataProvider($result, array(
            'sort'=> array(
                'attributes' => array(
                    'base_product_id', 'title'
                )
            ),
            //'pagination' => array('pageSize' => 80)
        ));
    }

    public function getuserIdsFromShortSku($parentIds,$date){
        $array = $checkUserId = array();
        $connection = Yii::app()->secondaryDb;
        foreach ($parentIds as $id ){
            $sql = 'select base_product_id from cb_dev_groots.base_product where parent_id = '.$id;
            $command = $connection->createCommand($sql);
            $res = $command->queryAll();
            $sql = '';
            if($res){
                $product_ids = '';
                $first = true;
                foreach ($res as $value){
                    $product_ids .= ($first) ? '' : ', ';
                    $product_ids .= $value['base_product_id'];
                    $first = false;
                }
                $sql = 'select distinct oh.order_id from order_header as oh left join order_line as ol on ol.order_id = oh.order_id 
                        where oh.delivery_date ="'.$date.'" and ol.base_product_id in('.$product_ids.') and oh.status = "Confirmed"';
            }
            else {
                $sql = 'select distinct oh.order_id from order_header as oh left join order_line as ol on ol.order_id = oh.order_id 
                        where oh.delivery_date ="'.$date.'" and ol.base_product_id ='.$id.' and oh.status = "Confirmed"';
            }
            $command = $connection->createCommand($sql);
            $res = $command->queryAll();
            foreach ($res as $value){
                if(!isset($checkUserId[$value['order_id']])){
                    $checkUserId[$value['order_id']] = true;
                    array_push($array, $value['order_id']);
                }
            }
        }
        return $array;

    }
}
?>