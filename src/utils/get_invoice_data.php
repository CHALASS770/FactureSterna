<?php
ini_set('display_errors', 1);
header('Content-Type: application/json');
require_once(__DIR__ . '/connectDB.php'); // Connexion à la base de données
require_once(__DIR__ . '/autoload.php'); // Classe Invoices

$invoices = new Invoices($conn);

// Obtenir le mois actuel (ou passer un paramètre ?month=MM dans l'URL)
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
//cho $month;
// Récupérer les données des factures et devis
$data = $invoices->getInvoiceByMonth($month);

// Vérifier les erreurs
if ($data === false) {
    echo json_encode(['error' => 'Aucune donnée trouvée pour ce mois.']);
    exit();
}

// Retourner les données JSON
echo json_encode($data);
$conn->close();
