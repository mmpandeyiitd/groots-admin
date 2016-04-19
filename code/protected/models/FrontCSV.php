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
class FrontCSV extends CActiveRecord {

    public $visible;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'store_front';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('csv_file',
                'file', 'types' => 'csv',
                'maxSize' => 5242880,
                'allowEmpty' => true,
                'wrongType' => 'Only csv allowed.',
                'tooLarge' => 'File too large! 5MB is the limit'),
        );
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
        return array(
            'csv_file' => 'Upload CSV File',
        );
    }

    public function run() {
        if ($this->visible) {
            $this->renderContent();
        }
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->compare('store_front_id', $this->store_front_id, true);
        $criteria->compare('store_front_name', $this->store_front_name, true);
        return new CActiveDataProvider(get_class($this), array(
        'criteria' => $criteria,
        ));
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
