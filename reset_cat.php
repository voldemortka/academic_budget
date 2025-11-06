<?php

if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
    $id = $_COOKIE['AB_id'];
    $name = $_COOKIE['AB_name'];
    require_once("connect.php");
} else {
    header('Location: login.php');
    exit();
}

$sql = "update categories set curr_money=lim where acc=".$id;
pg_query($conn, $sql);

header('Location: list.php');