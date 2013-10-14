<?php
require_once('settings.php');

$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if($username == ADMIN_USERNAME && $password == ADMIN_PASSWORD) {
            session_start();
            $_SESSION["authenticated"] = 'true';
            header('Location: admin.php');
        }
        else {
            header('Location: login.php');
        }

    } else {
        header('Location: login.php');
    }

} else {
    include('twigloader.php');
    $template = $twig->loadTemplate('login.html');
    echo $template->render(array());
}