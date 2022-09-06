<?php

require 'includes/functions.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}

if (preg_match("/^[0-9]+$/", $_GET['id'])) {
    deleteProduct($_GET['id'], $_SESSION['email']);
}

header('Location: index.php');
exit();