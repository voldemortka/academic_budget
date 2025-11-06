<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    if(isset($_POST["OK_form_sent_yes"])){
        $sql = "select name, lim from categories where acc=".$id;
        $result = pg_query($conn, $sql);
        while($row = pg_fetch_assoc($result)){
            $diver = $_POST[$row['name']] - $row['lim'];
            $sql = "update categories set lim = ".$_POST[$row['name']].", curr_money=curr_money+".$diver."  where acc=".$id." and name='".$row['name']."'";
            pg_query($conn, $sql);
        }
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget - limits</title>

        <style>
            .catli{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 40vw;
                padding: 2vh 0;
            }

            .chosen_icon{
                width: 10%;
                aspect-ratio: 1 / 1;
                border: 1px var(--sec) dotted;
                border-radius: 10px;
                display: flex;  
                align-items: center; 
                font-size: 140%;
                justify-content: center;
                color: var(--sec);
            }
        </style>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <h1 class="almendra">categories - limits to adjust</h1>
            <form action='limits.php' method='post' onchange="check()">
                <input type='hidden' name='OK_form_sent_yes' value=1>
                <?php
                    $sql = "select name, lim, icon from categories where acc=".$id;
                    $result = pg_query($conn, $sql);
                    if(pg_num_rows($result)==0){
                        echo "You have no categories yet";
                    } else {
                        while($row = pg_fetch_assoc($result)){
                            echo "
                                <div class='list_pos catli'>
                                    <i class='chosen_icon icon-".$row['icon']."'></i>
                                    <p class='name_categorie'>".$row['name']."</p>
                                    <input type='number' name='".$row['name']."' value=".$row['lim'].">
                                </div>
                            ";
                        }
                    }
                ?>

                <input type="submit" value='confirm' class='butt'>
            </form>
        </main>

    </body>
</html>