<?php

/**
 * This is the model class for table "ticket_info".
 *
 * The followings are the available columns in table 'ticket_info':
 * @property integer $id
 * @property string $user_details
 * @property integer $status
 * @property integer $approve
 * @property string $approve_by
 * @property string $comment
 * @property string $created_at
 * @property string $modified_at
 */
class TicketInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticket_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_details, status, approve, approve_by, comment, created_at, modified_at', 'required'),
			array('status, approve', 'numerical', 'integerOnly'=>true),
			array('user_details, approve_by', 'length', 'max'=>155),
			array('comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_details, status, approve, approve_by, comment, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'user_details' => 'User Details',
			'status' => 'Status',
			'approve' => 'Approve',
			'approve_by' => 'Approve By',
			'comment' => 'Comment',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_details',$this->user_details,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('approve',$this->approve);
		$criteria->compare('approve_by',$this->approve_by,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TicketInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
