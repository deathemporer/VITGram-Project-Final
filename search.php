<?php
//
require 'functions/functions.php';
require 'functions/logout.php';
session_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establish Database Connection
$conn = connect();

?>

<!DOCTYPE html>
<html>
<head>
	<title>VITgram | Search</title>
	<link rel="stylesheet" type="text/css" href="public\stylesheets\search.css">
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

		#searchbar{
			border-radius: 10px 10px 10px 10px;
		}

		#submit{
			border: none;
			border-radius: 10px 10px 10px 10px;
			background-color: green;
			color: white;
			width: 100px;
			float: right;
		}

		#notfound{
			text-align: center;
			text-size: large;
			margin: auto;
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
	<br>

	<div id="body">
		<div id="searchbar">
			<form method="post" class="myForm">	
				<input type="text" id="searchitem" name="searchitem" placeholder="Search a Name">
				<input type="submit" id="submit" name="Search">
			</form>
		</div>
		<div style="width:100%;">
		<span id="notfound"></span>
		</div>

		<div id="result">
			<ul id="searchresult" type="none">
			<?php
				$conn = connect();
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$key = $_POST['searchitem'];
					$name = explode(' ', $key, 2); // Break String into Array.
					if(empty($name[1])) {
						$sql = "SELECT * FROM users WHERE users.user_firstname = '$name[0]' OR users.user_lastname= '$name[0]'";
					} else {
						$sql = "SELECT * FROM users WHERE users.user_firstname = '$name[0]' AND users.user_lastname= '$name[1]'";
					}
					$query = mysqli_query($conn, $sql);
					if(!$query){
						echo mysqli_error($conn);
					}
					if(mysqli_num_rows($query) == 0){
						?> <script>
						document.getElementById("notfound").innerHTML="User not found.";
						</script> <?php
					} 
					else{
						while($row = mysqli_fetch_assoc($query)){
							echo "<a class=\"profilelink\" href=\"profile.php?id=" . $row['user_id'] ."\">";
							echo "<div id=\"rslt\" style=\"border-radius:10px 10px 10px 10px;\">";
								echo '<li>';
									echo "<div id=\"dp\"><img class=\"profpic\" src=\"".$row['user_dp']."\"></div>";
									echo "<div id=\"uname\">".$row['user_username']."</div>";
								echo '</li>';
							echo '</div>';
							echo '</a>';
							echo '<br>';
						}
					}
				}
			?>
		</div>
		
	</div>
	<div id="footer">
	<form method=post action="logout.php">
        <input type="submit" name="Logout" value="Logout"></input>
	</form>
    </div>
</body>
</html>



