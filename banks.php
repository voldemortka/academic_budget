<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    if(isset($_POST['name'])){
        $sql = "insert into banks (name, money, acc) values ('".$_POST['name']."', 0, ".$id.")";
        pg_query($conn, $sql);
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget - banks</title>

        <style>
            .bankli{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 35vw;
                padding: 2vh 0;
                letter-spacing: 2.5px;
            }

            .actions_cat{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 15%;
            }
        </style>

        <script>
            function edit(name){
                document.cookie = `wanna_edit_name_bank='${name}'`;
                document.location.href="rename_bank.php";
            }

            function delete_cat(name){
                if( confirm("Are you sure that you want to delete the account "+name+"? This operation can't be undone and you're gonna lose all the date about all the money set for this account") ){
                    document.cookie = `wanna_del_name_bank='${name}'`;
                    document.location.href="del_bank.php";
                }
            }
        </script>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <h1 class="almendra">All of your bank accounts</h1>
            <form action="banks.php" method='post'>
                <label>Name: <input type="text" name='name'></label>
                <button role='submit' class='butt'>Add new account</button>
            </form>

            <section style='margin-top: 10vh;'>
                <?php
                    $sql = "select name, money from banks where acc=".$id;
                    $result = pg_query($conn, $sql);
                    while($row = pg_fetch_assoc($result)){
                        echo "
                            <div class='list_pos bankli'>
                                <span>".$row['name']."</span> <span>".$row['money']."zł</span>
                                <section class='actions_cat'>
                                    <i class='icon-pen' title='edit' onclick='edit(`".$row['name']."`)'></i>
                                    <i class='icon-trash-2' title='Delete' onclick='delete_cat(`".$row['name']."`)'></i>
                                </section>
                            </div>
                        ";
                    }
                ?>
            </section>
        </main>
    </body>
</html>