<?php

function searchUserByEmail($dbcon, string $email) {
    $result = false;
    $email = mysqli_escape_string($dbcon, $email);
    $sql = "SELECT * FROM `users` WHERE email = '$email'";
    $res = $dbcon->query($sql);
    if(!$res->num_rows == 0) {
        $result = $res;
    }
    return $result;
}

function selectUserId($dbcon, string $email)
{
    $email = mysqli_escape_string($dbcon, $email);
    $sql = "SELECT `id` FROM `users` WHERE email = '$email'";
    $res = $dbcon->query($sql);
    $row = $res->fetch_array(MYSQLI_ASSOC);
    return $row['id'];
}

function addOrder($dbcon, array $data, int $userId = null)
{
    $address = mysqli_escape_string($dbcon, $data['street'] .
                                            ', ' . $data['home'] . ', ' . $data['part'] . ', ' . $data['comment']);
    $email = mysqli_escape_string($dbcon, $data['email']);
    $id = mysqli_escape_string($dbcon, $userId);
    if (empty($userId)) {
        $sql = "INSERT INTO `users` SET `address` = '$address', 
                                        `email` = '$email',
                                        `order` = '1'";
        $dbcon->query($sql);
    } else {
        $sql = "SELECT `order` FROM `users` WHERE id = '$id'";
        $res = $dbcon->query($sql);
        $row = $res->fetch_array(MYSQLI_ASSOC);
        $order = mysqli_escape_string($dbcon, (int) $row['order'] + 1);
        $sql = "UPDATE `users` SET `order` = '$order'";
        $dbcon->query($sql);
    }

    return $dbcon->insert_id;
}

function showOrders($dbcon, int $userId, int $insId)
{
    $id = mysqli_escape_string($dbcon, $userId);
    $sql = "SELECT `order` FROM `users` WHERE `id` = '$id'";
    $res = $dbcon->query($sql);
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $orderNum = $row['order'];
    $address = $_POST['street'] . ', ' . $_POST['home'] . ', ' . $_POST['part'];
    echo 'Спасибо, ваш заказ будет доставлен по адресу: ' . $address . '<br>';
    echo 'Номер вашего заказа: ' . $userId . '<br>';
    echo 'Это ваш ' . $orderNum . '-й заказ!';
}
