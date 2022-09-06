<?php
require 'includes/functions.php';

// these are for products that are pinned already
define('unpin'      , 'Unpin item');
define('unpinSymbol', 'fa fa-dot-circle-o');
define('unpinPanel' , 'panel panel-warning');

// these are for products that are not pinned
define('pin'      , 'Pin item');
define('pinSymbol'  , 'fa fa-thumb-tack');
define('pinPanel',    'panel panel-info');

session_start();

$searching = false;
$searchValue = '';

$products = getAllproducts();
$recently = getAllRecently();


if($_GET[search] == 'TRUE'){
    $searching = true;
    $searchValue = trim($_POST['searchValue']);
}
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

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php
                if(isset($_SESSION['loggedin'])) {
                    echo '
                    <a href = "newProduct.php" class="btn btn-default" ><i class="fa fa-photo"></i> New Item</button>
                    <a href = "logout.php" class="btn btn-default pull-right" ><i class="fa fa-sign-out" > </i > Logout</a >
                    ';
                }
                if(!isset($_SESSION['loggedin'])) {
                    echo '
                    <a href = "login.php" class="btn btn-default pull-right" ><i class="fa fa-sign-in" > </i > Login</a >
                    <a href = "signup.php" class="btn btn-default pull-right" ><i class="fa fa-user" ></i > Sign Up </a >
                    ';
                }
                ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <h2 class="login-panel text-muted">
                    Recently Viewed
                </h2>
                <hr/>
            </div>
        </div>
        <div class="row">

            <?php
            foreach($recently as $recent)
            {
                $recentTitle = $recent['title'] ;

                $productID = getProductID($recentTitle);
                $productTitle = getProductTitle($recentTitle);
                $productPrice = getProductPrice($recentTitle);
                $productDescription = getProductDescription($recentTitle);
                $productPicture = getProductPicture($recentTitle);
                $productEmail = getProductEmail($recentTitle);
                $productName = getProductOwnerName($recentTitle);

                echo'
                <div class="col-md-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                                 ' . $productTitle . '
                            <span class="pull-right text-muted">
                                <a class="" href = "delete.php?id=' . $productID. '" data - toggle = "tooltip" title = "Delete item" >
                                    <i class="fa fa-trash"></i>
                                </a>
                            </span>
                        </div>
                        <div class="panel-body text-center">
                            <p>
                                <a href="product.php?item='.$productTitle.'">
                                    <img class="img-rounded img-thumbnail" src="products/'.$productPicture.'.png"/>
                                </a>
                            </p>
                            <p class="text-muted text-justify">
                               '.$productDescription.'
                            </p>
                            <a class="pull-left" href="downvote.php?id=item='.$productTitle.'" data-toggle="tooltip" title="Downvote item">
                                <i class="fa fa-thumbs-down"></i>
                            </a>
                        </div>
                        <div class="panel-footer ">
                            <span><a href="emailto:'.$productEmail.'" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> '.$productName.'</a></span>
                            <span class="pull-right">'.$productPrice.'</span>
                        </div>
                    </div>
                </div>
            ';
            }
            ?>




        </div>   <!-- THIS IS THE END OF RECENTLY VIEWED ITEMS -->

        <div class="row">
            <div class="col-md-3">
                <h2 class="login-panel text-muted">
                    Items For Sale
                </h2>
                <hr/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                    <form class="form-inline" action="index.php?search=TRUE">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                <input type="text" class="form-control" name="searchValue" placeholder="Search"/>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-default" value="Search"/>
                        <button class="btn btn-default" data-toggle="tooltip" title="Shareable Link!"><i class="fa fa-share"></i></button>
                    </form>
                <br/>
            </div>
        </div>

        <div class="row"> <!-- -->
            <?php
            if(!$searching) {
                $counter = 0;
                foreach ($products as $product)
                {
                    if($counter == 4){
                        echo '</div>  <!-- This determines new row for items  -->';
                        $counter = 0;
                    }
                    echo '
                    <div class="col-md-3">
                    ';
                    if($product['pin'] == '1'){
                        echo'
                        <div class="'.unpinPanel.'">
                         <div class="panel-heading">
                                <a class="" href="pinProduct.php?pinned='.$product['pin'].'&id=' . $product['id'] . '" data-toggle="tooltip" title="'.unpin.'">
                                 <i class="'.unpinSymbol.'"></i>
                        ';
                    }
                    else{
                        echo'
                        <div class="'.pinPanel.'">
                         <div class="panel-heading">
                                <a class="" href="pinProduct.php?pinned='.$product['pin'].'&id=' . $product['id'] . '" data-toggle="tooltip" title="'.pin.'">
                                <i class="'.pinSymbol.'"></i>
                        ';
                    }
                                echo'
                                </a>
                                <span>
                                    ' . $product['title'] . '
                                </span>
                    ';

                    if ($product['email'] == $_SESSION['email']) {
                        echo ' <span class="pull-right text-muted" >
                                <a class="" href = "delete.php?id=' . $product['id'] . '" data - toggle = "tooltip" title = "Delete item" >
                                    <i class="fa fa-trash" ></i >
                                </a >
                            </span >
                        </div >
                        ';
                    }
                    echo '
                        <div class="panel-body text-center">
                            <p>
                                <a href="product.php?item=' . $product['title'] . '">
                                    <img class="img-rounded img-thumbnail" src="products/' . $product['picture'] . '"/>
                                </a>
                            </p>
                            <p class="text-muted text-justify">
                                ' . $product['desc'] . '
                            </p>';
                    if (isset($_SESSION['loggedin'])) {
                        echo '<a class="pull-left" href = "downvote.php?item='.$product['title'].'" data - toggle = "tooltip" title = "Downvote item" >
                                <i class="fa fa-thumbs-down" ></i >
                            </a >';
                    }
                    echo '
                        </div>
                        <div class="panel-footer ">
                            <span><a href="' . $product['email'] . '" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> ' . $product[name] . '</a></span>
                            <span class="pull-right">' . $product['price'] . '</span>
                        </div>
                    </div>
                </div>
                ';
                }
            }
            if(searching){
                $count = 0;
                foreach ($products as $product) {
                    if(stripos(trim($product['title']),trim($searchValue)) !== false)
                    {
                        if($count == 4){
                            echo '</div>  <!-- This determines new row for items  -->';
                            $count = 0;
                        }
                        echo '
                            <div class="col-md-3">
                        ';
                        if($product['pin'] == '1'){
                            echo'
                            <div class="'.unpinPanel.'">
                             <div class="panel-heading">
                                    <a class="" href="pinProduct.php?pinned='.$product['pin'].'&id=' . $product['id'] . '" data-toggle="tooltip" title="'.unpin.'">
                                     <i class="'.unpinSymbol.'"></i>
                            ';
                        }
                        else{
                            echo'
                            <div class="'.pinPanel.'">
                             <div class="panel-heading">
                                    <a class="" href="pinProduct.php?pinned='.$product['pin'].'&id=' . $product['id'] . '" data-toggle="tooltip" title="'.pin.'">
                                    <i class="'.pinSymbol.'"></i>
                            ';
                        }
                        echo'
                                </a>
                                <span>
                                    ' . $product['title'] . '
                                </span>
                        ';

                        if ($product['email'] == $_SESSION['email']) {
                            echo ' <span class="pull-right text-muted" >
                                <a class="" href = "delete.php?id=' . $product['id'] . '" data - toggle = "tooltip" title = "Delete item" >
                                    <i class="fa fa-trash" ></i >
                                </a >
                            </span >
                        </div >
                        ';
                        }
                        echo '
                        <div class="panel-body text-center">
                            <p>
                                <a href="product.php?item=' . $product['title'] . '">
                                    <img class="img-rounded img-thumbnail" src="products/' . $product['picture'] . '"/>
                                </a>
                            </p>
                            <p class="text-muted text-justify">
                                ' . $product['desc'] . '
                            </p>';
                        if (isset($_SESSION['loggedin'])) {
                            echo '<a class="pull-left" href = "downvote.php?item='.$product['title'].'" data - toggle = "tooltip" title = "Downvote item" >
                                <i class="fa fa-thumbs-down" ></i >
                            </a >';
                        }
                        echo '
                        </div>
                        <div class="panel-footer ">
                            <span><a href="mailto:' . $product['email'] . '" data-toggle="tooltip" title="Email seller"><i class="fa fa-envelope"></i> ' . $product[name] . '</a></span>
                            <span class="pull-right">' . $product['price'] . '</span>
                        </div>
                    </div>
                </div>
                ';
                        $count++;
                    }
                }
            }
            ?>
        </div>

</div>   <!-- This is the end of all the items, below is forms  -->


</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</html>
