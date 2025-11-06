<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    if(isset($_POST['money']) && isset($_POST['bank']) && isset($_POST['cat'])){
        if(isset($_POST['note'])) $note=$_POST['note']; else $note = "";

        $sql = "insert into expenses (value, categorie, notes, acc, bank, inout) 
        values (".$_POST['money'].", ".$_POST['cat'].", '".$note."', ".$id.", ".$_POST['bank'].", 'out')";
        pg_query($conn, $sql);

        $sql = "update banks set money=money-".$_POST['money']." where id=".$_POST['bank'];
        pg_query($conn, $sql);

        $sql = "update categories set curr_money=curr_money-".$_POST['money']." where id=".$_POST['cat'];
        pg_query($conn, $sql);
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget - spent money</title>

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
                
            .pos_in_list_banks{
                display: flex;  
                align-items: center; 
                width: 40vw;
                padding: 2vh 0;
                margin: 2vh auto;
                border-bottom: 1px dotted var(--sec);
            }
            
        </style>

    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <form action='money_out.php' method='post'>
                <h2 class="almendra">How much money have you just spent? Admit here</h2>
                <input type="number" min=0 name="money" value=0 placeholder='type here the amount of money' style='width: 30vw; margin-bottom: 5vh;'>

                <h2 class="almendra">And tell me, what was the categorie?</h2>

                <fieldset style="margn-top: 3vh; display: block;">

                    <?php
                        $sql = "select id, icon, name from categories where archive=0 and acc=".$id;
                        $result = pg_query($conn, $sql);
                        if(pg_num_rows($result)==0){
                            echo "You have no categories yet";
                        } else {
                            while($row = pg_fetch_assoc($result)){
                                echo "
                                    <label class='pos_in_list'>
                                        <i class='chosen_icon icon-".$row['icon']."'></i>
                                        ".$row['name']."
                                        <input type='radio' class='inp' name='cat' value='".$row['id']."'>
                                    </label>
                                ";
                            }
                        }
                    ?>
                    
                </fieldset>


                <h2 class="almendra">And select the account</h2>

                <fieldset style="margn-top: 3vh; display: block;">

                    <?php
                        $sql = "select name, id from banks where acc=".$id;
                        $result = pg_query($conn, $sql);
                            while($row = pg_fetch_assoc($result)){
                                echo "
                                    <label class='pos_in_list_banks'>
                                        <input type='radio' class='inp' name='bank' value='".$row['id']."' style='margin-right: 3vw;'> ".$row['name']."
                                    </label>
                                ";
                            }
                    ?>
                    
                </fieldset>

                <label style='margin-top: 10vh; display: block;'>Notes: <input type="text" name='note'></label>

                <button role='submit' type='submit' class='butt'>Save</button>
                
            </form>
                </main>
    </body>
</html>