<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/utils/connectDB.php';
require_once __DIR__ . '/../src/utils/autoload.php';
use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$invoice_number = $_GET['id'] ?? null;

if (!$invoice_number) {
    die("ID manquant");
}

$invoice = new Invoices($conn);
$invoiceDetails = $invoice->getInvoiceByID($invoice_number);

$html = file_get_contents("http://localhost/FactureSterna/factures/invoice.php?id=$invoice_number&mail=1");
echo $html;


// Génération du PDF
// $dompdf = new Dompdf();
// $dompdf->loadHtml($html);
// $dompdf->setPaper('A4', 'portrait');
// $dompdf->render();

// $pdfContent = $dompdf->output();
$pdfPath = __DIR__ . "/invoices/".$invoiceDetails[0]['lastname']."_invoice_$invoice_number.pdf";
// file_put_contents($pdfPath, $pdfContent);

// Envoi d'e-mail
$mail = new PHPMailer(true);
try {
    $mail->setFrom('prolyspc@gmail.com', 'Mishpachton sheli');
    $mail->addAddress($invoiceDetails[0]['email'], $invoiceDetails[0]['customer_name']);
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->Subject = " החשבונית $invoice_number";
    $mail->Body = "אנא מצא את החשבונית שלך מצורפת.";
    $mail->addAttachment($pdfPath, $invoiceDetails[0]['lastname']."_invoice_$invoice_number.pdf");

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'prolyspc@gmail.com';
    $mail->Password = 'fqqn gjaj ymsy biti';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->send();
    unlink($pdfPath);
    echo "<script>alert('Facture envoyée avec succès !');</script>";
    header("Location: /FactureSterna/index.php");
} catch (Exception $e) {
    echo "<script>alert('Erreur lors l-envoi : {$mail->ErrorInfo}');</script>";
}