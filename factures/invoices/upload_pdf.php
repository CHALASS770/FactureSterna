<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (isset($_FILES['file']) && isset($_POST['id'])) {
    echo "<script>alert('Fichier et ID reçus.');</script>";
    // Vérifier si le fichier est un PDF
    $invoiceId = intval($_POST['id']);
    $uploadDir = __DIR__ . '/'; // Dossier invoices/
    $filename = basename($_FILES['file']['name']);
    $filePath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        echo "PDF enregistré avec succès dans /invoices/";
    } else {
        http_response_code(500);
        echo "Échec de l’enregistrement du fichier.";
    }
} else {
    http_response_code(400);
    echo "Fichier ou ID manquant.";
}
