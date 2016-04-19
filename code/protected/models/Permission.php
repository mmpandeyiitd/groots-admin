<?php

/**
 * This is the model class for table "csv".
 *
 * The followings are the available columns in table 'csv':
 * @property integer $id
 * @property string $name
 * @property string $age
 * @property string $model
 * @property string $max
 * @property string $accept
 * @property string $duplicate
 * @property string $denied
 */
class Permission extends CActiveRecord {

    public $visible;
	public $action;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'permission_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array();
           
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        
    }

    public function run() {
        
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		
	}
        
		
	public function getPermissionInfo($storearry)
	{	
		$permission_master=json_decode($storearry,true);
				
		//.......................store..................................//	
		Yii::app()->session['store_permission']=explode(",",$permission_master[1]);
		  if(in_array("1",Yii::app()->session['store_permission']))
		   Yii::app()->session['store_permission_add']=1;
		  else
		    Yii::app()->session['store_permission_add']=0;
		  if(in_array("2",Yii::app()->session['store_permission']))
		    Yii::app()->session['store_permission_update']=1;
		  else
		    Yii::app()->session['store_permission_update']=0;	
		  if(in_array("3",Yii::app()->session['store_permission']))
		   Yii::app()->session['store_permission_delete']=1;
		  else
		    Yii::app()->session['store_permission_delete']=0;		
		//..............................end.............................//
		
		//.......................BaseProdouct..................................//	
		Yii::app()->session['base_permission']=explode(",",$permission_master[2]);
		  if(in_array("1",Yii::app()->session['base_permission']))
		   Yii::app()->session['base_permission_add']=1;
		  else
		    Yii::app()->session['base_permission_add']=0;
		  if(in_array("2",Yii::app()->session['base_permission']))
		    Yii::app()->session['base_permission_update']=1;
		  else
		    Yii::app()->session['base_permission_update']=0;	
		  if(in_array("3",Yii::app()->session['base_permission']))
		   Yii::app()->session['base_permission_delete']=1;
		  else
		    Yii::app()->session['base_permission_delete']=0;		
		//..............................end.............................//
		
		//.......................CategoryProdouct..................................//	
		Yii::app()->session['category_permission']=explode(",",$permission_master[3]);
		  if(in_array("1",Yii::app()->session['category_permission']))
		   Yii::app()->session['category_permission_add']=1;
		  else
		    Yii::app()->session['category_permission_add']=0;
		  if(in_array("2",Yii::app()->session['category_permission']))
		    Yii::app()->session['category_permission_update']=1;
		  else
		    Yii::app()->session['category_permission_update']=0;	
		  if(in_array("3",Yii::app()->session['category_permission']))
		   Yii::app()->session['category_permission_delete']=1;
		  else
		    Yii::app()->session['category_permission_delete']=0;		
		//..............................end.............................//
		
		//.......................Strofront..................................//	
		Yii::app()->session['storefront_permission']=explode(",",$permission_master[4]);
		  if(in_array("1",Yii::app()->session['storefront_permission']))
		   Yii::app()->session['storefront_permission_add']=1;
		  else
		    Yii::app()->session['storefront_permission_add']=0;
		  if(in_array("2",Yii::app()->session['storefront_permission']))
		    Yii::app()->session['storefront_permission_update']=1;
		  else
		    Yii::app()->session['storefront_permission_update']=0;	
		  if(in_array("3",Yii::app()->session['storefront_permission']))
		   Yii::app()->session['storefront_permission_delete']=1;
		  else
		    Yii::app()->session['storefront_permission_delete']=0;		
		//..............................end.............................//
		
		//.......................SubscribedProdouct..................................//	
		Yii::app()->session['subscribed_permission']=explode(",",$permission_master[5]);
		  if(in_array("1",Yii::app()->session['subscribed_permission']))
		   Yii::app()->session['subscribed_permission_add']=1;
		  else
		    Yii::app()->session['subscribed_permission_add']=0;
		  if(in_array("2",Yii::app()->session['subscribed_permission']))
		    Yii::app()->session['subscribed_permission_update']=1;
		  else
		    Yii::app()->session['subscribed_permission_update']=0;	
		  if(in_array("3",Yii::app()->session['subscribed_permission']))
		   Yii::app()->session['subscribed_permission_delete']=1;
		  else
		    Yii::app()->session['subscribed_permission_delete']=0;		
		//..............................end.............................//
		
		
		
		
		
		return true;
		
	}
     

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Csv the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
