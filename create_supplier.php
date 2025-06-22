<?php
require_once(__DIR__ . '/../src/utils/connectDB.php');
require_once(__DIR__ . '/../src/classes/Supplier.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierObj = new Supplier($conn);
    $success = false;
    $error = '';
    $name = trim($_POST['name']);

    if ($name !== '') {
        if ($supplierObj->create($name)) {
            $success = true;
        } else {
            $error = 'אירעה שגיאה בעת שמירת הספק.';
        }
    } else {
        $error = 'יש להזין שם תקין.';
    }
}
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>הוסף ספק</title>
</head>
<body>
    <h2>הוסף ספק חדש</h2>

    <?php if ($success): ?>
        <p style="color: green;">✔️ הספק נשמר בהצלחה!</p>
    <?php elseif ($error): ?>
        <p style="color: red;">❌ <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>שם הספק:</label><br>
        <input type="text" name="name" required><br><br>
        <button type="submit">שמור ספק</button>
    </form>

    <p><a href="expenses/add_expence.php">← חזרה לטופס ההוצאה</a></p>
</body>
</html>
