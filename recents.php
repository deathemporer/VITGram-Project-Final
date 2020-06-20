<?php
require 'functions/functions.php';
require 'functions/logout.php';
session_start();
ob_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establish Database Connection
$conn = connect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notifications</title>

    <style>
    #footer{
            left: 0;
            bottom: 0;
            z-index: 1;
            height: 30px;
            width: 100%;
            background-color: #FAFAFA;
            position: fixed;
            text-align: right;
            padding-top: 10px;
        }
        #footer input{
            background-color: #faaaaa;
            border: none;
            border-radius: 10px 10px 10px 10px;
            margin-right: 10px;
            width: 100px;
        }
        html{
            background: #B3FFAB;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #12FFF7, #B3FFAB);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #12FFF7, #B3FFAB);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            font-family: 'Montserrat', sans-serif;
            }

            #head{
            border-bottom: 0.5px solid #ccc;
            width: 100%;
            left: 0;
            top: 0;
            padding-top: 50px;
            }

            h1{
                text-align: center;
            }

            #topbar{
            background-color: #FAFAFA;
            border-bottom: 0.5px solid #ccc;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            }
            #topbar a{
                display: inline-block;
                width: 20%;
                margin-left: -4px;
                text-align: center;
                padding: 0px;
                box-sizing: border-box;
            }

            #topbar a:hover{
            background-color: #ccc;
            }
            #topbar img{
                width: 50px;
                height: 50px;
            }
            .flex-container{
                display: flex;
                width: 100%;
                justify-content: space-evenly;
            }
            #div1{
                display: inline-block;
                width: 50%;
                text-align: center;
            }




</style>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
    <div id="topbar">
        <a href="home.php" id="homebut"><img class ="icon" src="public\images\home.png"></a>
        <a href="search.php" id="searchbut"><img class ="icon" src="public\images\search.png"></a>
        <a href="upload.php" id="uploadbut"><img class ="icon" src="public\images\plus.png"></a>
        <a href="recents.php" id="recentbut"><img class ="icon" src="public\images\heart.png"></a>
        <a href="profile.php" id="profbut"><img class ="icon" src="public\images\user.png"></a>
    </div>
    <div id="head"><h1>Recents</h1></div>
    <div class="flex-container">
        <div id="div1">
            <h3>Posts</h3>
            <?php
                $sql = "SELECT * from posts";
                $conn = connect();
                $query = mysqli_query($conn, $sql);
                if(!$query){
                    echo mysqli_error($conn);
                }
                if(mysqli_num_rows($query) == 0){
                    ?> <script>
                    document.getElementById("notfound").innerHTML="No posts.";
                    </script> <?php
                }
                else{
                    while($row = mysqli_fetch_assoc($query)){
                        $sql2 = "SELECT user_username, user_id from users where user_id=\"".$row['post_by']."\"";
                        $query3 = mysqli_query($conn, $sql2);
                        $row3 = mysqli_fetch_assoc($query3);
                        echo '<p><a class="profilelink" href="profile.php?id='. $row["post_by"] .'">'.$row3['user_username'].'</a>posted a picture. '.$row['post_time'].'</p>';
                        ;
                    }
                }
                ?>
               </div>
        <div id="div1">
            <h3>Comments</h3>
            <?php
                $sql = "SELECT * from comments";
                $conn = connect();
                $query = mysqli_query($conn, $sql);
                if(!$query){
                    echo mysqli_error($conn);
                }
                if(mysqli_num_rows($query) == 0){
                    ?> <script>
                    document.getElementById("notfound").innerHTML="No posts.";
                    </script> <?php
                }
                else{
                    while($row = mysqli_fetch_assoc($query)){
                        $sql2 = "SELECT user_username from users where user_id=\"".$row['comment_by']."\"";
                        $sql3 = "SELECT post_by from posts where post_id=\"".$row['post_id']."\"";
                        $query4 = mysqli_query($conn, $sql3);
                        $row5 = mysqli_fetch_assoc($query4);
                        $sql4 = "SELECT user_username from users where user_id=\"".$row5['post_by']."\"";
                        $query5 = mysqli_query($conn, $sql4);
                        $row6 = mysqli_fetch_assoc($query5);
                        $query3 = mysqli_query($conn, $sql2);
                        $row3 = mysqli_fetch_assoc($query3);
                        //$query6 = mysqli_query($conn, $sql2);
                        //$row7 = mysqli_fetch_assoc($query6);
                        echo "<p>"."<a class=\"profilelink\" href=\"profile.php?id=" . $row3['user_username'] ."\">".$row3['user_username']."</a>"." commented on "."<a class=\"profilelink\" href=\"profile.php?id=" . $row6['user_username'] ."\">".$row6['user_username']."'s"."</a>"." picture</p>";
                    }
                }
                ?>
        </div>
    </div>
    <div id="footer">
    <form method="POST" action="logout.php">
        <input type="submit" name="Logout" value="Logout"></input>
	</form>
    </div>
</body>

</html>
