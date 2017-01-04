<?php
use Aws\Ses\SesClient;
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 23/8/16
 * Time: 12:47 PM
 */
class Utility
{
    public static function getDefaultDeliveryDate(){
        $time=strtotime("+12 hour");
        return date("Y-m-d",$time);
    }

    public static function get_enum_values($connection, $table, $field )
    {
        $enums = array();
        $sql = "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}' ";

        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        //var_dump($result);die;
        $type = $result[0]['Type'];
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);

        $enumArray = explode("','", $matches[1]);
        foreach($enumArray as $enum){
            $a = array();
            $a["value"] = $enum;
            array_push($enums, $a);
        }
        //var_dump($enums);die;
        return $enums;
    }

    public static function array_sort($array, $on, $order=SORT_ASC){

        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public static function convertOrderToKg($qty, $pack_size, $pack_unit ){
        $quantityInKg = '';
        if ($pack_unit == 'g') {
            $quantityInKg = $qty * ((int)$pack_size)/1000;
        }
        else {
            $quantityInKg = $qty * ((int)$pack_size);
        }
        return $quantityInKg;
    }

    public static function converOrderToUnit(){

    }

    public static function loginCheck($controller){
        if($controller->checkAccess('registered')){
            return true;
        }
        else{
            Yii::app()->controller->redirect("index.php?r=user/login");
        }
    }

    public static function getUserAuthItemsArrFromSession(){
        $authItems = Yii::app()->session['auth_items'];
        return explode(',', $authItems);
    }

    public static function getPrevDay($date){
        $time = strtotime($date.' -1 days');
        return date("Y-m-d", $time);
    }

    public static function sgSendMail($mailArray)
    {
        // echo 'here2';
      //echo $email.$pass;die;
        // $url  = 'http://sendgrid.com/';
    $url  = SG_URL;
    $user = SG_USER;
    $pass = SG_PASS;

    $params             = array();
    $params['api_user'] = $user;
    $params['api_key']  = $pass;
    $i                  = 0;
    $json_string        = array();
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
            $json_string['to'][] = $to['email'];
        }
        else
        {
            $json_string['to'][] = $to['email'];
        }
        $i++;
    }


    $params['from'] = $mailArray['from'];

    if ($mailArray['fromname'] && $mailArray['fromname'] != '')
    {
        $params['fromname'] = $mailArray['fromname'];
    }

    $params['subject'] = $mailArray['subject'];

    if ($mailArray['html'] && $mailArray['html'] != '')
    {
        $params['html'] = $mailArray['html'];
    }

    if ($mailArray['text'] && $mailArray['text'] != '')
    {
        $params['text'] = $mailArray['text'];
    }

    if ($mailArray['replyto'] && $mailArray['replyto'] != '')
    {
        $params['replyto'] = $mailArray['replyto'];
    }

    if (isset($mailArray['files']))
    {
        foreach ($mailArray['files'] as $file)
        {
            $params['files[' . $file['name'] . ']'] = '@' . $file['path'];
        }
    }

    $params['x-smtpapi'] = json_encode($json_string);
    $request             = $url . 'api/mail.send.json';
    // Generate curl request
    $session             = curl_init($request);
    // Tell curl to use HTTP POST
    curl_setopt($session, CURLOPT_POST, true);
    // Tell curl that this is the body of the POST
    curl_setopt($session, CURLOPT_POSTFIELDS, $params);
    // Tell curl not to return headers, but do return the response
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

    // obtain response
    $response = curl_exec($session);
    curl_close($session);

    // print everything out
    return $response;
       
    }

    public function getWarehouseNameById($w_id){
        $sql = 'select name from cb_dev_groots.warehouses where id = '.$w_id.' limit 1';
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $name = $command->queryAll();
        return $name[0]['name'];
    } 

	public function getWarehouseDropdownData(){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select id , name from cb_dev_groots.warehouses';
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        $array = array();
        foreach ($data as $key => $value) {
            $array[$value['id']] = $value['name'];
        }
        return $array;
    }

    public function calTotPayAmoByRetailer($retailerId){
        $retailerOrders = OrderHeader::model()->findAllByAttributes(array('user_id'=>$retailerId ),array('select'=>'total_payable_amount','condition'=>'status = "Delivered" and delivery_date >= "2016-09-01"' ,'order'=> 'delivery_date ASC'));
        $retailerPayments = RetailerPayment::model()->findAllByAttributes(array('retailer_id'=>$retailerId), array('select'=>'paid_amount', 'condition'=>'status != 0 and date >= "2016-09-01"', 'order'=> 'date ASC'));
        $outstanding = Retailer::getInitialPayableAmount($retailerId);
        foreach ($retailerOrders as $key => $value) {
            $outstanding += $value['total_payable_amount'];
        }
        foreach ($retailerPayments as $key => $value) {
            $outstanding -= $value['paid_amount'];
        }
        return $outstanding;
    }

    public function calLastPayAmoByRetailer($retailerId){
        $outstanding = Retailer::getInitialPayableAmount($retailerId);
        $last_due_date = Retailer::getLastDueDate($retailerId);
        $retailerOrders = OrderHeader::model()->findAllByAttributes(array('user_id'=>$retailerId ),array('select'=>'total_payable_amount','condition'=>'status = "Delivered" and delivery_date >= "2016-09-01" and delivery_date <= "'.$last_due_date.'"' ,'order'=> 'delivery_date ASC'));
        $retailerPayments = RetailerPayment::model()->findAllByAttributes(array('retailer_id'=>$retailerId), array('select'=>'paid_amount', 'condition'=>'status != 0 and date >= "2016-09-01" and date <= "'.$last_due_date.'"', 'order'=> 'date ASC'));
        foreach ($retailerOrders as $key => $value) {
            $outstanding += $value['total_payable_amount'];
        }
        foreach ($retailerPayments as $key => $value) {
            $outstanding -= $value['paid_amount'];
        }
        return $outstanding;
    }

    public static function sendMailSes($mailArray){
        require_once( dirname(__FILE__) . '/../extensions/aws/aws-autoloader.php');


        //$from = $mailArray['from'];
        //$replyto = $mailArray['replyto'];
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


        $client = SesClient::factory(array(
            'version'=> 'latest',
            'region' => REGION,
            'credentials' => array(
                'key' => AWS_KEY,
                'secret'  => AWS_SECRET_KEY,
            )

        ));


        /*foreach ($recepientArr as $to){
            $client->verifyEmailIdentity(['EmailAddress'=>$to]);
        }*/

        $request = array();
        $request['Source'] = EMAIL_SENDER;
        $request['Destination']['ToAddresses'] = $recepientArr;
        $request['Message']['Subject']['Data'] = $subject;
        $request['Message']['Body']['Html']['Data'] = $html;

        try {
            $result = $client->sendEmail($request);
            $messageId = $result->get('MessageId');
            echo("Email sent! Message ID: $messageId"."\n"); 

        } catch (Exception $e) {
            echo("The email was not sent. Error message: ");
            echo($e->getMessage()."\n");
        }

    }

    public static function verifyEmailToSes(){
        require_once( dirname(__FILE__) . '/../extensions/aws/aws-autoloader.php');
        $client = SesClient::factory(array(
            'version'=> 'latest',
            'region' => REGION,
            'credentials' => array(
                'key' => AWS_KEY,
                'secret'  => AWS_SECRET_KEY,
            )

        ));
        $connection = Yii::app()->db;
        $sql = "SELECT email FROM `order_line` ol join cb_dev_groots.retailer ";
        $command = $connection->createCommand($sql);
        $command->execute();
        $emails = $command->queryAll();
        foreach ($emails as $email){
            $client->verifyEmailIdentity(['EmailAddress'=>$email]);
        }
    }

    public function avgFiveRatingMap(){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select user_id, avg(order_rating) as rating from(select user_id, order_rating from order_header oh where( select count(*) from order_header as oh1 where oh1.user_id = oh.user_id and oh1.order_rating is not null and oh1.status="Delivered" and oh1.order_id >= oh.order_id )<= 5  and oh.order_rating is not null and oh.status="Delivered") as t group by user_id';
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        $map = array();
        foreach ($result as $key => $value) {
            $map[$value['user_id']] = round($value['rating'],2);            
        }
        return $map;
    }


}
