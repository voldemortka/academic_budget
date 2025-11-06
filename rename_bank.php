<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name']) && isset($_COOKIE['wanna_edit_name_bank'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        $old_name = $_COOKIE['wanna_edit_name_bank'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    if(isset($_POST['name'])){
        $sql = "update banks set name='".$_POST['name']."' where name=".$old_name." and acc=".$id;
        pg_query($conn, $sql);
        setcookie("wanna_edit_name_bank", "", time() - 3600, "/");
        header('Location: banks.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget - rename bank</title>

    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <h1 class="almendra">Rename the account <?=$old_name?></h1>
            <form action="rename_bank.php" method='post'>
                <label>New name: <input type="text" name='name' value='<?=$old_name?>'></label>
                <button role='submit' class='butt'>Change name</button>
            </form>
        </main>
    </body>
</html>