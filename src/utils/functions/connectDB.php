<?php
/**
 * Connexion à la base de données en mysqli
 */
$host = 'localhost'; // Hôte de la base de données
$bdd = 'u316799227_invoices'; // Nom de la base
$bdd_user = 'u316799227_compta'; // Nom d'utilisateur de la base de données
$bdd_password = 'comptaYvessofer1'; // Mot de passe de la base de données

// Connexion à la base de données
$conn = new mysqli($host, $bdd_user, $bdd_password, $bdd);

// Vérifier la connexion
if ($conn->connect_error) {
    echo "La connexion a échoué : " . $conn->connect_error;
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
