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
$year = date("Y");
?>
<!doctype html>
<html lang="he-IL" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>צור מוצר חדש</title>
  <link rel="stylesheet" href="src/assets/css/styles.min.css" />
</head>
<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
data-sidebar-position="fixed" data-header-position="fixed">
    <div class="body-wrapper">
        <?php include('src/assets/menu/header.php'); ?>
    </div>
</div>
<div class="container">
<div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.php" class="text-nowrap logo-img">
            <img src="src/assets/images/logos/LOGO1.png" width="180" alt="" />
          </a>
          </div>
          <?php include('src/assets/menu/menu.php'); ?>
          <div class="d-flex flex-column justify-content-center align-items-center ">    
    <h1>צור מוצר חדש</h1>
    <form method="POST" style="width: 600px; ">
        <div class="mb-3">
            <label for="product_name" class="form-label">שם המוצר</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">תיאור המוצר</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="unit_price" class="form-label">מחיר ליחידה (₪)</label>
            <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-success">צור את המוצר</button>
    </form>
    </div>
</div>
<?php $version = rand(1,10);?>
  <script src="src/assets/libs/jquery/dist/jquery.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/js/sidebarmenu.js?v=<?=$version?>" ></script>
  <script src="src/assets/js/app.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/apexcharts/dist/apexcharts.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/simplebar/dist/simplebar.js?v=<?=$version?>" ></script>

  <script src="src/assets/js/dashboard.js?v=<?=$version?>" ></script>
</body>

</html>
