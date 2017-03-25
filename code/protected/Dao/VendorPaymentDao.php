<?php

class VendorPaymentDao{

    public function downloadPaymentReport($startDate, $endDate){
        $sql = 'select vp.id,v.bussiness_name,CASE WHEN vp.status = 1 THEN "Active"
                          WHEN vp.status != 1 THEN "Inactive"
                          END as "status", vp.paid_amount, vp.date, vp.payment_type, CASE 
                      WHEN vp.payment_type = "Cheque" THEN vp.cheque_no
                      WHEN vp.payment_type != "Cheque" THEN ""
                      END as Cheque_no
                      ,
                      CASE WHEN vp.payment_type = "Cheque" THEN vp.cheque_status
                      WHEN vp.payment_type != "Cheque" then ""
                      END as Cheque_status
                      , v.bussiness_name from groots_orders.vendor_payments as vp left join vendors as v on v.id = vp.vendor_id where vp.date BETWEEN "'.$startDate.'" and "'.$endDate.'"';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $dataArray = $command->queryAll();
        //echo '<pre>';
        //var_dump($result);die;
        $fileName = 'VendorPaymert'.$endDate.'.csv';
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);

        if (isset($dataArray['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($dataArray['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($dataArray AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }

}
?>