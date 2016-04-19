<?php
/* @var $this CategoryController */
/* @var $model Category */
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    
     if (!(isset($_GET['store_id']))||(empty($_GET['store_id']))) {
        $this->redirect(array('site/logout'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $store_name = Store::model()->getstore_nameByid($store_id);
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
         $store_name => array('store/update', "id" => $store_id),
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'Configure Linesheet With Retailer',
    );
} else {
    if (!(isset($_GET['store_id']))||(empty($_GET['store_id']))) {
         Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $this->breadcrumbs = array(
    'Linesheet' => array('admin', 'store_id' => $store_id),
    'Configure Linesheet With Retailer',
);
}


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
  //  array('label' => 'Create Linesheet', 'url' => array('storeFront/create')),
        // array('label' => 'Bulk Upload Linesheet', 'url' => array('storeFront/bulkupload', 'store_front_id' => $model->store_front_id)),
);
?>


<h1 class="item_title">Configure Retalers With Linesheet</h1>
<form name="frm" method="post">
    <div class="form" >
        <?php
        $storedata = StoreFront::model()->getMappedRetailersbystorefront($_GET['id']);
        $this->widget('zii.widgets.grid.CGridView', array(
             'itemsCssClass' => 'table table-striped table-bordered table-hover',
            'dataProvider' => $model_retailers->search(),
            'filter' => $model_retailers,
            'columns' => array(
                array(
                    'header' => "Check",
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 30000,
                    'checked' => function($data) use($storedata) {
                        return in_array($data->id, $storedata);
                    },
                    'checkBoxHtmlOptions' => array("name" => "retailers[]"),
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
                    'name' => 'created_date',
                    'type' => 'raw',
                ),
//                array(
//                    'name' => 'status',
//                    'type' => 'raw',
//                ),
            ),
        ));
        ?>
        <div class="span10">
        <div class="row buttons">
            <input type="submit" name="save" value="Save">
        </div>
         </div>

    </div></form>