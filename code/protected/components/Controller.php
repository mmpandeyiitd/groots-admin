<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function behaviors()
    {
        return array(
            'RBACAccessComponent'=>array(
                'class'=>'application.modules.rbac.components.RBACAccessVerifier',
                // optional default settings
                'checkDefaultIndex'=>'id', // used with buisness Rules if no Index given
                'allowCaching'=>false,  // cache RBAC Tree -- do not enable while development ;)
                'accessDeniedUrl'=>'/user/login',// used if User is logged in
                'loginUrl'=>'/user/login'// used if User is NOT logged in
            ),
            'accessComponent'=>array(
                'class'=>'application.modules.rbac.components.RBACAccessVerifier',
                // optional default settings
                'checkDefaultIndex'=>'id', 			// used from buisness Rule if no Index given
                'allowCaching'=>false,				// cache RBAC Tree ### D-O--N-O-T--E-N-A-B-L-E ### while development ;)
                'accessDeniedUrl'=>'/user/login',	// used if User is logged in
                'loginUrl'=>'/user/login'			// used if User is NOT logged in
            ),
        );
    }

    public function beforeRender( $view ) {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-listnav.min.js');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/listnav.css');
        return true;
    }

    protected function beforeAction() {
        $action = $this->action->id;
        if($action!=="login"){
            return Utility::loginCheck($this);
        }
        elseif($this->id == 'site'){
            Yii::app()->controller->redirect("index.php?r=user/login");
        }
        return true;
    }
}