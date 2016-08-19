<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 12/8/16
 * Time: 11:32 PM
 */

    $this->breadcrumbs=array(
        'Order Headers'=>array('admin'),
        'Update',
    );


?>

<h1>Update Order</h1>

<div class="" >

    <div class="portlet-content">
        <?php $this->renderPartial('_retailerDropdown', array('model'=>$model, 'retailerId'=>$retailerId, 'update'=>true)); ?>


        <?php
         $this->renderPartial('_create', array('model'=>$model, 'orderLine'=>$orderLine, 'retailerProducts'=> $retailerProducts, 'retailerId'=>$retailerId, 'retailer'=>$retailer, 'warehouses'=>$warehouses,'update'=>true));

        ?>

    </div>
</div>