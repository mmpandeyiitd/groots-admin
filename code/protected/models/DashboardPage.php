<?php

/**
 * This is the model class for table "dashboard_page".
 *
 * The followings are the available columns in table 'dashboard_page':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 */
class DashboardPage extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dashboard_page';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, title', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'user_id' => 'User',
            'title' => 'Title',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DashboardPage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalLinesheet() {

        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
        $row = 0;
        if ($issuperadmin) {
            $sql = "select count(category_id) from category";
        }
        // echo $sql;die;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        if ($command->execute()) {
            $row = $command->queryScalar();
        }
        return $row;
    }

    public function getOrderCount($start_date, $end_date) {
        $total_order = 0;
        $store_id = 1;

        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
        $store_id = 1;

        if ($issuperadmin == 1) {

            $cDate = date("Y-m-d H:i:s", strtotime($start_date));
            $eDate = date("Y-m-d", strtotime($end_date));
            $cdate1 = $eDate . ' 11:59:00';
            // echo $eDate1;die;
            $sql = "select order_id from order_header  WHERE 1=1";
            //echo $start_date; echo "kuldeep".$end_date;die;
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " AND (created_date BETWEEN '" . "$cDate" . "' AND '" . "$cdate1" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $total_order = $command->queryAll();
            // print_r($total_order);die;
            //echo count($total_order);die;
        } else if (is_numeric($store_id)) {
            $sql = "select DISTINCT oh.order_id from order_header oh left join order_line ol on ol.order_id=oh.order_id where ol.store_id='" . $store_id . "'";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$start_date" . "' AND '" . "$end_date" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $total_order = $command->queryAll();
        }

        return count($total_order);
    }

    public function GetPendingorder($start_date, $end_date) {
        //$start_date,$end_date
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
        $cDate = date("Y-m-d H:i:s", strtotime($start_date));
        $eDate = date("Y-m-d", strtotime($end_date));
        $cdate1 = $eDate . ' 11:59:00';
        $pendding_order = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(order_id) from order_header where status= '" . "pending" . "'";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$cDate" . "' AND '" . "$cdate1" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $pendding_order = $command->queryScalar();
        } else if (is_numeric($store_id)) {

            $sql = "select count(oh.order_id) from order_header oh left join order_line ol on ol.order_id=oh.order_id where ol.store_id='" . $store_id . "'and oh.status= '" . "pending" . "'";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (oh.created_date BETWEEN '" . "$start_date" . "' AND '" . "$end_date" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $pendding_order = $command->queryScalar();
        }
        return $pendding_order;
    }

    public function GetShippedOrder($start_date, $end_date) {
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
        $cDate = date("Y-m-d H:i:s", strtotime($start_date));
        $eDate = date("Y-m-d", strtotime($end_date));
        $cdate1 = $eDate . ' 11:59:00';
        $pendding_order = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(order_id) from order_header where status= '" . "shipped" . "'";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$cDate" . "' AND '" . "$cdate1" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $pendding_order = $command->queryScalar();
        } else if (is_numeric($store_id)) {
            $sql = "select count(oh.order_id) from order_header oh left join order_line ol on ol.order_id=oh.order_id where ol.store_id='" . $store_id . "'and oh.status= '" . "shipped" . "'";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$start_date" . "' AND '" . "$end_date" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $pendding_order = $command->queryScalar();
        }
        return $pendding_order;
    }

    public function GetCancelledorder($start_date, $end_date) {
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
         $cDate = date("Y-m-d H:i:s", strtotime($start_date));
        $eDate = date("Y-m-d", strtotime($end_date));
        $cdate1 = $eDate . ' 11:59:00';
        $pendding_order = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(order_id) from order_header where status= '" . "Cancelled" . "'";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$cDate" . "' AND '" . "$cdate1" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $pendding_order = $command->queryScalar();
        } else if (is_numeric($store_id)) {
            $sql = "select count(oh.order_id) from order_header oh left join order_line ol on ol.order_id=oh.order_id where ol.store_id='" . $store_id . "'and oh.status= '" . "Cancelled" . "'";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$start_date" . "' AND '" . "$end_date" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $pendding_order = $command->queryScalar();
        }
        return $pendding_order;
    }

    public function GetReturnorder($start_date, $end_date) {
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
        $cDate = date("Y-m-d H:i:s", strtotime($start_date));
        $eDate = date("Y-m-d", strtotime($end_date));
        $cdate1 = $eDate . ' 11:59:00';
        $pendding_order = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(order_id) from order_header where status= '" . "returned" . "'";
            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$cDate" . "' AND '" . "$cdate1" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $pendding_order = $command->queryScalar();
        } else if (is_numeric($store_id)) {
            $sql = "select count(oh.order_id) from order_header oh left join order_line ol on ol.order_id=oh.order_id where ol.store_id='" . $store_id . "'and oh.status= '" . "returned" . "'";

            if (!empty($start_date) && !empty($end_date)) {
                $sql = $sql . " and (created_date BETWEEN '" . "$start_date" . "' AND '" . "$end_date" . "')";
            }
            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command->execute();
            $pendding_order = $command->queryScalar();
        }
        return $pendding_order;
    }

}
