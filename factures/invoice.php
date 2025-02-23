<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// phpinfo();
// exit;


// Inclure le fichier connectDB.php
require_once(__DIR__ . '/../src/utils/connectDB.php');
// Inclure le fichier autoload.php
require_once(__DIR__ . '/../src/utils/autoload.php');
$user = new Users($conn); // $pdo est votre connexion PDO

//echo realpath("src/assets/js/dashboard.js");


// Vérifie si la session est valide
// if (!$user->check_session()) {
//     header("Location: ../login.php");
//     exit();
// }
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$invoice = new Invoices($conn);
	// echo $id;
	$invoiceDetails = $invoice->getInvoiceByID($id);

	setlocale(LC_TIME, 'fr_FR.UTF-8');
	// var_dump($invoiceDetails);
	// exit();
	$date = strtotime($invoiceDetails[0]['updated_at']);
	$date = date('d M Y', $date);
	$total = 0;
	// print_r($invoiceDetails);
	if ($invoiceDetails === false) {
		echo "ERROR: Invoice not found";
		//header("Location: index.php");
		exit();
	}
} else {
	echo "ERROR: Invoice ID not found";
	//header("Location: index.php");
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>white invoice - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<script>
	var invoice_details = <?=json_encode($invoiceDetails); ?>
</script>
<body>
<div class="container">
<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body p-0">
					<div class="invoice-container">
						<div class="invoice-header">
							<div class="header">
								<!-- Row start -->
								<!-- <div class="row gutters">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
										<div class="custom-actions-btns mb-5">
											<a href="#" class="btn btn-primary">
												<i class="icon-download"></i> Download
											</a>
											<a href="#" class="btn btn-secondary">
												<i class="icon-printer"></i> Print
											</a>
										</div>
									</div>
								</div> -->
								<!-- Row end -->
								<!-- Row start -->
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
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<div class="invoice-details">
										<address>
											<?php echo $invoiceDetails[0]['customer_name']; ?><br>
											<?php echo $invoiceDetails[0]['address'];?><br>
											<?php echo $invoiceDetails[0]['zipcode'];?> <?php echo $invoiceDetails[0]['city'];?> <br>
										</address>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<div class="invoice-details">
										<div class="invoice-num">
											<div><?php echo ucfirst($invoiceDetails[0]['type'])?> N° <?php echo str_pad($invoiceDetails[0]['invoice_number'], 4, '0', STR_PAD_LEFT)?></div>
											<br>
											<div><?php echo $date;?></div>
										</div>
									</div>													
								</div>
							</div>
							<!-- Row end -->
						</div>
						<div class="invoice-body">
							<!-- Row start -->
							<div class="row gutters">
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
												<?php $total = $total + $totalProductPrice; ?>
                                                <?php endforeach; ?>
                                            </tbody>
											<!--add table footer-->
											
											<tfoot>
												<tr>
													<td colspan="3" style="text-align: left; font-weight: bold;">TOTAL : </td>
												<!--get total for all $totalProductPrice from for each -->
												<td colspan="2" style="text-align: right; font-weight: bold;"><?= htmlspecialchars(number_format($total, 2, ',', ' ')) . ' €'; ?></td>
												</tr>
											</tfoot>
											
                                        </table>
							</div>
							<?php if (!empty($invoiceDetails[0]['pictures_folder'])): ?>
							<div>
								<table class="table table-bordered">
									<thead>
										<tr>
            								<th colspan="3" style="text-align: center;">Images</th>
        								</tr>
									</thead>
									<tbody>
										
										<?php include (__DIR__.'/../src/utils/functions/pictures_section.php');?>
										
									</tbody>
								</table>

							</div>
							<?php endif; ?>
							<!-- Row end -->
						</div>	
					</div>
				</div>
				<div class="card-footer">
					<div class="row gutters">
						<!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6"> -->
							<div class="text-center">
								<p>Nous acceptons les retours dans un délai de 14 jours à compter de la date de réception de votre commande. Les articles doivent être non utilisés, dans leur état d'origine, et accompagnés de leur emballage d'origine.
Pour initier un retour, veuillez contacter notre service client. Les frais de retour sont à votre charge, sauf en cas d'article défectueux ou d'erreur de notre part.</p>
							</div>
						<!-- </div> -->
					</div>
			</div>
		</div>
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

<script src="../src/assets/js/invoices.js?v=<?=$version?>" ></script>

</body>
</html>