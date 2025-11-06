<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    $sum=0;

    $sql = "select all_money from account where id=".$id;
    $result = pg_query($conn, $sql);
    $row = pg_fetch_assoc($result);
    $all = $row['all_money'];
    $sql = "select curr_money, lim from categories where acc=".$id;
    $result = pg_query($conn, $sql);
    while($row = pg_fetch_assoc($result)){
        $all += ( $row['lim']-$row['curr_money'] );
        $sum += $row['lim'];
    }

    $left=$all-$sum;

    $tab=[];
    $sql = "select name from categories where acc=".$id;
    $result = pg_query($conn, $sql);
    while($row = pg_fetch_assoc($result)){
        $tab[] = $row['name'];
    }


    if(isset($_POST['x']) && $_COOKIE['lim_OK']){

        $sql = "select name, curr_money from categories where acc=".$id;
        $result = pg_query($conn, $sql);
        while($row = pg_fetch_assoc($result)){
            echo $_POST['l'.$name];
            $limit = $row['curr_money'];
            $limit += $_POST['l'.$row['name']];
            $sql2 = "update categories set lim=".$limit." where name='".$row['name']."' and acc=".$id;
            pg_query($conn, $sql);
        }


        header('Location: index.php');
        exit();

    }



?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <script>
            function check(){
                let tab = <?= json_encode($tab) ?>;
                let sum = 0;
                tab.forEach(name => {
                    sum += +$("#"+name).val();
                });
                $('#sum').html(sum);
                let left = <?= $all ?> - sum;
                $('#left').html(left);
                if($left!=0) document.cookie = "lim_OK = false";
                else ocument.cookie = "lim_OK = true";
            }
        </script>
        <title>Academic budget</title>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
        <form action='change_limits.php' method='post'>
            <input type='radio' name='x' checked>
            <p>And now increase some limits</p>

            <section class='sections'>
                All money: <?= $all ?>
                Set in limits: <div id='sum'><?= $sum ?></div>
                Left: <div id='left'><?= $left ?></div>
                Note: You have to devide all of your money
            </section>

            <section  onchange="check()">
            <?php
                $sql = "select icon, name, curr_money, savings from categories where acc=".$id;
                $result = pg_query($conn, $sql);
                while ($row = pg_fetch_assoc($result)) {
                    echo "
                        <div class='list_pos'>
                            <i class='icon-".$row['icon']."'></i>
                            ".$row['name']."
                            ".$row['curr_money']." zł
                            <fieldset>
                                <label style='display: block;'><input type='radio' name='".$row['name']."' value='save' <?= ".$row['savings']." ? 'checked' : ''?> >Savings</label>
                                <label style='display: block;'><input type='radio' name='".$row['name']."' value='move' <?= !".$row['savings']." ? 'checked' : ''?> >For new mounth</label>
                            </fieldset>
                            <label style='display: block;'>New limit: <input type='number' name='l".$row['name']."'></label>
                        </div>
                    ";
                }
                


            ?>
            </section>

            <button role='submit' class='butt'>Save</button>
            
        </form>
            </main>
    </body>
</html>