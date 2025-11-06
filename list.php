<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget - list of categories</title>

        <style>
            .catli{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 45vw;
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
            <h1 class="almendra">categories - money spent during this period</h1>
        <section style="margn-top: 3vh; display: block;">
        <?php
            $sql = "select icon, name, curr_money, lim from categories where archive=0 and acc=".$id;
            $result = pg_query($conn, $sql);
            if(pg_num_rows($result)==0) echo "You have no categories yet. Create it!";
            else{
                while( $row = pg_fetch_assoc($result) ){
                    $spent = $row['lim'] - $row['curr_money'];
                    echo "
                        <div class='catli list_pos'>
                            <i class='chosen_icon icon-".$row['icon']."'></i>
                            <span>".$row['name']."</span>
                            <span>Left: ".$row['curr_money']."zł</span>
                            <span>Spent: ".$spent."zł</span>
                            <span>Limit: ".$row['lim']."zł</span>
                        </div>
                    ";
                }
            }
        ?>
        </section>
        </main>
    </body>
</html>