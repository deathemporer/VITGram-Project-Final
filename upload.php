<?php
require 'functions/functions.php';
require 'functions/logout.php';
session_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
$temp = $_SESSION['user_id'];
session_destroy();
session_start();
$_SESSION['user_id'] = $temp;
ob_start();
// Establish Database Connection
$conn = connect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a new post</title>
    <style>
        html {
            background: #B3FFAB;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #12FFF7, #B3FFAB);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #12FFF7, #B3FFAB);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            font-family: 'Montserrat', sans-serif;
        }


        #container {
        	padding-top:20px;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        h1 {
        	padding-top: 50px;
            text-align: center;
            border-bottom;: 1px solid #cccccc;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        #submit {
            width: 100%;
            border: none;
            border-radius: 10px;
            outline: none;
            font-family: montserrat;
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

        #post{
            font-family: montserrat;
        }

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

    </style>
</head>

<body>
	<div id="topbar">
		<a href="home.php" id="homebut"><img class ="icon" src="public\images\home.png"></a>
		<a href="search.php" id="searchbut"><img class ="icon" src="public\images\search.png"></a>
		<a href="upload.php" id="uploadbut"><img class ="icon" src="public\images\plus.png"></a>
		<a href="recents.php" id="recentbut"><img class ="icon" src="public\images\heart.png"></a>
		<a href="profile.php" id="profbut"><img class ="icon" src="public\images\user.png"></a>
	</div>
    <h1>Add a new post</h1>
    <hr style="color: #cccccc; width:50%;">
    <div id="container">
        <form method="post" enctype="multipart/form-data">
            <p>Add post</p>
            <input type="text" name="post" id="post">
            <p>Add location</p>
            <input type="text" name="loc" id="loc">
            <p>Add caption</p>
            <input type="text" name="caption" id="caption">
            <br>
            <br>
            <input id="submit" type="submit" value="Upload">
        </form>
    </div>
    <div id="footer">
    <form method="POST" action="logout.php">
        <input type="submit" name="Logout" value="Logout"></input>
	</form>
    </div>
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') { // Form is Posted
    // Assign Variables
    $caption = $_POST['caption'];
    $image = $_POST['post'];
    $location = $_POST['loc'];
    $poster = $_SESSION['user_id'];
    // Apply Insertion Query
    $sql = "INSERT INTO posts (post, post_caption, post_location, post_time, post_by)
            VALUES ('$image', '$caption', '$location', NOW(), $poster)";
    $query = mysqli_query($conn, $sql);
    // Action on Successful Query
    header("location: home.php");
}
?>

