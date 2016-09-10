<?php
    // get the HTML
    ob_start();

    echo $this->renderPartial('reportviewcontent' ,array('model' => $model,
              'modelOrder' =>$modelOrder, 'retailer'=>$retailer, 'type'=>$type), true);//die;
    $content = ob_get_clean();
 
    // convert in PDF
//echo $content;
//die;
    require_once( dirname(__FILE__) . '/../../extensions/html2pdf/html2pdf.php');
    $title = "";
    if($type=="dc"){
        $title = "Delivery Challan Groots Admin Panel";
    }
    else{
        $title = "Invoice Order Groots Admin Panel";
    }
    $downloadFileName=$retailer->name." (".substr($modelOrder->delivery_date, 0, 10).").pdf";
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $html2pdf->pdf->SetTitle($title);
//      $html2pdf->setModeDebug();
      //  $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($downloadFileName);
        /*if($zip==true){
            return $html2pdf;
        }*/
        var_dump($html2pdf);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
