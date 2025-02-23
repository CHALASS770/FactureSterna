<?php
ini_set('display_errors', 1);
session_start();
require_once(__DIR__ . '/../connectDB.php');
require_once(__DIR__ . '/../autoload.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password= $_POST['password'];

    $user = new Users($conn);
    $result = $user->createUser($firstname, $lastname, $email, $username, $password);
   
    if ($result) {
        // Rediriger vers la page d'accueil
        header("Location: /FacturesYves/index.php");
        exit();
    } else {
        // En cas d'erreur lors de la création
        $_SESSION['error'] = "Une erreur est survenue lors de la création de l'utilisateur.";
        header("Location: /FacturesYves/register.php");
        exit();
    }
    header("Location: /FacturesYves/index.php");
    exit();
}
?>
