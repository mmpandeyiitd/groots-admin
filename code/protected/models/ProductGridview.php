<?php

/**
 * This is the model class for table "product_gridview".
 *
 * The followings are the available columns in table 'product_gridview':
 * @property string $base_product_id
 * @property string $style_no
 * @property string $title
 * @property integer $status
 * @property string $store_price
 * @property string $store_offer_price
 * @property integer $available_quantity
 * @property string $size
 * @property string $store_name
 * @property string $linesheet
 */
class ProductGridview extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_gridview';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, status, available_quantity', 'required'),
			array('status, available_quantity', 'numerical', 'integerOnly'=>true),
			array('base_product_id', 'length', 'max'=>11),
			
			array('title, size, store_name', 'length', 'max'=>255),
			array('store_price, store_offer_price', 'length', 'max'=>12),
			array('linesheet', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('base_product_id, title, status, store_price, store_offer_price, available_quantity, size, store_name, linesheet', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'base_product_id' => 'Base Product',
			'style_no' => 'Style No',
			'title' => 'Title',
			'status' => 'Status',
			'store_price' => 'MRP',
			'store_offer_price' => 'WSP',
			'available_quantity' => 'Quantity',
			'size' => 'Size',
			'store_name' => 'Brand',
			'linesheet' => 'Linesheet',
		);
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

		$criteria=new CDbCriteria;
                
        if (!empty($category_id) AND empty($cat_base_product_ids)) {
            $cat_base_product_ids = array(0);
        }

        if (!empty($cat_base_product_ids) AND is_array($cat_base_product_ids)) {
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 'base_product_id IN (' . implode(',', $cat_base_product_ids) . ')';
        }

        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin == 1) {
            $adminid = $_GET['store_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 't.store_id =' . $adminid;
        } else {
            $adminid = Yii::app()->session['brand_id'];
            if (!empty($criteria->condition)) {
                $criteria->condition .= ' AND ';
            }
            $criteria->condition .= 't.store_id =' . $adminid;
        }

		$criteria->compare('base_product_id',$this->base_product_id,true);
		
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('store_price',$this->store_price,true);
		$criteria->compare('store_offer_price',$this->store_offer_price,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('store_name',$this->store,true);
		$criteria->compare('linesheet',$this->linesheet,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductGridview the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
