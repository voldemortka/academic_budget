<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    if(isset($_POST['money'])){
        $sql = "update account set all_money=all_money+".$_POST['money']." where id=".$id;
        pg_query($conn, $sql);
        header('Location: money_in2.php');
        exit();
    }



?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <script>

        </script>
        <title>Academic budget</title>

                        <style>
            .pos_in_list{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 40vw;
                padding: 2vh 0;
                margin: 2vh auto;
                border-bottom: 1px dotted var(--sec);
            }

            .inp{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 30%;
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
        <form>
            <form action='money_out.php' method='post'>
                <h2 class="almendra">What whould you like to do with the rest of your money?</h2>

                <div id="info">If you want to move the left money to savings and clear the categorie - check the categorie.<br>
                The money from the categories that you keep unchecked will be moved to the next mounth - to the same categorie</div>

                <fieldset style="margn-top: 3vh; display: block;">

                    <?php
                        $sql = "select icon, name from categories where archive=0 and acc=".$id;
                        $result = pg_query($conn, $sql);
                        if(pg_num_rows($result)==0){
                            echo "You have no categories yet";
                        } else {
                            while($row = pg_fetch_assoc($result)){
                                echo "
                                    <label class='pos_in_list'>
                                        <i class='chosen_icon icon-".$row['icon']."'></i>
                                        ".$row['name']."
                                        <input type='radio' class='inp' name='cat' value='".$row['name']."'>
                                    </label>
                                ";
                            }
                        }
                    ?>
                    
                </fieldset>

                <button role='submit' type='submit' class='butt'>Save</button>
                
            </form>
        </main>
    </body>
</html>