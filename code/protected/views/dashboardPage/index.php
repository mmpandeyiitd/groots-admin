<?php
/* @var $this DashboardPageController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs = array(
    'Dashboard Pages',
);

#....Start Session clear for Brand admin...#
if(Yii::app()->session['brand_admin_id']){
    unset(Yii::app()->session['brand_admin_id']);
}
#....End Session clear for Brand admin...#
?>
<div class="form create_styleform"  >   
  
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dashboard-page-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<?php

$dasboard_obj = new DashboardPage;
$TotalOrder = $dasboard_obj->getOrderCount($start_date,$end_date);
$total_pendingOrder = $dasboard_obj->GetPendingorder($start_date,$end_date);
$total_shippedOrder = $dasboard_obj->GetShippedOrder($start_date,$end_date);
$total_cancelledOrder = $dasboard_obj->GetCancelledorder($start_date,$end_date);
$total_returnOrder = $dasboard_obj->GetReturnorder($start_date,$end_date);

$Total_linesheet=$dasboard_obj->getTotalLinesheet();


$base_model_obj = new BaseProduct();
$totalproduct = $base_model_obj->getproductCount();

$retailer_obj = new Retailer();
$totalretailers = $retailer_obj->gettotal_retailersForindex();
?>

    <?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary" ><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
     <?php if (Yii::app()->user->hasFlash('permission_error')): ?><div class="errorSummary" ><?php echo Yii::app()->user->getFlash('permission_error'); ?></div><?php endif; ?>
<form method="post">
<div class="dashboard-table">
      <?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary" ><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
    <h4>Orders</h4>
    <div class="right_date">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
           'name' => 'start_date',
           // 'attribute' => 'start_date',
            // 'flat' => false, //remove to hide the datepicker
            'options' => array(
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                // 'minDate' => 0,
                'dateFormat' => 'dd-mm-yy',
                
            ),
            'value'=>$start_date,
            'htmlOptions' => array(
                'style' => ''
            ),
        ));
        ?>
        <!--<input name="start_date" type="text" placeholder="22/02/2015" data-uk-datepicker="{format:'DD.MM.YYYY'}">-->

        <label>To</label>
        <!--<input name="end_date" class=""  type="text" value="" data-uk-datepicker="{format:'DD.MM.YYYY'}">-->
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'name' => 'end_date',
         //   'attribute' => 'end_date',
            // 'flat' => false, //remove to hide the datepicker
            'options' => array(
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                // 'minDate' => 0,
                'dateFormat' => 'dd-mm-yy',
               
            ),
             'value'=>$end_date,
            'htmlOptions' => array(
                'style' => ''
            ),
        ));
        ?>        
        <input name="filter" class="button_new" type="submit" value="Filter" />
    </div>
    <table class="table">
        <tr>
            <td class="gray">
                <h5><?php echo $TotalOrder; ?></h5>
                <span>Total</span>
            </td>
            <td>
                <h5><?php echo $total_pendingOrder; ?></h5>
                <span>Pending</span>
            </td>
            <td class="gray">
                <h5><?php echo $total_shippedOrder; ?></h5>
                <span>Shipped</span>
            </td>
            <td>
                <h5><?php echo $total_cancelledOrder; ?></h5>
                <span>Canceled</span>
            </td>
            <td class="gray" >
                <h5><?php echo $total_returnOrder; ?></h5>
                <span>Return</span>
            </td>
        </tr>
    </table>
</div>
<div class="view custom_dashboard">
       <div class="span4 " >
            <div class="dashboard_boxes">
                <div class="icon_box">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="conten_boxright">
                    <span >Total Product</span>
                    <span><?php echo $totalproduct;;  ?></span>
                </div>
            </div>
        </div>
    <div class="span4 " >
        <div class="dashboard_boxes">
            <div class="icon_box" style="background: #2A868A;">
                <i class="fa fa fa-modx"></i>
            </div>
            <div class="conten_boxright">
                <span>Total Category</span>
                <span><?php echo $Total_linesheet -2; ?></span>
            </div>
        </div>
    </div>

    <div class="span4">
        <div class="dashboard_boxes">
            <div class="icon_box" style="background: #848484;">
                <i class="fa fa-line-chart"></i>
            </div>
            <div class="conten_boxright">
                <span>Total Retailers</span>
                <span><?php echo $totalretailers; ?></span>
            </div>
        </div>
    </div>

    <a href="index.php?r=orderHeader/admin" class="info_box">


        <!--    <a href="index.php?r=store/admin&status=inactive" class="info_box">
                        <div class="widget-icon pull-left themed-background-autumn animation-fadeIn">
                <span><?php //echo $CountnewInactivetrooper[0]['count'];  ?></span>
            </div>
                    <h3>New Register Trooper(inactive)</h3>
            </a>
        
            <a href="index.php?r=store/admin&ideal=1" class="info_box">
                                <div class="widget-icon pull-left themed-background-autumn animation-fadeIn">
              <span><?php //echo $Countidealtrooper[0]['count'];  ?></span>
            </div>
                    <h3> Idle Trooper</h3>
            </a>-->


</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
</form>