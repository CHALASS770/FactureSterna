<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure le fichier connectDB.php
require_once(__DIR__ . '/../utils/connectDB.php');
// Inclure le fichier autoload.php
require_once(__DIR__ . '/../utils/autoload.php');
$user = new Users($conn); // $pdo est votre connexion PDO

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $invoice = new Invoices($conn);
    $invoiceDetails = $invoice->getInvoiceByID($id);
    setlocale(LC_TIME, 'fr_FR.UTF-8');
    $date = strtotime($invoiceDetails[0]['updated_at']);
    $date = date('d M Y', $date);

    if ($invoiceDetails === false) {
        echo "ERROR: Invoice not found";
        exit();
    }
} else {
    echo "ERROR: Invoice ID not found";
    exit();
}
if (file_exists('css/style.css')) {
    // echo "file exists";
    
} else {
    echo "ERROR: Template file not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice - <?= htmlspecialchars($invoiceDetails[0]['customer_name']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body>
<div class="container">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <div class="header">
                                <div class="row gutters">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <a href="index.html" class="invoice-logo">
                                            <img src="../src/assets/images/logos/LOGO1.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <address class="text-right address">
                                            Yves Sofer<br>
                                            Yvessofer.com<br>
                                            06 51 69 03 04<br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <address>
                                            <?= htmlspecialchars($invoiceDetails[0]['customer_name']); ?><br>
                                            <?= htmlspecialchars($invoiceDetails[0]['address']); ?><br>
                                            <?= htmlspecialchars($invoiceDetails[0]['zipcode']); ?> <?= htmlspecialchars($invoiceDetails[0]['city']); ?><br>
                                        </address>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <div class="invoice-num">
                                            <div><?= ucfirst($invoiceDetails[0]['type']); ?> N° <?= str_pad($invoiceDetails[0]['invoice_number'], 4, '0', STR_PAD_LEFT); ?></div>
                                            <div><?= $date; ?></div>
                                        </div>
                                    </div>                                                    
                                </div>
                            </div>
                        </div>
                        <div class="invoice-body">
                            <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Produit</th>
                                                    <th>Identifiant</th>
                                                    <th>Quantité</th>
                                                    <th>Prix unitaire</th>
                                                    <th>Prix total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($invoiceDetails as $item): 
                                                    $unitPrice = floatval(str_replace('€','',$item['unit_price']));
                                                    $totalProductPrice = floatval(str_replace('€','',$item['total_product_price']));
                                                    ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($item['product']); ?></td>
                                                    <td><?= htmlspecialchars($item['product_id']); ?></td>
                                                    <td><?= htmlspecialchars($item['quantity']); ?></td>
                                                    <td><?= htmlspecialchars(number_format($unitPrice , 2, ',', ' ')) . ' €'; ?></td>
                                                    <td><?= htmlspecialchars(number_format($totalProductPrice, 2, ',', ' ')) . ' €'; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-footer">
                        Thank you for your Business.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
