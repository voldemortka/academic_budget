<?php

if( isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name']) && isset($_POST['money'])) {
    $id = $_COOKIE['AB_id'];
    $name = $_COOKIE['AB_name'];
    require_once("connect.php");
} else {
    header('Location: login.php');
    exit();
}

$sql = "update account set all_money=all_money+".$_POST['money']." where id=".$id;
pg_query($conn, $sql);



header('Location: change_limits.php');
exit();