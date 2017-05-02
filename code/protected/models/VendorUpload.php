<?php

class VendorUpload extends CActiveRecord{

    public function tableName(){
        return 'vendor_upload';
    }

    public function rules(){
        return array(
            array('vendor_id, bucket, file_name, file_size, file_link, file_type, date, status,created_at, updated_by', 'required'),
            array('vendor_id, file_size, updated_by,status','numerical'),
            array('bucket', 'length','max' => 100),
            array('file_name', 'length','max' => 300),
            array('file_link', 'length','max' => 500),
            array('file_type', 'length','max' => 10),
            array('id,vendor_id,bucket,file_name,file_size,file_link,file_type,date,status,created_at,updated_at,update_by','safe','on'=>'search')
,        );
    }

    public function attributeLabels(){
        return array(
            'id' => 'ID',
            'vendor_id' => 'Vendor Id',
            'bucket' => 'Bucket Name',
            'file_name' => 'File Name',
            'file_size' => 'File Size',
            'file_link' => 'File Link',
            'file_type' => 'File Type',
            'date' => 'Date',
            'status' => 'Status',
            'created_at'=> 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        );
    }

    public function search(){
        $criteria = new CDbCriteria();


    }
}
?>