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
        <title>Academic budget - your categories</title>

        <script>
            function edit(name){
                document.cookie = `wanna_edit_name='${name}'`;
                document.location.href="add_cat.php";
            }

            function delete_cat(name){
                if( confirm("Are you sure that you want to delete the categorie "+name+"? This operation can't be undone and you're gonna lose all the date about all the money set for this categorie") ){
                    document.cookie = `wanna_del_name='${name}'`;
                    document.location.href="del_cat.php";
                }
            }

            function show_archived(){
                $('.archived').toggleClass('inv');
            }

            function arch(name){
                document.cookie = `wanna_archive_name='${name}'`;
                document.location.href="add_arch.php";
            }

            function wanna_reset(){
                if(confirm("This action can't be undone<br>In all of your categories, the spent money will be reset")){
                    document.location.href="reset_cat.php";
                }
            }

            function add_categorie(){
                document.cookie = `wanna_edit_name='none_no_fuck_you'`;
                document.location.href="add_cat.php";
            }
        </script>

        <style>
            .catli{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 40vw;
                padding: 2vh 0;
            }

            .inv{
                color: var(--bg);
                font-size: 0px;
                width: 0;
                height: 0;
                padding: 0;
                margin: 0;
                border: none;
            }

            .actions_cat{
                display: flex;  
                align-items: center; 
                justify-content: space-between;
                width: 30%;
            }

            .chosen_icon{
                width: 10%;
                aspect-ratio: 1 / 1;
                border: 1px var(--sec) dotted;
                border-radius: 10px;
                display: flex;  
                align-items: center; 
                font-size: 140%;
                justify-content: center;
                color: var(--sec);
            }
        </style>
    </head>
    <body>
        <?php require("side_nav.html"); ?>
        <main>
            <h1 class="almendra">All of your categories</h1>
        <button onclick="add_categorie()" class="butt" >Add a new categorie</button>
        <button class='butt' onclick='show_archived()'>Show or stop showing archived categories</button>
        <button onclick='wanna_reset()' class='butt'>Reset money in categories - start new period</button>
        <section style="margn-top: 3vh; display: block;">
                <?php
                    $sql = "select icon, name, archive from categories where acc=".$id." order by archive desc";
                    $result = pg_query($conn, $sql);
                    if(pg_num_rows($result)==0){
                        echo "You have no categories yet";
                    } else {
                        while($row = pg_fetch_assoc($result)){
                            if($row['archive']) echo "<div class='list_pos catli inv archived'>";
                            else echo "<div class='list_pos catli'>";
                            echo "
                                    <i class='chosen_icon icon-".$row['icon']."'></i>
                                    <p class='name_categorie'>".$row['name']."</p>
                                    <section class='actions_cat'>
                                        <i class='icon-pen' title='edit' onclick='edit(`".$row['name']."`)'></i>
                                        <i class='icon-trash-2' title='Delete' onclick='delete_cat(`".$row['name']."`)'></i>
                                        <i class='icon-block-outline' title='Archive' onclick='arch(`".$row['name']."`)'></i>
                                    </section>
                                </div>
                            ";
                        }
                    }
                ?>
        </section>
                </main>
    </body>
</html>