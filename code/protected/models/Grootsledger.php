<?php

/**
 * This is the model class for table "grootsledger".
 *
 * The followings are the available columns in table 'grootsledger':
 * @property integer $order_id
 * @property string $order_number
 * @property integer $user_id
 * @property string $agent_name
 * @property string $total_payable_amount
 * @property double $MIN_DUE_AMOUNT
 * @property integer $Max_id
 */
class Grootsledger extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'grootsledger';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_number, user_id', 'required'),
			array('order_id, user_id, Max_id', 'numerical', 'integerOnly'=>true),
			array('MIN_DUE_AMOUNT,paid_value,return_amount', 'numerical'),
			array('order_number, agent_name', 'length', 'max'=>255),
			array('total_payable_amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, order_number, user_id, agent_name, total_payable_amount, MIN_DUE_AMOUNT, Max_id,created_at', 'safe', 'on'=>'search'),
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
			'order_id' => 'Order',
			'order_number' => 'Order Number',
			'user_id' => 'User',
			'agent_name' => 'Agent Name',
			'total_payable_amount' => 'Total Payable Amount',
			'MIN_DUE_AMOUNT' => 'Min Due Amount',
			'Max_id' => 'Max',
			'paid_value'=>'Paid Amount',
			'return_amount' =>'return_amount',
			
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
        //$criteria->condition = "is_collection_done !=1";
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('order_number',$this->order_number,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('agent_name',$this->agent_name,true);
		$criteria->compare('total_payable_amount',$this->total_payable_amount,true);
		$criteria->compare('MIN_DUE_AMOUNT',$this->MIN_DUE_AMOUNT);
		$criteria->compare('Max_id',$this->Max_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                        'defaultOrder'=>'created_at DESC',
                    ),
            'pagination' => array(
                'pageSize' => 100,
            ),
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->secondaryDb;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Grootsledger the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		public function primaryKey()
		{
		    return 'order_id';
		}

		 public static function downloadCSVByIDs() {

     $sqlchksubsid = "SELECT oh.`order_id` , oh.`order_number` , oh.`user_id` AS client_ID, oh.`agent_name` AS Collection_Agent, gl.total_amount, gl.due_amount AS 'DUE_AMOUNT', gl.paid_amount, gl.return_amount, gl.inv_created_at AS INVOICE_CREATED_DATE, gl.created_at
FROM `order_header` oh
LEFT JOIN groots_ledger AS gl ON gl.order_id = oh.order_id";
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sqlchksubsid);
        $command->execute();
        $assocDataArray = $command->queryAll();
        $fileName = "Grootsledger.csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);
        if (isset($assocDataArray['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($assocDataArray['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($assocDataArray AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }



}
