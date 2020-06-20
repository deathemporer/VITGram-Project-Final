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

<?php
	$conn = connect();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		logout();
	}
?>