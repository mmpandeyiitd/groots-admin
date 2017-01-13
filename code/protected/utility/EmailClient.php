<?php
use Aws\Ses\SesClient;
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 23/8/16
 * Time: 12:47 PM
 */
require_once( dirname(__FILE__) . '/../extensions/aws/aws-autoloader.php');
require_once( dirname(__FILE__).'/SESUtils.php');
class EmailClient
{

    public $sesClient;

    public function __construct() {

        $this->sesClient = SesClient::factory(array(
            'version'=> 'latest',
            'region' => REGION,
            'credentials' => array(
                'key' => AWS_KEY,
                'secret'  => AWS_SECRET_KEY,
                )

        )); //Change this to instantiate the module you want. Look at the documentation to find out what parameters you need.

    }

    public function sendMail($mailArray){

        $subject = $mailArray['subject'];
        $text = $mailArray['text'];
        $html = $mailArray['html'];

        $i = 0;
        $recepientArr = array();
        foreach ($mailArray['to'] as $to)
        {
            if($to['email']=="grootsadmin@gmail.com")
            {
                continue;
            }
            if ($i == 0)
            {
                $params['to']        = $to['email'];
                //   $params['toname']    = $to['name'];
                $recepientArr[] = $to['email'];
            }
            else
            {
                $recepientArr[] = $to['email'];
            }
            $i++;
        }


        /*foreach ($recepientArr as $to){
            $client->verifyEmailIdentity(['EmailAddress'=>$to]);
        }*/

        $request = array();
        $request['Source'] = EMAIL_SENDER;
        $request['Destination']['ToAddresses'] = $recepientArr;
        $request['Message']['Subject']['Data'] = $subject;
        $request['Message']['Body']['Html']['Data'] = $html;

        try {
            $result = $this->sesClient->sendEmail($request);
            $messageId = $result->get('MessageId');
            echo("Email sent! Message ID: $messageId"."\n");

        } catch (Exception $e) {
            echo("The email was not sent. Error message: ");
            echo($e->getMessage()."\n");
        }
    }

    public function verifyEmailToSes(){
        $connection = Yii::app()->db;
        $sql = "SELECT email FROM `retailer` ";
        $command = $connection->createCommand($sql);
        $command->execute();
        $emails = $command->queryAll();
        foreach ($emails as $email){
            $this->sesClient->verifyEmailIdentity(['EmailAddress'=>$email['email']]);
        }
    }


    public function sendEmailWithInvoices($mailArrays){
        //var_dump($mailArrays);die;
        foreach ($mailArrays as $key => $mailArray) {
            $subject = $mailArray['subject'];
            $text = $mailArray['text'];
            $html = $mailArray['html'];
            $params = array();
            $params['to'] = $mailArray['to'];
            $params['subject'] = $subject;
            $params['message'] = $html;
            $params['from'] = $mailArray['from'];
            $params['cc'] = $mailArray['cc'];
            $params['replyTo'] = $mailArray['replyTo'];

            if(isset($mailArray['pdf']) && !empty($mailArray['pdf'])){
                $params['files'] = array();
                $dir = dirname(__FILE__) . '/../../../../dump/';
                $value = $mailArray['pdf'];
                $pdf = $value['pdf'];
                $name =$value['name'];
                $fullName = $dir.$name;
                file_put_contents($fullName, $pdf);
                $temp = array(
                    'name' => $name,
                    'filepath' => $fullName,
                    'mime' => 'application/pdf'
                    );
                $params['files'][0] = $temp;
            }
            try{
                $result = SESUtils::sendMail($params);
                $messageId = $result->message_id;
                $resultText = $result->result_text;
                echo("Email sent! Message ID: $messageId"."\n");    
            } catch (Exception $e){
                throw $e;
            }


        }
    }

}