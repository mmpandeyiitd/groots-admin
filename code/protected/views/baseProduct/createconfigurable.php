<?php
/* @var $this BaseProductController */
/* @var $model BaseProduct */

$this->breadcrumbs=array(
    'Styles'=>array('index'),
    'Configurable Styles'=>array('configurablegrid'),
    'Create Configurable',
);

//           $this->menu=array(
//    
//    array('label'=>'Create Style', 'url'=>array('create')),
//        array('label'=>'Bulk Upload Style', 'url'=>array('baseProduct/bulkupload')),
//         array('label'=>'Bulk Upload Media', 'url'=>array('baseProduct/media')),
//          array('label'=>'Manage Configurable Styles', 'url'=>array('baseProduct/configurablegrid')),
//       );

if(!empty($category_id)){
    $this->breadcrumbs['Configurable Products']['category_id'] = $category_id;
}

?>


<?php if(Yii::app()->user->hasFlash('success')): ?><div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?><div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>

 <ul class="tab_list" >
    <li><a href="index.php?r=baseProduct/create&store_id=<?php echo $store_id;?>">Create Style</a></li>
    <li><a href="index.php?r=baseProduct/admin&store_id=<?php echo $store_id;?>">Styles List</a></li>
    <li><a href="index.php?r=baseProduct/bulkupload&store_id=<?php echo $store_id;?>">Bulk Upload Style</a></li>
    <li><a href="index.php?r=baseProduct/media&store_id=<?php echo $store_id;?>">Bulk Upload Media</a></li>
</ul>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'base_product_id',
        'title',
        'color',
        'size',
        //'configurable_with',
        array(
          'name'=>'configurable_with',
          'label'=>'Configurable With',
          'template'=>"<tr class=\"{class}\"><th>{label}</th><td style='word-wrap: break-word;word-break: break-all'>{value}</td></tr>",
        ),
    ),
)); ?>
    
    <a href='#' onclick='resetFilter();'>Reset</a>
    
    <?php $ids = null;
    if (!empty($model->configurable_with)) {
        $ids = explode(',', $model->configurable_with);
    }
    ?>
    
    <form method="post" id="config-pdts-frm">
    
    <input type="hidden" id="selectedIds" name="selectedIds" value="<?php echo $model->configurable_with?>">
    <input type="hidden" id="oldIds" name="oldIds" value="<?php echo $model->configurable_with?>">
    <input type="hidden" id="category_id" name="category_id" value="<?php echo $category_id?>"> 
    
    <?php 
    
   
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'base-product-grid',
    //'dataProvider'=>$base_product_model->configurablegrid(($reset == 1) ? null : $ids,null,$base_product_id),
    'dataProvider'=>$base_product_model->configurablegrid($cat_base_product_ids, $category_id),
    'filter'=>$base_product_model,
    'columns'=>array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 10000,
            'checkBoxHtmlOptions' => array(
                'name' => 'userids[]',
            ),
            'value'=>'$data->base_product_id',
         ),
        array(
            'name'=>'base_product_id',
            'type'=>'raw',
        ),
        array(
            'name'=>'title',
            'type'=>'raw',
        ),
        array(
            'name'=>'color',
            'type'=>'raw',
        ),
        array(
            'name'=>'size',
            'type'=>'raw',
        ),
        /*array(
            'name'=>'status',
            'value'=>'Functions::getStatus($data->status)',
            'filter'=>CHtml::listData(Functions::getStatuses($type = 'base_product'), 'value', 'label')
        ),*/
        array(
            'name'=>'configurable_with',
            'type'=>'raw',
            'htmlOptions' => array('style' => 'word-wrap: break-word;word-break: break-all'),
        ),
        array(
            'name'=>'created_date',
            'type'=>'datetime',
            'filter' => false
        ),
    ),
    )); ?>
    
    <div class="row buttons">
        <input type="submit" value="Save"/>
    </div>

    </form>
<script type="text/javascript">
    function resetFilter(){
        var url = '<?php echo Yii::app()->controller->createUrl("baseProduct/createconfigurable",array("id"=>$base_product_id,"category_id"=>$category_id,));?>';
        window.location=url+'&reset=1';
    }

    jQuery( document ).ready(function() {
        checkRows();
    });
    
    jQuery( document ).ajaxComplete(function( event, xhr, settings ) {
        checkRows();
    });

    function checkRows() {
        jQuery("input[name='userids[]']").each( function () {
        var idStr = jQuery("#selectedIds").val();
        var ids = idStr.split(",");
        if(jQuery.inArray(jQuery(this).val(), ids)!==-1){
        //if (ids.indexOf(jQuery(this).val()) != -1) {
            jQuery(this).prop('checked', true);
            }
        });
    }

    function updateProductMapping(chkbx) {
        var i =0;
        //var product = chkbx.getElementsByTagName('input');
        var idStr = document.getElementById("selectedIds").value;
        var ids = idStr.split(",");
        if (chkbx.checked == true) {
            ids.push(chkbx.value);            
        } else {
            found = jQuery.inArray(chkbx.value, ids);//ids.indexOf(product[0].value);
            while (found !== -1) {
                ids.splice(found, 1);
                found = jQuery.inArray(chkbx.value, ids);
            }
        }
        document.getElementById("selectedIds").value = ids;
    }

    function updateMassProductMapping(chkbx) {
        var idStr = document.getElementById("selectedIds").value;
        var ids = idStr.split(",");
        
        jQuery("input[name='userids[]']").each( function () {
            if (chkbx.checked == true) {
                found = jQuery.inArray(this.value, ids);
                if (found == -1) {
                    ids.push(this.value);
                }
            } else {
                found = jQuery.inArray(this.value, ids);//ids.indexOf(jQuery(this).val());
                while (found !== -1) {
                    ids.splice(found, 1);
                    found = jQuery.inArray(this.value, ids);//ids.indexOf(jQuery(this).val());
                }
            }
        });
        
        document.getElementById("selectedIds").value = ids;
    }

    jQuery( document ).on('change',"#base-product-grid_c0_all",function(){
        updateMassProductMapping(this);
        });

    jQuery( document ).on('change',"input[name='userids[]']",function(){
        updateProductMapping(this);
    });
</script>