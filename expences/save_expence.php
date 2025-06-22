<?php
require_once(__DIR__ . '/../src/utils/connectDB.php');
require_once(__DIR__ . '/../src/utils/autoload.php');

$expenseObj = new Expenses($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier_id = $_POST['supplier_id'];
    $payment_date = $_POST['payment_date'];
    $amount = $_POST['amount'];
    $year = date('Y');

    // Gestion du fichier
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/../uploads/expenses/$year/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Nom de fichier unique
        $extension = pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION);
        $filename = uniqid("receipt_") . '.' . $extension;
        $filePath = $uploadDir . $filename;
        $relativePath = "uploads/expenses/$year/" . $filename;

        // Sauvegarde
        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath)) {
            $expenseObj->create($supplier_id, $payment_date, $amount, $relativePath);
            echo "<script>alert('הוצאה נשמרה בהצלחה!'); window.location.href='ajouter_depense.php';</script>";
        } else {
            echo "אירעה שגיאה בהעלאת הקובץ.";
        }
    } else {
        echo "הקובץ לא התקבל כראוי.";
    }
}
