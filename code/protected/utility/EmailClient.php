<?php
use Aws\Ses\SesClient;
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 23/8/16
 * Time: 12:47 PM
 */
require_once( dirname(__FILE__) . '/../extensions/aws/aws-autoloader.php');
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
                $files = glob($dir."*"); // get all file names
                foreach($files as $file){ // iterate files
                    if(is_file($file))
                    unlink($file); // delete file
                }
                $value = $mailArray['pdf'];
                $pdf = $value['pdf'];
                $name =$value['name'];
                $fullName = $dir.$name;
                $pdf->Output($fullName, 'F');
                //die;
                        //file_put_contents($fullName );
                $temp = array(
                    'name' => $name,
                    'filepath' => $fullName,
                    'mime' => 'application/pdf'
                    );
                $params['files'][0] = $temp;
            }
            try{
                $result = self::sendMail2($params);
                $messageId = $result->message_id;
                $resultText = $result->result_text;
                echo("Email sent! Message ID: $messageId"."\n");    
            } catch (Exception $e){
                throw $e;
        }
    }
}

public function sendMail2($params) {
       // die('here');
    $to = self::getParam($params, 'to', true);
    $subject = self::getParam($params, 'subject', true);
    $body = self::getParam($params, 'message', true);
    $from = self::getParam($params, 'from', true);
    $replyTo = self::getParam($params, 'replyTo');
    $files = self::getParam($params, 'files');
    $cc = self::getParam($params, 'cc');

    $res = new ResultHelper();

        // build the message
    if (is_array($to)) {
        $to_str = rtrim(implode(',', $to), ',');
    } else {
        $to_str = $to;
    }

        //make cc string

    $msg = "To: $to_str\n";
    if($cc){
        $msg .= "Cc: $cc\n";    
    }
    $msg .= "From: GROOTS<$from>\n";
    if ($replyTo) {
        $msg .= "Reply-To: $replyTo\n";
    }
    //$msg .= "From-Name: GROOTS\n";

        // in case you have funny characters in the subject
    $subject = mb_encode_mimeheader($subject, 'UTF-8');
    $msg .= "Subject: $subject\n";
    $msg .= "MIME-Version: 1.0\n";
    $msg .= "Content-Type: multipart/mixed;\n";
        $boundary = uniqid("_Part_".time(), true); //random unique string
        $boundary2 = uniqid("_Part2_".time(), true); //random unique string
        $msg .= " boundary=\"$boundary\"\n";
        $msg .= "\n";

        // now the actual body
        $msg .= "--$boundary\n";

        //since we are sending text and html emails with multiple attachments
        //we must use a combination of mixed and alternative boundaries
        //hence the use of boundary and boundary2
        $msg .= "Content-Type: multipart/alternative;\n";
        $msg .= " boundary=\"$boundary2\"\n";
        $msg .= "\n";
        $msg .= "--$boundary2\n";

        // first, the plain text
        $msg .= "Content-Type: text/plain; charset=utf-8\n";
        $msg .= "Content-Transfer-Encoding: 7bit\n";
        $msg .= "\n";
        $msg .= strip_tags($body); //remove any HTML tags
        $msg .= "\n";

        // now, the html text
        $msg .= "--$boundary2\n";
        $msg .= "Content-Type: text/html; charset=utf-8\n";
        $msg .= "Content-Transfer-Encoding: 7bit\n";
        $msg .= "\n";
        $msg .= $body; 
        $msg .= "\n";
        $msg .= "--$boundary2--\n";

        // add attachments
        if (is_array($files)) {
            $count = count($files);
            foreach ($files as $file) {
                $msg .= "\n";
                $msg .= "--$boundary\n";
                $msg .= "Content-Transfer-Encoding: base64\n";
                $clean_filename = Utility::clean_filename($file["name"], MAX_ATTACHMENT_NAME_LEN);
                $msg .= "Content-Type: {$file['mime']}; name=$clean_filename;\n";
                $msg .= "Content-Disposition: attachment; filename=$clean_filename;\n";
                $msg .= "\n";
                $msg .= base64_encode(file_get_contents($file['filepath']));
                $msg .= "\n--$boundary";
            }
            // close email
            $msg .= "--\n";
        }

        // now send the email out
        //var_dump($msg);die;
        try {
            $ses_result = $this->sesClient->sendRawEmail(
                array(
                    'RawMessage' => array(
                        'Data' => $msg
                        )
                    ), array(
                    'Source' => $from,
                    'Destinations' => $to_str
                    )
                    );
            if ($ses_result) {
                $res->message_id = $ses_result->get('MessageId');
            } else {
                $res->success = false;
                $res->result_text = "Amazon SES did not return a MessageId";
            }
        } catch (Exception $e) {
            $res->success = false;
            $res->result_text = $e->getMessage().
            " - To: $to_str, Sender: $from, Subject: $subject";
        }
        return $res;
    }

    private function getParam($params, $param, $required = false) {
        $value = isset($params[$param]) ? $params[$param] : null;
        if ($required && empty($value)) {
            throw new Exception('"'.$param.'" parameter is required.');
        } else {
            return $value;
        }
    }

}

class ResultHelper {

    public $success = true;
    public $result_text = "";
    public $message_id = "";

}