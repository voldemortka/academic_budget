<?php
    require_once("connect.php");
    $error="";

    if(isset($_POST['name'])){

            $sql = "insert into Account (name) values ('".$_POST['name']."')";
            pg_query($conn, $sql);
            $time = 3600*24*30*12*100;
            setcookie("AB_name", $_POST['name'], time() + $time, "/");
            header('Location: index.php');
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' href='style.css' type='text/css'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta hettp-equiva='X-UA-Compatible' content='IE-edge.chrome=1' />
        <link rel='website icon' href='' type='png'/>
        <link rel='stylesheet' href='css/fontello.css' type='text/css'/>
        <script src="main.js"></script>
        <title>Academic budget</title>
    </head>
    <body>
            
        <?= $error!="" ? "<h1>ERROR</h1><h2>$error</h2><a><>" : ""?>;

        <form action="" method='post'>
            <label>Username: <input type="text" name='name'></label>
            <button>Log in</button>
        </form>     

        
    </body>
</html>