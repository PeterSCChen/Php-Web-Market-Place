<?php
session_start();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $pinned = $_GET['pinned'];

    $link = connect();
    $query = 'update products set pinned = "' . $pinned . '" where id = "' . $id . '"';
    $result = mysqli_query($link, $query);

    mysqli_close($link);
    header('Location: index.php');
    exit();
}

header('Location: index.php');
exit();



