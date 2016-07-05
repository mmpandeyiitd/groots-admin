<?php
    // get the HTML
    ob_start();
    echo $this->renderPartial('reportviewcontent' ,array('model' => $model,
              'modelOrder' =>$modelOrder,), true);//die;
    $content = ob_get_clean();
 
    // convert in PDF
  
    require_once( dirname(__FILE__) . '/../../extensions/html2pdf/html2pdf.php');
    
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $html2pdf->pdf->SetTitle('Invoice Order Groots Admin Panel'); 
//      $html2pdf->setModeDebug();
      //  $html2pdf->setDefaultFont('Arial');
    
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output("abc.pdf");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
