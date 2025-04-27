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
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $clients = new Clients($conn);
    $result = $clients->createClient($firstname, $lastname, $address, $city, $zipcode, $email, $phone);

    if ($result) {
        echo "<script>alert('Client créé avec succès !'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Une erreur est survenue lors de la création du client.');</script>";
    }
}
?>
<!doctype html>
<html lang="he-IL" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>צור את הלקוח</title>
  <link rel="stylesheet" href="src/assets/css/styles.min.css" />
</head>
<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <!-- <aside class="left-sidebar"> -->
      <!-- Sidebar scroll-->
      <!-- <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.php" class="text-nowrap logo-img">
            <img src="src/assets/images/logos/LOGO1.png" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
      </div> -->
  

</div>
<div class="container">
<div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.php" class="text-nowrap logo-img">
            <img src="src/assets/images/logos/LOGO1.png" width="180" alt="" />
          </a>
          </div>
          <?php include('src/assets/menu/menu.php'); ?>
          <div class="d-flex flex-column justify-content-center align-items-center ">     
          <h1>צור לקוח חדש</h1>
    <form method="POST" style="width: 600px; ">
        <div class="mb-3">
            <label for="firstname" class="form-label">שם פרטי</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">שם משפחה</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">כתובת</label>
            <input type="text" class="form-control" id="address" name="address" >
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">עיר</label>
            <input type="text" class="form-control" id="city" name="city" required  >
        </div>
        <div class="mb-3">
            <label for="zipcode" class="form-label">מיקוד</label>
            <input type="text" class="form-control" id="zipcode" name="zipcode" >
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">אימייל</label>
            <input type="email" class="form-control" id="email" name="email" >
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">טלפון</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <button type="submit" class="btn btn-primary">צור את הלקוח</button>
    </form>
</div>
</div>
</body>
</html>
