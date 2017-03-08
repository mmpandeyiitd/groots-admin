<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'Manage Category', 'url'=>array('index')),
);
?>




<div class="portlet" id="yw0" style=" margin: 20px;">
<!--<ul class="tab_list">
    <li><a href="index.php?r=category/index">Category List</a></li>
</ul>-->
<div class="portlet-content1">
<?php $this->renderPartial('_form', array('model'=>$model, 'category_id' => $category_id,)); ?>
</div>
</div>
<style type="text/css">
.bulk_center {
    width: 450px;
    padding: 15px;
    overflow: hidden;
    border: 0;
   margin: 0;
}
.caregory_btn { margin-left: 130px !important;}
    .caregory_btn input {     width: 140px;
    float: left;
    padding: 10px 30px;
    border: 1px solid #324287;
    color: #FFFFFF;
    text-transform: uppercase;
    border-radius: 4px !important;
    background: #521042;
    border-color: #521042 !important;
    margin-right: 15px;}
</style>