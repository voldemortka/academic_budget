<?php
    require_once("connect.php");
    $error="";

    if(isset($_POST['name']) && isset($_POST['pass'])){
        $sql = "select password from account where username='".$_POST['name']."'";
        $result = pg_query($conn, $sql);
        if(!$result){echo "Błąd w bazie danych: " . pg_last_error($conn); die();}
        if(pg_num_rows($result)==0) $error="There's no such user";
        else{
            $row = pg_fetch_assoc($result);
            $pass_db = $row['password'];

            if( !password_verify($_POST['pass'], $pass_db) ) $error = "Password incorrect";
        }

        if($error=="") {
            $time = 3600*24*30*12*100;
            setcookie("AB_name", $_POST['name'], time() + $time, "/");
            $sql = "select id from Account where username = '".$_POST['name']."'";
            $result = pg_query($conn, $sql);
            $row = pg_fetch_assoc($result);
            setcookie("AB_id", $row['id'], time() + $time, "/");
            header('Location: index.php');
        }
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget</title>

        <style>
            main{
                width: auto;
            }

            form{
                margin: 10vh auto;
            }

            label{
                display: block;
            }
        </style>
    </head>
    <body>
        <main>

        <h1 class="almendra">Welcome back!</h1>
            
        <?= $error!="" ? "<h1>ERROR</h1><h2>$error</h2>" : ""?>

        <form action="login.php" method='post'>
            <label>Username: <input type="text" name='name'></label>
            <label>Password: <input type="password" name="pass"></label>
            <button class='butt'>Log in</button>
        </form>     
        <a href='signin.php' class='butt' style='font-size: 75%'>I don't have account</a>       

</main>
    </body>
</html>