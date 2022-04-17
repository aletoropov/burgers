<?php

$config = require 'src/config.php';

$con = new mysqli($config['host'], $config['user'], $config['pass'], $config['db']);
if (mysqli_connect_errno())
{
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
}

require 'src/function.php';

$email = (string) $_POST['email'];

if (searchUserByEmail($con, $email)) {
    $id = selectUserId($con, $email);
    $insId = addOrder($con, $_POST, $id);
} else {
    $insId = addOrder($con, $_POST);
}

showOrders($con, $id, $insId);
