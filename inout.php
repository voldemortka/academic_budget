<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
    } else {
        header('Location: login.php');
        exit();
    }

    require_once("connect.php");

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget - in and out</title>

        <script>
        </script>

        <style>
            .catli{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 60vw;
                padding: 2vh 0;
            }

            .notes{
                width: 20vw;
            }

            .inout{
                width: 5%;
                aspect-ratio: 1 / 1;
                border: 1px var(--sec) dotted;
                display: flex;  
                align-items: center; 
                justify-content: center;
                color: var(--sec);
            }

            .in{border-radius: 10px;}
            .out{border-radius: 100%;}

        </style>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <h1 class="almendra">Your expenses and incomes<br> date - money - bank account - your notes</h1>
            <section style="margn-top: 3vh; display: block;">

                <?php
                    $sql = "select expenses.inout, expenses.value, banks.name as bank, expenses.notes, TO_CHAR(expenses.created_at, 'DD-MM-YYYY') AS data from expenses inner join banks on expenses.bank=banks.id where expenses.acc=".$id." order by data desc";
                    $result = pg_query($conn, $sql);
                    if(pg_num_rows($result)==0) echo "You have no expesces or incomes yet"; else{
                        while( $row = pg_fetch_assoc($result) ){
                            echo "
                                <div class='list_pos catli'>";

                            if($row['inout']=="in") echo "<span class='inout in'>".$row['inout']."</span>";
                            else echo "<span class='inout out'>".$row['inout']."</span>";
                            echo "
                                <span>".$row['data']."</span>
                                <span>".$row['value']."zł</span>
                                <span>".$row['bank']."</span>
                                <span class='notes'>".$row['notes']."</span>
                            </div>
                            ";
                        }
                        
                    }
                ?>
            </section>
        </main>
        
    </body>
</html>