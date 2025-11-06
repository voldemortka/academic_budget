<?php
    if(isset($_COOKIE['AB_id']) && isset($_COOKIE['AB_name'])) {
        $id = $_COOKIE['AB_id'];
        $name = $_COOKIE['AB_name'];
        require_once("connect.php");
    } else {
        header('Location: login.php');
        exit();
    }

    if(isset($_POST['name']) && isset($_POST['icon'])){
        if(isset($_POST['savings'])) $sav=1; else $sav=0;

        $sql = "insert into categories (name, icon, acc, curr_money, savings) values ('".$_POST['name']."', '".$_POST['icon']."', ".$id.", 0, ".$sav." )";
        $result = pg_query($conn, $sql);
        if(!$result){echo "Błąd w bazie danych: " . pg_last_error($conn); die();}
        else echo "Added";
    } else {
        $sql = "";
    }

?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <?php require("head.html") ?>
        <title>Academic budget</title>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
        <a href="categories.php" class="add_new_cat">Go back</a>

        <form action="add_cat.php" method='post'>
            <label>Name the categorie: <input type="text" name="name"></label>
            <label><input type="checkbox" name="savings">Check this box if you want monay from this categorie to be defaultly moved into savings when a mounth ends. Leave it unchecked if you want the money to be added for the next mounth's limit. You can change it anytime</label>
            <fieldset>
                <?php
                    $tab = ["heart", "users-outline", "prenium", "spotify", "music-outline", "camera-outline", "wizyt", "magic", "beaker", "wrench-outline", "video", 
                        "feather", "wristwatch", "desktop", "chart-outline", "scissors-outline", "puzzle", "calculator", "instagram", "lightbulb", "lemon", "ticket", "pen", "cog-outline", "info-outline", "chat-alt", "headphones", 
                        "wifi-outline", "gift", "wine", "tree", "pi-outline", "code-outline", "map", "basket", "globe-outline", "credit-card", "coffee", "anchor", "language", "kartki", "home-outline", "address", "calendar-outline", "chart-pie-outline", "flask", "infinity-outline", "key-outline" ];
                    foreach($tab as $x){
                        echo "<label><input type='radio' name='icon' value='$x'> <i class='icon-$x'></i></label>";
                    }
                    //<button type='submit' role='submit'>Save</button>
                ?>
                
            </fieldset>
            <input type="submit" value='send'>
        </form>
                </main>
    </body>
</html>