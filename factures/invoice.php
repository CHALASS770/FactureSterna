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

	setlocale(LC_TIME, 'fr_IL.UTF-8');
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
<html lang="he-IL" dir="rtl">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>חשבונית</title>
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
									<div class="col-xl-2 col-lg-6 col-md-6 col-sm-6">
										<a href="index.html" class="invoice-logo">
											<img src="../src/assets/images/logos/LOGO1.png" alt="">
										</a>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6">
										<address class="text-right address">
										משפחתון של שטערנא<br>
										שטערנא אסולין אסרף<br>
										053-787-2141<br>
										329714950 העסק מספר<br>
										רחוב הרצל 26<br>
										חדרה 3842118<br>
										</address>
									</div>
								</div>
							</div>
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<div class="invoice-details text-right">
										<address style="family: 'David Libre', sans-serif; font-size: 18px; font-weight: bold; color: #4681da;">
											<?php echo $invoiceDetails[0]['customer_name']; ?><br>
											<?php echo $invoiceDetails[0]['address'];?><br>
											<?php echo $invoiceDetails[0]['city'];?> <br>
											<?php echo $invoiceDetails[0]['phone'];?><br>
											<?php echo $invoiceDetails[0]['email'];?><br>
										</address>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<div class="invoice-details">
										<div class="invoice-num">
											<div><?php echo $invoiceDetails[0]['type'] == 'facture' ? 'חשבונית' : 'לְהַעֲרִיך' ?>  <?php echo str_pad($invoiceDetails[0]['invoice_number'], 4, '0', STR_PAD_LEFT)?></div>
											<br>
											<div style="color: #FF5733">תאריך התשלום : <?php echo $invoiceDetails[0]['payement_date'];?></div>
											<br>
											<div>תאריך יצירה :<?php echo $invoiceDetails[0]['updated_at'];?></div>
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
                                                    <th>מוצר</th>
                                                    <th>ID</th>
                                                    <th>כמות</th>
                                                    <th>מחיר ליחידה</th>
													<th>הנחה</th>
                                                    <th>מחיר סה"כ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($invoiceDetails as $item): 
                                                    $unitPrice = floatval(str_replace('₪','',$item['unit_price']));
                                                    $totalProductPrice = floatval(str_replace('₪','',$item['total_product_price'])) - (floatval(str_replace('₪','',$item['total_product_price'])) * ($item['reduction'] / 100));
                                                    ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($item['product']); ?></td>
                                                    <td><?= htmlspecialchars($item['product_id']); ?></td>
                                                    <td><?= htmlspecialchars($item['quantity']); ?></td>
                                                    <td><span style="direction: ltr; display: inline-block; text-align: left;"><?= htmlspecialchars(number_format($unitPrice, 2, ',', ' ')) . ' ₪'; ?></span></td>		
													<td><?= htmlspecialchars(number_format($item['reduction'], 2, ',', ' ')); ?>% </td>											</td>
                                                    <td><span style="direction: ltr; display: inline-block; text-align: left;"><?= htmlspecialchars(number_format($totalProductPrice, 2, ',', ' ')) . ' ₪'; ?></span></td>
                                                </tr>
												<?php $total = $total + $totalProductPrice; ?>
                                                <?php endforeach; ?>
                                            </tbody>
											<!--add table footer-->
											
											<tfoot>
												<tr>
													<td colspan="3" style="text-align: left; font-weight: bold;"> סה"כ : </td>
												<!--get total for all $totalProductPrice from for each -->
												<td colspan="2" style="text-align: right; font-weight: bold;"><span style="direction: ltr; display: inline-block; text-align: left;"><?= htmlspecialchars(number_format($total, 2, ',', ' ')) . ' ₪'; ?></span></td>
												</tr>
											</tfoot>
											
                                        </table>
							</div>
							
							<!-- Row end -->
						</div>	
					</div>
				</div>
				<div class="card-footer">
					<div class="row gutters">
						<!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6"> -->
						<address class="text-right">
										משפחתון של שטערנא<br>
										שטערנא אסולין אסרף<br>
										053-787-2141<br>
										329714950 העסק מספר<br>
										רחוב הרצל 26<br>
										חדרה 3842118<br>
										</address>
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
<?php if (isset($_GET['print']) && $_GET['print'] == 1): ?>
<script>
  window.onload = function() {
    window.print();
  };
</script>
<?php endif; ?>
</body>
</html>