<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
require_once( dirname(__FILE__) . '/../extensions/aws/aws-autoloader.php');
require_once(dirname(__FILE__).'/../config/aws-config.php');

class StotageClient{
    public $s3Client;
    public function __construct(){
        echo '<pre>';
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

    public function addFile($bucket){
        try{
            $client = $this->s3Client;
            echo '<pre>';
            $result = $this->s3Client->listBuckets();

//            foreach ($result['Buckets'] as $bucket) {
//                // Each Bucket value will contain a Name and CreationDate
//                echo "{$bucket['Name']} - {$bucket['CreationDate']}\n";
//            }

            //var_dump($buckets);die;
        }catch (S3Exception $e){
            echo $e->getMessage();
        }
    }
}
?>