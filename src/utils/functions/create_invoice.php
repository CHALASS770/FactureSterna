<?php
ini_set('display_errors', 1);
session_start();
require_once(__DIR__ . '/../connectDB.php');
require_once(__DIR__ . '/../autoload.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $products = $_POST['products'];
    $customerFolder = null;
    
    $invoice = new Invoices($conn);
    $productsInvoice = new InvoiceProducts($conn);
    $productype = new Products($conn);

    // Calculer le total
    $total = 0;
    foreach ($products as $product) {
        $product_id = $product['product_id'];
        $quantity = $product['quantity'];
        $productInfos = $productype->getProduct($product_id);
        $total += ($quantity * $productInfos['price']);
    }
    $invoice_id = $invoice->createInvoice($client_id, $type, $status, $total);

    if (!empty($_FILES['pictures']['name'][0])) {
        // Dossier de destination des images
        $customerFolder = 'Invoice_' . $invoice_id;
        $uploadDir = __DIR__ . "/../../uploads/$customerFolder/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Crée le dossier si nécessaire
            echo "Dossier créé";
            //exit();
        }
        $uploadedFiles = [];
        $i=1;
        foreach ($_FILES['pictures']['tmp_name'] as $index => $tmpFilePath) {
            if ($_FILES['pictures']['error'][$index] === UPLOAD_ERR_OK) {
                $originalName = $_FILES['pictures']['name'][$index];
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $newFileName = "picture_check_invoice_$invoice_id". "_num_$i." . $extension; // Générer un nom unique
                $destinationPath = $uploadDir . $newFileName;
                if (move_uploaded_file($tmpFilePath, $destinationPath)) {
                    $uploadedFiles[] = $newFileName;
                    $i++;
                }
            }
        }
        $invoice->addPicturesFolder($invoice_id, $customerFolder);
    }


    // Insérer dans la table product_invoice
    foreach ($products as $product) {
        $product_id = $product['product_id'];
        $quantity = $product['quantity'];
        $productInfos = $productype->getProduct($product_id);
        $productsInvoice->addProductToInvoice($invoice_id, $product_id, $quantity, $productInfos['price']);
    }

    header("Location: /FactureSterna/index.php");
    exit();
}
?>
