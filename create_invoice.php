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

$clients = new Clients($conn);
$customers = $clients->getAllClients();
$year = date("Y");
$products = new Products($conn); // Supposons qu'il existe une classe pour les produits
$productList = $products->getAllProducts();
?>
<script>
  let productList = <?php echo json_encode($productList); ?>;
</script>
<!doctype html>
<html lang="he-IL" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>צור חשבונית חדשה</title>
  <link rel="stylesheet" href="src/assets/css/styles.min.css" />
  <script src="src/assets/libs/jquery/dist/jquery.min.js"></script>
</head>

<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
data-sidebar-position="fixed" data-header-position="fixed">
    <div class="body-wrapper">
        <?php include('src/assets/menu/header.php'); ?>
    </div>
</div>
  <div class="page-wrapper">
  <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.php" class="text-nowrap logo-img">
            <img src="src/assets/images/logos/LOGO1.png" width="180" alt="" />
          </a>
          </div>
        <?php include('src/assets/menu/menu.php'); ?>
    <div class="container">
      <h1 style="text-align:center">צור חשבונית חדשה</h1>
      <form class="col-sm-5 mx-auto" action="src/utils/functions/create_invoice.php" method="POST" enctype="multipart/form-data">
        <!-- Sélection du client -->
        <div class="mb-3">
          <label for="client" class="form-label">לקוח</label>
          <select class="form-select" id="client" name="client_id" required>
            <option value="" disabled selected>בחר לקוח</option>
            <?php foreach ($customers as $client) : ?>
              <option value="<?php echo $client['id']; ?>">
                <?php echo $client['firstname'] . ' ' . $client['lastname']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Type de facture -->
        <div class="mb-3">
          <label for="type" class="form-label">סוג</label>
          <select class="form-select" id="type" name="type" required>
            <option value="facture">חשבונית</option>
            <option value="devis">לְהַעֲרִיך</option>
          </select>
        </div>

        <!-- Statut -->
        <div class="mb-3">
          <label for="status" class="form-label">מצב</label>
          <select class="form-select" id="status" name="status" required>
            <option value="en attente">בהמתנה</option>
            <option value="payé">שולם</option>
            <option value="annulé">בוטלה</option>
          </select>
        </div>

        <!-- Date -->
        <div class="mb-3 d-none" id="payement-date-container">
          <label for="payement-date" class="form-label">תאריך התשלום</label>
          <input type="date" class="form-control" id="payement-date" name="payement-date" >
        </div>

        <!-- Produits -->
        <div id="products-container">
          <h3>מוצרים</h3>
          <div class="product-row mb-3">
            <div class="row">
              <div class="col-md-6">
                <label for="product_0" class="form-label">מוצר</label>
                <select class="form-select" name="products[0][product_id]" id="product_0" required>
                  <option value="" disabled selected>בחר מוצר</option>
                  <?php foreach ($productList as $product) : ?>
                    <option value="<?php echo $product['id']; ?>">
                      <?php echo $product['product']; ?> (<?php echo $product['price']; ?> ₪/היחידה)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-3">
                <label for="quantity_0" class="form-label">כמות</label>
                <input type="number" class="form-control" name="products[0][quantity]" id="quantity_0" min="1" required>
              </div>
              <br>

                <label for="discount" class="form-label mt-5 mb-5 ms-8" style="font-size: 20px;">הנחה
                <input type="checkbox" class="form-check-input me-3" id="discount_0" name="discount_0" value="8.3333">
                </label>
            </div>
          </div>
        </div>
        <button type="button" id="add-product" class="btn btn-primary mt-3 mb-5 ms-6 ">הוסף מוצר</button>
        
        <button type="submit" class="btn btn-success mt-3 mb-5 ms-6 ">צור את החשבונית</button>
        
          <button type="button" class="btn btn-danger mt-3 mb-5 ms-6  remove-product">למחוק</button>
        
        <!-- add picture -->
        <!-- <div id="products-container">
          <h3>Images</h3>
          <div class="product-row mb-3">
            <div class="row">
              <div class="col-md-6">
                  <!--create upload multiple files pictures format (jpg,png,JPEG, etc...)
                <label for="pictures" class="form-label">Images</label>
                <input type="file" class="form-control" name="pictures[]" id="pictures" multiple>

              </div>
              
            </div>
          </div>
        </div> -->

        <!-- Soumettre -->
      </form>
    </div>
  </div>
  <?php $version = rand(1,10);?>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/locale/bootstrap-table-fr-FR.min.js"></script>
<script type="text/javascript"></script>

<script src="src/assets/js/create_invoices.js?v=<?=$version?>" ></script>
<script src="src/assets/libs/jquery/dist/jquery.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/js/sidebarmenu.js?v=<?=$version?>" ></script>
  <script src="src/assets/js/app.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/apexcharts/dist/apexcharts.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/simplebar/dist/simplebar.js?v=<?=$version?>" ></script>

  <script src="src/assets/js/dashboard.js?v=<?=$version?>" ></script>

</body>
</html>