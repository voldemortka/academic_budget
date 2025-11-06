<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    $name1 = "";
    $sav = 0;
    $icon1 = "";
    $lim1 = "";

    if(isset($_COOKIE['wanna_edit_name']) && $_COOKIE['wanna_edit_name']!="'none_no_fuck_you'"){
        $name1 = $_COOKIE['wanna_edit_name'];
        $sql = "select savings, icon, lim from categories where name=".$name1;
        $result = pg_query($conn, $sql);

        $row = pg_fetch_assoc($result);
        $icon1 = $row['icon'];
        $sav1 = $row['savings'];
        $lim1 = $row['lim'];
        $edit=1;
    } else $edit=0;

    if(isset($_POST['name']) && isset($_POST['icon']) && $_POST['name']!=""){
        
        if(isset($_POST['savings'])) $sav=1; else $sav=0;

        if(isset($_COOKIE['wanna_edit_name']) && $_COOKIE['wanna_edit_name']!="'none_no_fuck_you'"){
            $sql = "select id from categories where name=".$_COOKIE['wanna_edit_name']."";
            $result = pg_query($conn, $sql);
            $row = pg_fetch_assoc($result);
            $id_cat = $row['id'];
            $sql = "update categories set name='".$_POST['name']."', savings=".$sav.", icon='".$_POST['icon']."' where id=".$id_cat."  ";
            setcookie("wanna_edit_name", "", time() - 36000000, "/");
        } else {
            $sql = "insert into categories (name, icon, acc, curr_money, savings, lim, archive) values ('".$_POST['name']."', '".$_POST['icon']."', ".$id.", 0, ".$sav.", 0, 0 )";
        }
        $result = pg_query($conn, $sql);
        if(!$result){echo "Błąd w bazie danych: " . pg_last_error($conn); die();}
        else{
            setcookie("wanna_edit_name", "", time() - 36000000, "/");
            unset($_COOKIE['wanna_edit_name']);
            header('Location: categories.php');
            exit();
        }
    } 
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget - <?= $edit ? "edit" : "add" ?> a categorie</title>
        <style>

            .label1{
                display: block;
                margin-bottom: 3vh;
            }

            form{
                width: 60vw;
                margin: 15vh auto 0 auto;
            }

            fieldset{display: block;}
        </style>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <h1 class="almendra"><?= $edit ? "Edit" : "Add" ?> a new categorie <?= $edit ? " - ".$name1 : "" ?></h1>
        <a href="categories.php" class='butt' style='font-size: 70%;'>Go back</a>
        
        <form action="add_cat.php" method='post'>
            <label class='label1'>Name the categorie: <input type="text" name="name"></label>
        <!--    <label class='label1'><input type="checkbox" name="savings" <?= $sav ? "checked" : "" ?>>Check this box if you want monay from this categorie to be defaultly moved into savings when a mounth ends. Leave it unchecked if you want the money to be added for the next mounth's limit. You can change it anytime</label>  -->
            <h2 class="almendra">And choose the icon!</h2>
            <fieldset>
                <?php
                    $tab = ["heart", "users-outline", "prenium", "spotify", "music-outline", "camera-outline", "wizyt", "magic", "beaker", "wrench-outline", "video", 
                        "feather", "wristwatch", "desktop", "chart-outline", "scissors-outline", "puzzle", "calculator", "instagram", "lightbulb", "lemon", "ticket", "pen", "cog-outline", "info-outline", "chat-alt", "headphones", 
                        "wifi-outline", "gift", "wine", "tree", "pi-outline", "code-outline", "map", "basket", "globe-outline", "credit-card", "coffee", "anchor", "language", "kartki", "home-outline", "address", "calendar-outline", "chart-pie-outline", "flask", "infinity-outline", "key-outline" ];
                    foreach($tab as $x){
                        if($x == $icon1)
                            echo "<label style='display: inline-block;'><input type='radio' name='icon' value='$x' checked> <i class='icon-$x'></i></label>";
                        else
                            echo "<label style='display: inline-block;'><input type='radio' name='icon' value='$x'> <i class='icon-$x'></i></label>";
                    }
                ?>
                
            </fieldset>
            <button role="submit" class='butt'>Send</button>
        </form>
                </main>
    </body>
</html>