<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// Inclure le fichier connectDB.php
require_once(__DIR__ . '/src/utils/connectDB.php');
// Inclure le fichier autoload.php
require_once(__DIR__ . '/src/utils/autoload.php');
$user = new Users($conn); // $pdo est votre connexion PDO

//echo realpath("src/assets/js/dashboard.js");


// Vérifie si la session est valide
if (!$user->check_session()) {
    header("Location: login.php");
    exit();
}
$invoices = new Invoices($conn);
$allInvoices = $invoices->getAllInvoices();
?>
<script>
  var all_invoices = <?=json_encode($allInvoices); ?>;
</script>
<!doctype html>
<html lang="he-IL" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>החשבונות שלי</title>
  <link rel="shortcut icon" type="image/png" href="/src/assets/images/logos/LOGO.png" />
  <link rel="stylesheet" href="src/assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <!-- <aside class="left-sidebar">
      <!-- Sidebar scroll--
      <div>
        
          <div class="close-btn d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
      </aside> -->
      <!--  Sidebar End -->
      <!--  Main wrapper -->
      
      <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
         
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="src/assets/images/profile/Sterna.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">הפרופיל שלי</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">החשבון שלי</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">המשימות שלי</p>
                    </a>
                    <a href="./login.php" class="btn btn-outline-primary mx-3 mt-2 d-block">התנתק</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
      <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.php" class="text-nowrap logo-img">
            <img src="src/assets/images/logos/LOGO1.png" width="180" alt="" />
          </a>
          </div>
        <?php include('src/assets/menu/menu.php'); ?>
        <!--  Row 1 -->
        <!-- <div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Sales Overview</h5>
                  </div>
                  <div>
                    <select class="form-select">
                      <option value="1">March 2023</option>
                      <option value="2">April 2023</option>
                      <option value="3">May 2023</option>
                      <option value="4">June 2023</option>
                    </select>
                  </div>
                </div>
                <div id="chart"></div>
              </div>
            </div>
          </div>
        </div> -->
          <div class="d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">החשבוניות והצעות המחיר שלי</h5>
                <div class="table-responsive">
                  <table id="invoices_table"  data-search="true" data-pagination="true" data-sortable="true">
                    <thead>
                      <tr>
                        <th data-field="invoice_number">מספר</th>
                        <th data-field="type">סוּג</th>
                        <th data-field="customer_name">לקוח</th>
                        <th data-field="total">סְכוּם</th>
                        <th data-field="updated_at">תאריך</th>
                        <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvent"></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-6 px-6 text-center">
    <p class="mb-0 fs-4">Developed by ProlysPC</p>
  </div>
  <?php $version = rand(1,10);?>
  <script src="src/assets/libs/jquery/dist/jquery.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/js/sidebarmenu.js?v=<?=$version?>" ></script>
  <script src="src/assets/js/app.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/apexcharts/dist/apexcharts.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/simplebar/dist/simplebar.js?v=<?=$version?>" ></script>
  <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/locale/bootstrap-table-fr-FR.min.js"></script>
  <script src="src/assets/js/dashboard.js?v=<?=$version?>" ></script>
</body>

</html>