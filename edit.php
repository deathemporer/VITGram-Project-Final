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
<html>

<head>
  <title>My Profile</title>
  <link rel="stylesheet" href="public/stylesheets/edit.css">
  <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
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
        body{
        	background-color: transparent;
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
<div id="container">
  <form class="form-horizontal" method="post" enctype="multipart/form-data">
    <h1>Edit Profile</h1><br>
      <div class="form-group">
        <label class="control-label col-sm-2" for="username">Username:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="username" name="username" placeholder="Enter New UserName">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="dp">Display Picture:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="dp" name="dp" placeholder="Display Picture Link">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <input type="submit" class="btn btn-default" id="submit" name="Make Changes" value="Make Changes"></input>
        </div>
      </div>
    </form>
    </div>
  <div id="footer">
  <form method="POST"  action=logout.php>
        <input type="submit" name="Logout" value="Logout"></input>
	</form>
    </div>
</body>

</html>

<?php
	$conn = connect();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $dp = $_POST['dp'];
        $uid = $_SESSION['user_id'];
          if($username!="")
          $sql = 'UPDATE users set user_username="'.$username.'"where user_id="'.$uid.'";';

          else if($dp!="")
          $sql = 'UPDATE users set user_dp="'.$dp.'"where user_id="'.$uid.'";';

          else
            $sql = 'UPDATE users set user_username="'.$username.'", user_dp="'.$dp.'"where user_id="'.$uid.'";';

        $query = mysqli_query($conn, $sql);
        if($query){
          echo "<script>alert(\'Changes made to profile\');</script>";

        }
        else
        echo mysqli_error($conn);
	}
?>
