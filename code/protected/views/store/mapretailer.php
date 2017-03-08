<form method="post"><?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs = array(
    'Brand' => array('admin'),
    'Manage',
);

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

$this->menu = array(
    array('label' => 'Add Brand', 'url' => array('store/create')),
    array('label'=>'Manage Brands ', 'url'=>array('store/admin')),
);
?>


<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<h1>Retailers Configure With Brand</h1>

<?php  $storedata=  explode(',', $model_load->retailer_mapped);

if ($_SESSION['checkAccess'] == 'Admin') {
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $model1->search(),
        'filter' => $model1,
        'columns' => array(
             array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 10000,
            'checkBoxHtmlOptions' => array(
                'name' => 'retailesid[]',
            ),
            'value'=>'$data->id',
                  'checked' => function($data) use($storedata) {
                                return in_array($data->id, $storedata); 
                        } ,
            
         ),
           array(
                'name' => 'id',
                'type' => 'raw',
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
            ),
            array(
                'name' => 'email',
                'type' => 'raw',
            ),
            array(
                'name' => 'email',
                'type' => 'raw',
            ),
            array(
                'name' => 'city',
                'type' => 'raw',
            ),
//            'link' => array(
//                'header' => 'Action',
//                'type' => 'raw',
//                'value' => 'CHtml::button("Edit",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("store/update",array("id"=>$data->store_id))."\'"))',
//            ),
//            'link1' => array(
//                'header' => 'Download',
//                'type' => 'raw',
//                'value' => 'CHtml::button("Subscribed",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("store/export",array("id"=>$data->store_id))."\'"))',
//            ),
        ),
    ));
} 
?>
 
    <div class="row buttons">
        <input type="submit" name="save" value="Save"/>
    </div>
</form>