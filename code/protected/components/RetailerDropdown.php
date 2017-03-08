<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 27/8/16
 * Time: 1:29 PM
 */



Yii::import('zii.widgets.CPortlet');

class RetailerDropdown extends CPortlet
{
    public $model ='';
    public $retailerId='';
    public $update='';
    public $showInactive=false;
    public $contentCssClass='';

    protected function renderContent()
    {
        $this->render('_retailerDropdown', array(
            'model'=>$this->model,
            'retailerId'=>$this->retailerId,
            'update'=>$this->update,
            'showInactive'=>$this->showInactive,

        ));
    }
}
