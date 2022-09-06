<?php
define('SALT', 'a_very_random_salt_for_this_app');
define('FILE_SIZE_LIMIT', 20000000);

define('DB_HOST',     '127.0.0.1');
define('DB_PORT',     '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'final');

function connect()
{
    $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
    if (!$link)
    {
        echo mysqli_connect_error();
        exit;
    }

    return $link;
}

/**
 * Look up the user & password pair from the database.
 *
 * Passwords are simple md5 hashed, but salted.
 *
 * Remember, md5() is just for demonstration purposes.
 * Do not do this in production for passwords.
 *
 * @param $user string The username to look up
 * @param $pass string The password to look up
 * @return bool true if found, false if not
 */
function findUser($email, $pass)
{
    $found = false;

    $link = connect();
    $hash = md5($pass . SALT);

    $query   = 'select * from users where email = "'.$email.'" and password = "'.$hash.'"';
    $results = mysqli_query($link, $query);

    if (mysqli_fetch_array($results))
    {
        $found = true;
    }

    mysqli_close($link);
    return $found;
}

function getName($email)
{
    $link = connect();

    $ownerName = "";
    $query   = 'select name from users where email = "'.$email.'"';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        foreach($row as $array){
            $ownerName = $array;
        }
    }

    mysqli_close($link);
    return $ownerName;
}



/**
 * Remember, md5() is just for demonstration purposes.
 * Do not do this in production for passwords.
 *
 * @param $data
 * @return bool
 */
function saveUser($data)
{
    $email   = trim($data['email']);
    $first   = trim($data['first']);
    $last    = trim($data['last']);
    $password   = md5($data['password']. SALT);
    $name = $first." ".$last;

    $link    = connect();
    $query   = 'insert into users(email, password, name) 
                values("'.$email.'","'.$password.'","'.$name.'")';
    $success = mysqli_query($link, $query); // returns true on insert statements

    mysqli_close($link);
    return $success;
}

function checkName($name)
{
    return preg_match("/^[a-zA-Z]{2,10}$/", $name);
}

function checkEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


/**
 * @param $data
 * @return bool
 */
function checkSignUp($data)
{
    $valid = true;

    // if any of the fields are missing
    if( trim($data['first'])            == '' ||
        trim($data['last'])             == '' ||
        trim($data['email'])            == '' ||
        trim($data['password'])         == '' ||
        trim($data['verify_password'])  == '')
    {
        $valid = false;
    }
    elseif(!checkName(trim($data['first'])))
    {
        $valid = false;
    }
    elseif(!checkName(trim($data['last'])))
    {
        $valid = false;
    }
    elseif(!checkEmail(trim($data['email'])))
    {
        $valid = false;
    }
    elseif(!preg_match('/((?=.*[a-z])(?=.*[0-9])(?=.*[!?|@])){8}/', trim($data['password'])))
    {
        $valid = false;
    }
    elseif($data['password'] != $data['verify_password'])
    {
        $valid = false;
    }

    return $valid;
}

function filterUserName($name)
{
    // if it's not alphanumeric, replace it with an empty string
    return preg_replace("/[^a-z0-9]/i", '', $name);
}

/**
 * @param $file
 * @return bool
 */
function checkPost($file)
{
    if(!$file['picture']['size'] < FILE_SIZE_LIMIT)
    {
        return true;
    }

    return 'unable to upload';
}


function saveProducts($title, $price, $desc, $file, $email, $name)
{
    $pin = '0';
    $downvote = 0;
    $picture = md5($title.time());
    $moved   = move_uploaded_file($file['picture']['tmp_name'], 'products/'.$picture);

    if($moved)
    {
        $link   = connect();
        $query  = 'insert into products(title, price, desc, picture, email, name, pin) 
                   values("'.$title.'","'.$price.'","'.$desc.'","'.$picture.'", "'.$email.'", "'.$name.'", "'.$pin.'", "'.$downvote.'")';
        $result = mysqli_query($link, $query);

        mysqli_close($link);
        return $result;
    }

    return false;
}

function saveRecently($title, $price, $desc, $file, $email, $name,$downvote)
{

    $picture = md5($title.time());
    $moved   = move_uploaded_file($file['picture']['tmp_name'], 'products/'.$picture);

    if($moved)
    {
        $link   = connect();
        $query  = 'insert into products(title, price, desc, picture, email, name, pin) 
                   values("'.$title.'","'.$price.'","'.$desc.'","'.$picture.'", "'.$email.'", "'.$name.'",  "'.$downvote.'")';
        $result = mysqli_query($link, $query);

        mysqli_close($link);
        return $result;
    }

    return false;
}

/**
 * @return bool|mysqli_result
 */
function getAllProducts()
{
    $link     = connect();
    $query    = 'select * from products order by pin DESC, name, price DESC';
    $products = mysqli_query($link, $query);

    mysqli_close($link);
    return $products;
}

/**
  * @return bool|mysqli_result
  */
function getAllRecently()
{
    $link     = connect();
    $query    = 'select * from recently order by pin DESC, name, price DESC';
    $products = mysqli_query($link, $query);

    mysqli_close($link);
    return $products;
}



function findProduct($name)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$name.'" ';
    $product = mysqli_query($link, $query);

    mysqli_close($link);
    return $product;
}

function getProductID($title)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$title.'" ';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        $name = $row['id'];
    }

    mysqli_close($link);
    return $name;
}

function getProductTitle($title)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$title.'" ';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        $itemName = $row['title'];
    }

    mysqli_close($link);
    return $itemName;
}

function getProductPrice($title)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$title.'" ';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        $price = $row['price'];
    }

    mysqli_close($link);
    return $price;
}

function getProductDescription($title)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$title.'" ';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        $description = $row['desc'];
    }

    mysqli_close($link);
    return $description;
}

function getProductPicture($title)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$title.'" ';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        $picture = $row['picture'];
    }

    mysqli_close($link);
    return $picture;
}

function getProductEmail($title)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$title.'" ';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        $email = $row['email'];
    }

    mysqli_close($link);
    return $email;
}

function getProductOwnerName($title)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$title.'" ';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        $name = $row['name'];
    }

    mysqli_close($link);
    return $name;
}

function getProductDownVote($title)
{
    $link = connect();

    $query   = 'select * from products where title = "'.$title.'" ';
    $result = mysqli_query($link, $query);

    while($row = mysqli_fetch_row($result)){
        $name = $row['downvote'];
    }

    mysqli_close($link);
    return $name;
}




/**
 * Delete a profile based on the ID and username combination
 *
 * @param $id
 * @param $email
 * @return bool returns true on deletion success or false on failure
 */
function deleteProduct($id, $email)
{
    $link    = connect();
    $query   = 'delete from products where id = "'.$id.'" and email = "'.$email.'"';
    $success = mysqli_query($link, $query);

    mysqli_close($link);
    return $success;
}

