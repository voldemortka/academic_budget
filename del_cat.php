<?php

$name = $_COOKIE['wanna_del_name'];
require_once("connect.php");

$id = $_COOKIE['AB_id'];

$sql = "delete from categories where name=".$name." and acc=".$id;
pg_query($conn, $sql);

header('Location: categories.php');