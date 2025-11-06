<?php
    require_once("connect.php");
    $error="";

    if(isset($_POST['name']) && isset($_POST['pass1']) && isset($_POST['pass2'])){
        $sql = "select id from Account where username='".$_POST['name']."'";
        $result = pg_query($conn, $sql);
        if(!$result){echo "Błąd w bazie danych: " . pg_last_error($conn); die();}
        if(pg_num_rows($result)!=0) $error="This username is already used";
        else{
            if($_POST['pass1']!=$_POST['pass2']) $error="Passwords aren't equal";
        }

        if($error=="") {
            $pass_hash = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
            $sql = "insert into Account (username, password, all_money, savings) values ('".$_POST['name']."', '".$pass_hash."', 0, 0)";
            pg_query($conn, $sql);
            $time = 3600*24*30*12*100;
            setcookie("AB_name", $_POST['name'], time() + $time, "/");
            $sql = "select id from account where username = '".$_POST['name']."'";
            $result = pg_query($conn, $sql);
            $row = pg_fetch_assoc($result);
            $id = $row['id'];
            $sql = "insert into banks (name, acc, money) values ('cash', ".$id.", 0)";
            pg_query($conn, $sql);
            //   echo $row[0]."  ---  ".$row['id'];
            setcookie("AB_id", $id, time() + $time, "/");
          //  if(!isset($_COOKIE['AB_id'])) echo "chuj 1";
          //  if(!isset($_COOKIE['AB_name'])) echo "chuj 2";
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

        <h1 class="almendra">Welcome to the Academic Budget, new one!</h1>
            
        <?= $error!="" ? "<h1>ERROR</h1><h2>$error</h2><a><>" : ""?>

        <form action="signin.php" method='post'>
            <label>Username: <input type="text" name='name'></label>
            <label>Password: <input type="password" name="pass1"></label>
            <label>Repeat password: <input type="password" name="pass2"></label>
            <button class='butt'>Create an account</button>
        </form>     
        <a href='login.php' class='butt' style='font-size: 75%;'>I have account</a>       

</main>
    </body>

</html>
