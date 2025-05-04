<?php
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

// Générez le HTML de la facture (ou incluez invoice.php dans une variable)
ob_start();
include('invoice_pdf_template.php'); // version simplifiée sans JS
$html = ob_get_clean();

// Génération du PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$pdfContent = $dompdf->output();
$pdfPath = __DIR__ . "/temp_invoice_$invoice_number.pdf";
file_put_contents($pdfPath, $pdfContent);

// Envoi d'e-mail
$mail = new PHPMailer(true);
try {
    $mail->setFrom('@gmail.com', 'Ton Nom');
    $mail->addAddress($invoiceDetails[0]['email'], $invoiceDetails[0]['customer_name']);
    $mail->Subject = "החשבונית שלך מספר $invoice_number";
    $mail->Body = "Veuillez trouver ci-joint votre facture.";
    $mail->addAttachment($pdfPath, "$invoiceDetails[0]['customer_name']_invoice_$invoice_number.pdf");

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'prolypc@gmail.com';
    $mail->Password = 'familleassouline';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->send();
    unlink($pdfPath);
    alert( "Facture envoyée avec succès.");
} catch (Exception $e) {
    alert( "Erreur lors de l'envoi : {$mail->ErrorInfo}");
}
