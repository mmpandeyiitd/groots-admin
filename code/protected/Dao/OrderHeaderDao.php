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
}
?>