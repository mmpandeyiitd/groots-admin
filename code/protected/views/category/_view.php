<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Bulk Upload Category', 'url'=>array('bulkupload')),
	
);
?>

<h1>Categories</h1>


<div style="float:left;width:250px;">

  
    <?php 
           
    $this->renderPartial('category_tree', array('category_id'=>'')); ?>
</div>
<script type="text/javascript">
   
    function reloadCategory(cat){
	alert("test"):
	
        <?php if (Yii::app()->controller->action->id == 'edit'):?>
            var cat_id = cat.substring(cat.search('---')+3, cat.length);
            var url = '<?php echo Yii::app()->controller->createUrl("category/edit");?>';
            window.location=url+"&category_id="+cat_id;
            <?php endif;?>
    }
	</script>