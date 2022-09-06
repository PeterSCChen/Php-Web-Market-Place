<?php
require 'includes/functions.php';

$found = false;

$email = trim($_POST['email']);
$pass = trim($_POST['password']);


if(count($_POST) > 0)
{
    if($_GET['from'] == 'login')
    {
        $found = false; // assume not found

        $email = trim($_POST['email']);
        $pass = trim($_POST['password']);

        if(checkEmail($email))
        {
            $found = findUser($email, $pass);

            if($found)
            {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = getName($email);

                header('Location: index.php?from=login&email='.$email);
                exit();
            }
        }

        header('Location: login.php');
        exit();
    }
    elseif($_GET['from'] == 'signup')
    {

        if(checkSignUp($_POST) && saveUser($_POST))
        {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = trim($_POST['email']);
            $_SESSION['first'] = trim($_POST['first']);
            $_SESSION['last'] = trim($_POST['last']);

            $_SESSION['name'] = $_SESSION['first'] . " " . $_SESSION['last'];

            header('Location: index.php?from=signup&email='.$email);
            exit();
        }

        header('Location: signup.php');
        exit();
    }
}

header('Location: index.php');
exit();
