<?php
#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
if (array_key_exists('brand', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['brand'], 'C')) {
        $visible_dropdownmenu = TRUE;
    } else {
        $visible_dropdownmenu = FALSE;
    }

    if (strstr(Yii::app()->session['premission_info']['module_info']['brand'], 'U')) {
        $visible_action_edit = TRUE;
    } else {
        $visible_action_edit = FALSE;
    }
}
#.........End Visibility.....#


Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $('#category-grid').yiiGridView('update', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
if (Yii::app()->session['is_super_admin'] == 1) {
//$this->menu = array(
//    array('label' => 'Add Brand', 'url' => array('store/create'),'visible' => $visible_dropdownmenu),
//    //array('label'=>'Configure Retailers', 'url'=>array('store/mapretailer')),
//);
}
?>
<?php
$model_retailers = new Retailer();
$rdetils = $model_retailers->data_retailers($_REQUEST['id']);
//echo '<pre>';
//print_r($rdetils);die;
?>

<?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary"><?php echo Yii::app()->user->getFlash('premission_info'); ?></div><?php endif; ?>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="Csv" style="color:green;">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        <?php echo Yii::app()->user->getFlash('prod'); ?>
    </div>
<?php endif; ?>
<?php
//$pageSize = Yii::app()->user->getState( 'pageSize', Yii::app()->params[ 'defaultPageSize' ] );
$pageSize = 10;
$pageSizeDropDown = CHtml::dropDownList(
                'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100, 500 => 500), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('order-header-grid',{data:{pageSize:$(this).val()}});",
                )
);
?>
<h5 style="float: left;">
    <?php
    echo "Name : " . $rdetils['0']['name'];
    echo '</br>';
    echo "Email : " . $rdetils['0']['email'];
    echo '</br>';
    echo "Mobile :" . $rdetils['0']['mobile'];
    ?></h5>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model_grid' => $model_grid,
    ));
    ?>
</div><!-- search-form -->
<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error label label-success" style="margin-left: 15px;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error label label-important" style="margin-left: 15px;"  ><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<?php
$model_admin_data = new RetailerProductQuotation();
// $data1 = $model_admin_data->admin_retailer_id($_REQUEST['id']);
//  echo '<pre>';print_r($data1);die;
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation' => true,
        ));
?>
<?php
//$pageSize = Yii::app()->user->getState( 'pageSize', Yii::app()->params[ 'defaultPageSize' ] );
$pageSize = 10;
$pageSizeDropDown = CHtml::dropDownList(
                'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100, 500 => 500), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('order-header-grid',{data:{pageSize:$(this).val()}});",
                )
);
?>
 <a href="index.php?r=retailer/admin" class="backBtn_new1">Back</a>
<input name="savedata" class="activebutton" value="save" type="submit">

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'id' => 'ympdm-store-grid',
    'dataProvider' => $model_grid->search('created_date DESC'),
    'filter' => $model_grid,
    
    'columns' => array(
       
        array(
            'header' => 'Status',
            'name' => 'selectedIds[]',
            'id' => 'selectedIds',
            'value' => '$data->subscribed_product_id',
            'class' => 'CCheckBoxColumn',
            'checked'=>'($data->effective_price!=" "? true : false);',
            'selectableRows' => '100',
        ),
        
        'title',
        'store_price',
        'store_offer_price',
        
   array(
            //'header' => 'check',
            'name' => 'effective_price',
            'type' => 'raw',
            'value' => 'CHtml::textField("effective_price[$data->subscribed_product_id]",$data->effective_price,array("maxlength" =>5,"style"=>"width:50px;"))',
            'htmlOptions' => array("width" => "50px","class" => "eft_price"),
        ),
        array(
            'header' => 'Discount %',
            'name' => 'discount_price',
            'type' => 'raw',
            'value' => 'CHtml::textField("discount_price[$data->subscribed_product_id]",$data->discount_price,array("maxlength" =>2,"style"=>"width:50px;"))',
            'htmlOptions' => array("width" => "50px", "class" => "dis_price"),
        ),
         array(
            'header' => 'status',
            'name' => 'status',
              
            'type' => 'raw',
            'value' => 'CHtml::dropDownList("status[$data->subscribed_product_id]",$data->status,array("1" =>"Enable","0" => "Disable", ))',
            'htmlOptions' => array("width" => "50px"),
        ),
//         array(
//            'header' => 'Discount %',
//            'name' => 'status',
//            'type' => 'raw',
//            'value' => 'CHtml::textField("status[$data->subscribed_product_id]",$data->status,array("maxlength" =>2,"style"=>"width:50px;"))',
//            'htmlOptions' => array("width" => "50px", "class" => "dis_price"),
//        ),
    ),
));
?>
<?php $this->endWidget(); ?>
<script>
    $(document).on('keyup', '.eft_price input', function () {
        var ele = $(this).closest('tr').find('.dis_price input')[0];
       // alert($(this).val());
       if(isNaN($(this).val()))
       {
           alert('Only numeric value insert');
           $(this).val(0)
           $(ele).prop('disabled', false);
       }
        else if ($(this).val() != 0 || $(this).val() != '') {
            $(ele).val(0);
            $(ele).prop('disabled', true);
        } else {
            $(ele).val(0);
            $(ele).prop('disabled', false);
        }
        //console.log($(this).val() , "Hello", this, ele );
    })
    
    
    $(document).on('keyup', '.dis_price input', function () {
        var ele = $(this).closest('tr').find('.eft_price input')[0];
        if ($(this).val() != 0 || $(this).val() != '') {
            $(ele).val(0);
            $(ele).prop('disabled', true);
        } else {
            $(ele).val(0);
            $(ele).prop('disabled', false);
        }
        if ($(this).val() > 100)
        {
            alert("Discount maximum limit is 100 percentage");
            $(this).val(100);
        }
        //console.log($(this).val() , "Hello", this, ele );
    })
    $(document).on('click', '.checkbox-column input', function () {
        var ele=this;
        var eft = $(this).closest('tr').find('.eft_price input')[0];
        var dis = $(this).closest('tr').find('.dis_price input')[0];
        
        if($(ele).attr('checked')=='checked'){
            $(eft).val($(ele).attr('eft'));
            $(dis).val($(ele).attr('dis'));
        }else{
            $(ele).attr('eft',$(eft).val());
            $(ele).attr('dis',$(dis).val());
            $(eft).val('');
           $(dis).val('');
        }
        
        
        
//        console.log($(this).val() , "Hello", this, ele );
    })
    
</script>
<script type="text/javascript">
    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    $(function () {
        $(".eft_price").bind("keypress", function (e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
        });
        $(".eft_price").bind("paste", function (e) {
            return false;
        });
        $(".eft_price").bind("drop", function (e) {
            return false;
        });
    });
    $(function () {
        $(".dis_price").bind("keypress", function (e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
        });
        $(".dis_price").bind("paste", function (e) {
            return false;
        });
        $(".dis_price").bind("drop", function (e) {
            return false;
        });
    });
</script>

