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

    public function getTotalLinesheet($start_date, $end_date) {
           $sql='';
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }
        $cDate = date("Y-m-d H:i:s", strtotime($start_date));
        $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
        $row = 0;
        if ($issuperadmin) {
            $sql = "select count(category_id) from category where 1=1";
        }
        if (!empty($start_date) && !empty($end_date)) {
            $sql = $sql . " and (created_date BETWEEN '" . "$cDate" . "' AND '" . "$cdate1" . "')";
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
            $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
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
        $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
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
        $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
        $pendding_order = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(order_id) from order_header where status= '" . "Confirmed" . "'";
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
        $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
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
        $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
        $pendding_order = 0;
        if ($issuperadmin == 1) {
            $sql = "select count(order_id) from order_header where status= '" . "Delivered" . "'";
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

    public static function downloadCSVByIDs($oDate) {

        $sqlchksubsid = "SELECT ol.product_name AS 'Product name',ol.grade AS 'Grade',ol.diameter AS Diameter,colour,round(sum(ol.product_qty * ol.pack_size)) as Quantity,ol.pack_unit as Unit,ol.weight AS 'Indicated Weight',ol.weight_unit AS 'Indicated Weight Unit',ol.length AS 'Indicated Length',ol.length_unit AS 'Indicated Length unit', oh.`delivery_date` AS 'Delivery date' FROM `order_header` `oh` LEFT JOIN order_line ol ON ol.`order_id`=oh .`order_id` WHERE oh.`delivery_date`='" . $oDate . "' AND oh.status !='Cancelled' group by ol.subscribed_product_id,ol.pack_unit";
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sqlchksubsid);
        $command->execute();
        $assocDataArray = $command->queryAll();
        $fileName = "OrderLis.csv";
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
