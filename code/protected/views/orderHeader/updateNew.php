<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 12/8/16
 * Time: 11:32 PM
 */

    

$w_id='';
if(isset($_GET['w_id'])){
    $w_id = $_GET['w_id'];
}
$this->breadcrumbs=array(
    'Orders'=>array('admin&w_id='.$w_id),
    'Update',
);
$this->menu=array(
    array('label'=>'Order List', 'url'=>array('admin&w_id='.$w_id)),
    //array('label'=>'Create Order', 'url'=>array('create&w_id='.$w_id)),
);
?>

<h1>Update Order : <b><?php echo $model->attributes['order_number']?></b></h1>

<div class="" >

    <div class="">
        <?php //$this->renderPartial('_retailerDropdown', array('model'=>$model, 'retailerId'=>$retailerId, 'update'=>true)); ?>
        <?php
        $this->widget('RetailerDropdown', array(
            'model'=>$model,
            'retailerId'=>$retailerId,
            'update'=>true,

        ));
        ?>


        <?php
         $this->renderPartial('_createOrder', array('model'=>$model, 'orderLine'=>$orderLine, 'retailerProducts'=> $retailerProducts, 'retailerId'=>$retailerId, 'retailer'=>$retailer, 'warehouses'=>$warehouses,'update'=>true));

        ?>

    </div>
</div>