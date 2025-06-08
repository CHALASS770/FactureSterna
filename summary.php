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
$year = $_GET['year'] ?? date('Y'); // Récupère l'année actuelle
$invoices = new Invoices($conn);
$allInvoices = $invoices->getAllInvoices($year);
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@highlightjs/cdn-assets@11.9.0/styles/default.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/hint.css@2.6.0/hint.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table.min.css">
  <link rel="stylesheet" href="src/assets/css/styles.min.css" />
  
<!-- Font Awesome or Bootstrap Icons if needed -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <style>
  /* Corrige l'ordre de la toolbar Bootstrap Table dans un site RTL */
  #toolbar, .fixed-table-toolbar .btn-group,
  .fixed-table-toolbar .columns, .fixed-table-toolbar .export {
    direction: ltr !important;
    text-align: left !important;
  }
  </style>
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
        <?php include('src/assets/menu/header.php'); ?>
      <!--  Header End -->
      <div class="container-fluid">
      <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.php" class="text-nowrap logo-img">
            <img src="src/assets/images/logos/LOGO1.png" width="180" alt="" />
          </a>
          </div>
        <?php //include('src/assets/menu/menu.php'); ?>
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
        </div>
        <div class="buttons-toolbar" id="toolbar"></div>
        <div class="d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">החשבוניות והצעות המחיר שלי</h5>
                <div class="table-responsive">
                  <table id="invoices_table"
                      data-toolbar="#toolbar"
                        data-buttons-prefix="btn-sm btn"
                      data-show-toggle="false"
                      data-show-export="true"
                      data-show-columns="true"
                      data-search="false"
                      data-pagination="false"
                      data-buttons-class="secondary"
                      data-sortable="true"
                      data-show-footer="true"
                      data-buttons-align="right"
                      data-export-types='["xlsx"]'
                      data-export-filename="Summary_Invoices-Sterna-Assouline_<?php echo date('Y'); ?>"
                      data-export-options='{"fileName": "Summary_Invoices-Sterna-Assouline_<?php echo date('Y'); ?>"}'
                      >
                      <thead>
                        <tr>
                          <th data-field="invoice_number" data-footer-formatter='totalTextFormatter'>מספר</th>
                          <!-- <th data-field="type">סוּג</th> -->
                          <th data-field="customer_name">לקוח</th>
                          <th data-field="total" data-footer-formatter='totalPriceFormatter'>סְכוּם</th>
                          <th data-field="payement_date" data-footer-formatter='yearFormatter' >תאריך</th>
                          <!-- <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvent"></th> -->
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
  <div class="py-6 px-6 text-center">
    <p class="mb-0 fs-4">Developed by ProlysPC</p>
  </div>
  <?php $version = rand(1,10);?>
  <script src="src/assets/libs/jquery/dist/jquery.min.js?v=<?=$version?>" ></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sprintf-js@1.1.3/dist/sprintf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@highlightjs/cdn-assets@11.9.0/highlight.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/marked@3.0.8/marked.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flexibility@2.0.1/flexibility.min.js"></script>
  <script src="src/assets/js/sidebarmenu.js?v=<?=$version?>" ></script>
  <script src="src/assets/js/app.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/apexcharts/dist/apexcharts.min.js?v=<?=$version?>" ></script>
  <script src="src/assets/libs/simplebar/dist/simplebar.js?v=<?=$version?>" ></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/extensions/export/bootstrap-table-export.min.js"></script>
<!-- SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


  <script src="src/assets/js/summary.js?v=<?=$version?>" ></script>
</body>

</html>