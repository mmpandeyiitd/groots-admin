<?php
class VendorUploadDao{

    public function deleteS3UploadedFile($toBeDeleted){
        require_once(dirname(__FILE__) . '/../utility/StorageClient.php');
        $s3 = new StotageClient();
        $ids = array();
        foreach ($toBeDeleted as $value){
            array_push($ids, $value['id']);
            try{
                $result = $s3->deleteFile(VENDOR_UPLOAD_BUCKET, $value['key']);
                VendorUpload::model()->deleteByPk($value['id']);
            } catch (Exception $e){
                return $e;
            }
        }
    }
}
?>