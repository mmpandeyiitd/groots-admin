<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
require_once( dirname(__FILE__) . '/../extensions/aws/aws-autoloader.php');
require_once(dirname(__FILE__).'/../config/aws-config.php');

class StotageClient{
    public $s3Client;
    public function __construct(){
        $this->s3Client = S3Client::factory(array(
            'version' => 'latest',
            'region' => REGION,
            'credentials' => array(
                'key'    => AWS_KEY,
                'secret' => AWS_SECRET_KEY,

            )

        ));
        //var_dump($this->s3Client);die;
    }

    public function addFile($bucket,$fileName,$filePath){
        try{
            $client = $this->s3Client;
            if(!$this->isBucketPresent($bucket)){
                $this->s3Client->createBucket(array('Bucket' => md5($bucket)));
                $this->s3Client->waitUntil('BucketExists', array('Bucket' => md5($bucket)));
            }
            $result = $this->s3Client->putObject(array(
                'Bucket' => md5($bucket),
                'Key' => $fileName,
                'SourceFile' => $filePath,
                'ACL'        => 'public-read'
            ));
            $this->s3Client->waitUntil('ObjectExists', array(
                'Bucket' => md5($bucket),
                'Key'    => $fileName
            ));
//            $result = $this->s3Client->getObject(array(
//                'Bucket' => md5($bucket),
//                'Key' => $fileName,
//            ));
            return $result;
            //$signedUrl = $client->getObjectUrl(md5($bucket),$fileName, '+10 minutes');
            //echo $result['@metadata']['effectiveUri'];
        }catch (S3Exception $e){
            echo $e->getMessage();
        }
    }

    public function isBucketPresent($bucket){

        $client = $this->s3Client;
        $result = $this->s3Client->listBuckets();
        foreach ($result['Buckets'] as $currentBucket){
            if($currentBucket['Name'] == md5($bucket))
                return true;
        }
        return false;
    }

}
?>