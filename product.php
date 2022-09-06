<?php
require 'includes/functions.php';
session_start();
$title = $_GET['item'];

$product = findProduct($title);


if($product == false){
    header('Location: index.php');
    exit();
}

$productTitle = getProductTitle($title);
$productPrice = getProductPrice($title);
$productDescription = getProductDescription($title);
$productPicture = getProductPicture($title);
$productEmail = getProductEmail($title);
$productName = getProductOwnerName($title);
$productDownvote = getProductDownVote($title);

saveRecently($productTitle,$productPrice,$productDescription,$productPicture,$productEmail,$productName);

?>

<!DOCTYPE html>
<html>
<head>
    <title>COMP 3015</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div id="wrapper">

    <div class="container">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1 class="login-panel text-center text-muted">
                    COMP 3015 Final Project
                </h1>
                <hr/>
            </div>
        </div>
        <?php
        echo '
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div>
                        <p>
                            <a class="btn btn-default" href="index.php">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </p>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            ' . $productTitle . '
                        </div>
                        <div class="panel-body text-center">
                            <p>
                                <img class="img-rounded img-thumbnail" src="products/'.$productPicture.'.png"/>
                            </p>
                            <p class="text-muted text-justify">
                               ' . $productDescription . '
                            </p>
                        </div>
                        <div class="panel-footer ">
                            <span><a href="'.$productEmail.'"><i class="fa fa-envelope"></i> '.$productName.'</a></span>
                            <span class="pull-right">' . $productPrice . '</span>
                        </div>
                    </div>
                </div>
            </div>
        '
        ?>
    </div>

</div>


</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
