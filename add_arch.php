<?php

$name = $_COOKIE['wanna_archive_name'];
require_once("connect.php");

$id = $_COOKIE['AB_id'];

$sql = "update categories set archive= CASE 
                WHEN archive = 0 THEN 1
                ELSE 0
                END
                where name=".$name." and acc=".$id;
pg_query($conn, $sql);

header('Location: categories.php');