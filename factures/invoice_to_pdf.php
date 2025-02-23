<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require __DIR__.'/../vendor/autoload.php'; // Charge Dompdf via Composer

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialiser Dompdf avec les options    
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);

// Vérifie si un ID de facture est passé en paramètre
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Récupérer l'ID de la facture
    
    // Générer le contenu HTML de la facture sans les boutons
    ob_start(); // Commencer à capturer la sortie
    $path = 'invoice_template.php';
    // echo $path;
   
    // Vérifiez si le modèle existe avant de l'inclure
    if (file_exists($path)) {
        include $path; // Inclure le template pour le devis
    } else {
        echo "ERROR: Template file not found.";
        exit();
    }

    $html = ob_get_clean(); // Obtenir le contenu capturé
    $filePath = 'debug.html';
    $file = fopen($filePath, 'w'); // 'w' pour écriture

    if ($file) {
        fwrite($file, $html); // Écrire des données dans le fichier
        fclose($file); // Fermer le fichier
    } else {
        echo "Impossible d'ouvrir le fichier pour écriture.";
    }
    // exit();
    // Charger le HTML dans Dompdf
    $dompdf->loadHtml($html);
 
    // Définir la taille et l'orientation de la page
    $dompdf->setPaper('A4', 'portrait');
    
    // Générer le PDF
    $dompdf->render();
    //afficher le rendu
    // echo $dompdf->output();
    // exit();
    // Afficher le PDF
    $dompdf->stream("facture.pdf", ["Attachment" => true]);
} else {
    echo "ERROR: Invoice ID not found";
    exit();
}
?>
