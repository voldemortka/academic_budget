<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    if(isset($_POST['money']) && isset($_POST['from']) && isset($_POST['to'])){
        $sql = "update banks set money = money + ".$_POST['money']." where id=".$_POST['to'];
        pg_query($conn, $sql);
        $sql = "update banks set money = money - ".$_POST['money']." where id=".$_POST['from'];
        pg_query($conn, $sql);
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget - transfer</title>

        <script>
        </script>

        <style>
            h2{
                font-size: 35px;
            }

            fieldset{
                text-align: left;
                margin: 3vh 12vw;
            }

            .bankli{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 40vw;
                padding: 2vh 0;
                letter-spacing: 2px;
            }
        </style>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <h1 class="almendra">Transmit your money from one account to another</h1>
            <form action="trans.php" method='post'>
                <label>How much money? <input type='number' name='money'></label>
                <h2 class="almendra">Transfer your money from:</h2>
                <fieldset>
                    <?php
                    $sql = "select id, name, money from banks where acc=".$id;
                    $result = pg_query($conn, $sql);
                    while($row = pg_fetch_assoc($result)){
                        echo "
                            <div class='list_pos bankli'>
                                <input type='radio' name='from' value=".$row['id'].">
                                <span>".$row['name']."</span> <span>Current money: ".$row['money']."zł</span>
                            </div>
                        ";
                    }
                    
                    ?>
                </fieldset>
                <h2 class="almendra">To:</h2>
                <fieldset>
                    <?php
                    $sql = "select id, name, money from banks where acc=".$id;
                    $result = pg_query($conn, $sql);
                    while($row = pg_fetch_assoc($result)){
                        echo "
                            <div class='list_pos bankli'>
                                <input type='radio' name='to' value=".$row['id'].">
                                <span>".$row['name']."</span> <span>Current money: ".$row['money']."zł</span>
                            </div>
                        ";
                    }
                    
                    ?>
                </fieldset>
                <button role='submit' class='butt'>Confirm and transmit</button>
            </form>
        </main>
    </body>
</html>