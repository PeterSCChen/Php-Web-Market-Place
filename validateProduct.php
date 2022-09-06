<?php
require 'includes/functions.php';

session_start();


$email =  $_SESSION['email'];
$name =  getName($email);


echo $_POST['title'],$_POST['price'],$_POST['desc'], $email, $name;


if(count($_FILES > 0))
{
    $valid = true;
    if(!checkName($_POST['title'])){
        $valid = false;
    }
    elseif(!preg_match('/^\d+(\.\d{2})?$/',$_POST['price'] )){
       $valid = false;
    }
    elseif(!preg_match('/^[a-zA-Z.,]+$/', $_POST['desc'])){
        $valid = false;
    }
    elseif(!checkPost($_FILES)){
        $valid = false;
    }


    if($valid){
        $picture = md5($_POST['title'].time());

        $moved   = move_uploaded_file($_FILES['picture']['tmp_name'], 'products/'.$picture);

        if($moved)
        {
            saveProducts($_POST['title'],$_POST['price'],$_POST['desc'],$_FILES, $email, $name);

            header('Location: index.php');
            exit();
        }

    }

}

header('Location: newProduct.php');
exit();