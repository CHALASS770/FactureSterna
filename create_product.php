<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once(__DIR__ . '/src/utils/connectDB.php');
require_once(__DIR__ . '/src/utils/autoload.php');

$user = new Users($conn);

if (!$user->check_session()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $unitPrice = $_POST['unit_price'];

    $products = new Products($conn);
    $result = $products->createProduct($productName, $description, $unitPrice);

    if ($result) {
        echo "<script>alert('Produit créé avec succès !'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Une erreur est survenue lors de la création du produit.');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Créer un nouveau produit</title>
  <link rel="stylesheet" href="src/assets/css/styles.min.css" />
</head>
<body>
<div class="container">
    <h1>Créer un nouveau produit</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="product_name" class="form-label">Nom du produit</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="unit_price" class="form-label">Prix unitaire (€)</label>
            <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-success">Créer le produit</button>
    </form>
</div>
</body>
</html>
