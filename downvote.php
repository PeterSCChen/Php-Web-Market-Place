<?php
require 'includes/functions.php';
session_start();

if(isset($_GET['item'])) {
    $title = $_GET['item'];

    $product = findProduct($title);

    $productTitle = getProductTitle($title);
    $productEmail = getProductEmail($title);
    $productVote = getProductDownVote($title);


    if($productVote > 5) {
        $link = connect();

        $query = 'delete from products where email = "' . $productEmail . '"';
        $result = mysqli_query($link, $query);

        mysqli_close($link);
        header('Location: index.php');
        exit();
    }
    else
    {
        $productVote += 1;
        $link = connect();

        $query = 'update products set downvote = "' . $productVote . '"';
        $result = mysqli_query($link, $query);

        mysqli_close($link);
        header('Location: index.php');
        exit();
    }
}

header('Location: index.php');
exit();
