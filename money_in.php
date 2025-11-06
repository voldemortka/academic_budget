<?php
   if( isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }


    if(isset($_POST['money']) && isset($_POST['bank'])){
        if(isset($_POST['note'])) $note=$_POST['note']; else $note = "";

        $sql = "insert into expenses (value, categorie, notes, acc, bank, inout) 
        values (".$_POST['money'].", -1, '".$note."', ".$id.", ".$_POST['bank'].", 'in')";
        pg_query($conn, $sql);

        $sql = "update banks set money=money+".$_POST['money']." where id=".$_POST['bank'];
        pg_query($conn, $sql);
    }


?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <script>
            function check(){
                ...
            }

            function wanna_save(){
                if(check()){
                    if( confirm("Are you sure that you want to add these money? You won't be able to undo this action") ){
                        decument.location.href='money_in_ok.php';
                    }
                } else{
                    alert("You can't save, because you devided more money that you earned. Correct it");
                }
            }
        </script>
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
        <title>Academic budget - new money</title>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <form action='money_in.php' method='post'>
                <h2 class="almendra">How much money have you just earned?</h2>
                <input type="number" min=0 name="money" value=0 placeholder='type here the amount of money' style='width: 30vw; margin-bottom: 5vh;'>

                <h2 class="almendra">Select the account</h2>

                <fieldset style="margn-top: 3vh; display: block;">

                    <?php
                        $sql = "select id, name from banks where acc=".$id;
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

                <input type="submit" value='save' class='butt'>
                
            </form>
        </main>
    </body>
</html>