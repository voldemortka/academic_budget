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
        <title>Academic budget</title>

        <script>
            function logout(){
                document.cookie = "AB_id=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
                document.cookie = "AB_name=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
                document.location.href="login.php";
            }
        </script>

        <style>
            a{
                text-decoration: none;
                color: var(--sec);
            }

            .head{
                font-size: 20px;
            }


            h1{
                text-align: center;
                font-size: 50px;
            }

            h2{
                font-size: 35px;
            }

            #sec_left{
                width: 50%;
                margin: 4vh 2%;
                text-align: center;
                float: left;
            }

            #sec_right{
                float: left;
                width: 40%;
                margin-top: 4vh;
            }

            .left_div{
                margin-top: 5vh;
            }
        </style>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <h1 class="almendra">Welcome to Academic Budget</h1>
            <section id='sec_left'>
                <h2 class="almendra">Your accounts:</h2>
                <?php
                    $sql = "select name, money from banks where acc=".$id;
                    $result = pg_query($conn, $sql);
                    while($row = pg_fetch_assoc($result)){
                        echo "<p class='left_div'>".$row['name']."<br>".$row['money']."zł</p>";
                    }
                ?>
            </section>
            <section id='sec_right'>
                <h2 class="almendra">This period:</h2>
                <div>
                    <p>You still have (only categorized money):
                        <?php
                            $sql = "select sum(curr_money) as still_have, sum(lim) as limits from categories where acc=".$id;
                            $result = pg_query($conn, $sql);
                            $row = pg_fetch_assoc($result);
                            echo $row['still_have'];
                            $lim = $row['limits'] - $row['still_have'];
                        ?>
                        zł
                    </p>
                    <p>You sent:  <?=$lim?>zł</p>
                </div>
            </section>
        </main>
        
    </body>
</html>