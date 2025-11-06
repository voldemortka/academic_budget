<?php

$name = $_COOKIE['wanna_del_name_bank'];
require_once("connect.php");

$id = $_COOKIE['AB_id'];

$sql = "delete from banks where name=".$name." and acc=".$id;
pg_query($conn, $sql);

header('Location: banks.php');