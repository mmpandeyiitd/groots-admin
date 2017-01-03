<?php

$vendor_id = $_GET['vendor_id'];

?>
<form name="myform" method="post" action="<?php echo $this->createUrl('vendor/productMap', array('vendor_id' => $vendor_id));?>">
<div>
<h1>VENDOR PRODUCT MAPPING </h1>
<?php echo 'Vendor ID =      '.$vendor_id.'<br>';?>
<?php echo 'Name =           '.$model->name.'<br>';?>
<?php echo 'Bussiness Name = '.$model->bussiness_name.'<br>'; ?>
<?php echo 'Mobile Number =  '.$model->mobile.'<br>'; ?>
</div>

<?php
    // var_dump($dataProvider->searchNew());die;
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'vendor-product-grid',   
		'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'rowHtmlOptionsExpression' => 'array("id" => "bp_".$data->base_product_id)',
        'rowCssClassExpression' =>'$data->getCssClass()',
        'afterAjaxUpdate' => 'onPageStartUp',
        'dataProvider'=> $dataProvider->searchNew(),
		'filter' => $dataProvider,
		'columns' => array(
                array(
                    'header' => 'show child',
                    'htmlOptions' => array('style' => 'width:5%;', 'class' => 'expand-bt'),
                    'value' => function($data){

                        if(isset($data->parent_id) && $data->parent_id == 0){
                            //onstartUp($data->base_product_id);
                            return CHtml::button("+",array("onclick"=> "toggleChild(".$data->base_product_id.")" ));
                        }
                        else{
                            return "";
                        }

                    },
                    'type' => 'raw',
                ),
     //            array(
					// 'header' => 'check',
     //                'id' => 'CheckedIds',
     //                'name' => 'CheckedIds[]',
     //                'class' => 'CCheckBoxColumn',
     //                'checkBoxHtmlOptions' => function($data){
     //                    return array('id' => 'CheckedIds_'.$data->base_product_id, 'onclick' => 'onCbStateChange('.$data->base_product_id.')');
     //                },
					// 'checked' => function($data) use ($products) {
					// 	$checked = in_array($data->base_product_id, $products);
					// 	return $checked;
					// },
     //                'value' => function($data){
     //                    return $data->base_product_id;
     //                },
     //                'selectableRows' => 100,
					// ),
                array
                (   'header' => 'check',
                    'value' => function($data) use ($products){
                        $checked = array_key_exists($data->base_product_id, $products);
                        echo CHtml::checkBox('checkedId_'.$data->base_product_id, $checked, array('onclick' => 'onCbStateChange('.$data->base_product_id.')'));
                    },
                    ),
            	'base_product_id',
            	//'parent_id',
                'title',
            	'grade',
            	//'popularity',
            	//'priority',
            	//'base_title',
                array(
                    'header' => 'Price',
                    'type' => 'raw',
                    'value' => function($data) use ($products){
                        $temp = array_key_exists($data->base_product_id, $products) ? $products[$data->base_product_id]['price'] : '';
                        return CHtml::textField('price[]', $temp, array('style' => 'width:100px;'));
                    }
                    ),
            	array(
            		'value' => function($data){
            			echo CHtml::hiddenField('baseProductIds[]', $data->base_product_id);
            		},
            		'type' => 'raw',
            		),
            ),
        )
    );   
?>

<div class="row buttons">
    <?php echo CHtml::submitButton('Save', array('name' => 'save'));?>
</div>
</form>


<script type="text/javascript">
    $(document).ready(function(){
        onPageStartUp();

       
    });

    function onPageStartUp(){
        onStartUp();
        showAllItemsChecked();  
    }

    function onCbStateChange(bp_id){
        var p_value = $('#checkedId_'+bp_id).is(':checked');
        // if(p_value == true){
        //     $('#bp_'+bp_id).addClass('checked');
        // }
        // else 
        //     $('')
        $(".parent-id_"+bp_id).each(function(){
            // console.log(p_value);
        $(this).find('input[type=checkbox]').each(function(){
                //console.log($(this).is(':checked'));
                $(this).attr('checked', p_value);
            });
        }); 
    }

    function toggleChild(bp_id){
        $(".parent-id_"+bp_id).each(function ( ){
            if(!$(this).hasClass("unsorted")){
                // console.log("reached toggle");
                // $(this).css('display', 'none');
                $(this).toggle();
            }

        })
    }

    function onStartUp(){
        console.log('onStartUp');
        $(".child").each(function(){
            //console.log($(this).attr('class'));
            var isChecked = false;
            $(this).find('input[type=checkbox]').each(function(){
                isChecked = $(this).is(':checked');
            });
            //console.log($(this).attr('class'));
            if(isChecked == true){
                var cls = $(this).attr('class');
                $(this).addClass('checked');
            }
        });
    }

    function showChecked(){
        $(".checked").each(function(){
            $(this).show();
        });
    }

    function showAllItemsChecked(){
        console.log('show');
        $(".checked").each(function(){
            var classList = $(this).prop('className').split(' ');
            //console.log(classList);
            var p_id = '';
            $.each(classList, function(index , value){
                //console.log(value);
                if(value.startsWith('parent-id')){
                    p_id = value;
                }
            });
            console.log(p_id);
            $('.'+p_id).each(function(){
                $(this).show();
            });
        });
    }
</script>

