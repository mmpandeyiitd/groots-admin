<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 9/9/16
 * Time: 2:24 PM
 */


Yii::import('zii.widgets.CPortlet');

class VendorDropdown extends CPortlet
{
    public $model ='';
    public $vendorId='';
    public $update='';
    public $contentCssClass='';

    protected function renderContent()
    {
        $this->render('_vendorDropdown', array(
            'model'=>$this->model,
            '$vendorId'=>$this->retailerId,
            'update'=>$this->update,

        ));
    }
}