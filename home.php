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
<html>
<head>
	<title>VITgram | Home</title>
	<link rel="stylesheet" type="text/css" href="public\stylesheets\home.css">
	<script>
    function pictureChange()
    {
          	document.getElementById("theImage").src="public\images\heart3.png";
    }
</script>

<style>#footer{
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

		#
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
	
	
	
	<div id="body">
		<br>
		<span id="notfound"></span>
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
				$pid = $row['post_id'];
				$sql2 = "SELECT user_dp, user_username from users where user_id=\"".$row['post_by']."\"";
				$query3 = mysqli_query($conn, $sql2);
				$row3 = mysqli_fetch_assoc($query3);
				echo '<div id=\'post\' style=\"margin-top: 30px;\">';
				echo '<div id=\'info\'>';
				//echo	"<div id=\'infopic\'><img class=\"profpic\" src=\"public\\images\\dp.jpg\"></div>";
				echo	"<div id=\'infopic\'><img class=\"profpic\" src=\"".$row3['user_dp']."\"></div>";
				echo	'<div id=\'infoetc\'>';
						echo "<div id=\"profile\">".$row3['user_username']."</div>";
						echo "<div id=\"loc\">".$row['post_location']."</div>";
					echo '</div>';
					echo '<div id=\'time\'>';
						echo "<div id=\"uptime\">".$row['post_time']."</div>";
						//echo "<div id=\"uptime\">".$row['post_time']."</div>";
					echo '</div>';
				echo '</div>';
				echo '<div id=\'pic\'>';
					echo "<img class=\'photo\' src=\"".$row['post']."\">";
					echo "<p style=\"text-align: center;\">".$row['post_caption']."</p>";
				echo '</div>';
				echo '<div id=\'likecomment\'>';
					
					//echo '<div id=\'likes\'>';
					//	echo '<div id=\'likebutton\'><button id=\'like\' onclick=\'pictureChange()\'><img id=\'theImage\' class=\'icon\' src=\'public\images\heart2.png\'></button>';
					//	echo '</div>';
					//	echo "<div id=\"nlikes\">".$row['post_likes']." likes</div>";
					//echo '</div>';
					echo '<div id=\'comment\'>';
					//code for comments
					$sql3 = "Select * from comments where post_id=".$row['post_id'].";";
					$row4 = mysqli_query($conn, $sql3);
					
						echo '<ul type=\'none\'>';
						while($row2 = mysqli_fetch_assoc($row4)){
							$sql4 = "select user_username from users where user_id=\"".$row2['comment_by']."\"";
							$query5 = mysqli_query($conn, $sql4);
							$row5 = mysqli_fetch_assoc($query5);
							echo '<li>';
								echo "<div id=\"commenter\">".$row5['user_username']."</div>";
								echo "<div id=\"cominfo\" style=\"margin-left:10px;\">".$row2['comments']."</div>";
							echo '</li>';
						}
						echo '</ul>';
					echo '</div>';
					echo '<div id=\'addcom\'>';
						echo '<div id=\'writecom\'>';
							echo '<form method=post>';
							echo "<input id=\'com\' type=\"text\" name=\"com\" placeholder=\"Write a comment\">";
							echo "<input type=\"hidden\" id=\'pid\' name=\"pid\" value=\"".$row['post_id']."\">";
							echo "<input type=\"submit\" name=\"Post\" value=\"Post\" style=\"background-color:green; color:white; width:100px; border-radius:10px 10px 10px 10px; margin:auto;\"></form>";
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<br><br><br>';
					}
		echo '</div>';
		
		}
	?>

	<div id="footer">
	<form method=post action="logout.php">
        <input type="submit" name="Logout" value="Logout"></input>
	</form>
    </div>
</body>
</html>


<?php
    $conn = connect();
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$pid = $_POST['pid'];
		$comm = $_POST['com'];
		$comby = $_SESSION['user_id'];
		echo $pid.$comm.$comby;
        $sql = "INSERT into comments (comments, comment_by, post_id) values ('$comm', '$comby', '$pid')";
		$query = mysqli_query($conn, $sql);
		header('location: home.php');
	}
?>



