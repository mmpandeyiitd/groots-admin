<?php
// get the HTML
ob_start();
$pdfdata = $this->renderPartial('reportviewcontent', array('model' => $model,
    'modelOrder' => $modelOrder, 'status' => $status, 'email' => $email,'store_model'=> $store_model,), true);
$content = $pdfdata;

// convert in PDF
require_once( dirname(__FILE__) . '/../../extensions/html2pdf/html2pdf.php');
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'en');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('feeds/order_csv/order_' . $modelOrder->attributes['order_id'] . '.pdf', 'F');

} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
