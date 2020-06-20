<?php
require 'functions/functions.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header("location:home.php");
}
session_destroy();
session_start();
ob_start();
?>

<!doctype html>
<title>Register</title>
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
    h1, h2, h3 {
        text-align: center;
    }

    h2{
        opacity: 0.5;
    }

    .myForm {
        display: grid;
        grid-template-columns: [labels] auto [controls] 1fr;
        grid-auto-flow: row;
        grid-gap: .8em;
        background: #eee;
        padding: 1.2em;
        width: 50%;
        justify-content: center;
        align-content: center;
        align-items: center;
        margin: 0 auto;
        border-radius: 10px 10px 10px 10px;
    }

    input{
        border-radius: 10px 10px 10px 10px;
    }

    #submit{
        background-color: green;
        color: white;
    }

    .myForm>input,
    .myForm>button {
        grid-column: controls;
        grid-row: auto;
        border: none;
        padding: 1em;
    }
</style>
<h1>Welcome to VITGram</h1>
<h2>Connecting people<h2>
<h3>Register</h3>
<form class="myForm" method=post>
    <span class="required"></span>
    <input type="text" name="fname" id="fname" placeholder="Enter First Name" required>
    <input type="text" name="lname" id="lname" placeholder="Enter Last Name" required>
    <input type="text" name="username" id="username" placeholder="Enter UserName" required>
    <input type="text" name="useremail" id="useremail" placeholder="Enter E-mail" required>
    <input type="password" name="pass" id="pass" placeholder="Enter Password" required>
    <input type="password" name="cpass" id="cpass" placeholder="Confirm Password" required>
    <input type="submit" id="submit" value="Register">
</form>

<?php
    $conn = connect();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userfirstname = $_POST['fname'];
        $userlastname = $_POST['lname'];
        $userusername = $_POST['username'];
        $userpassword = $_POST['pass'];
        $useremail = $_POST['useremail'];
        // Check for Some Unique Constraints
        $query = mysqli_query($conn, "SELECT user_username, user_email FROM users WHERE user_username = '$userusername' OR user_email = '$useremail'");
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);
            if($userusername == $row['user_username'] && !empty($userusername)){
                ?> <script>
                document.getElementsByClassName("required")[0].innerHTML = "This Username already exists.";
                </script> <?php
            }
            if($useremail == $row['user_email']){
                ?> <script>
                document.getElementsByClassName("required")[0].innerHTML = "This Email already exists.";
                </script> <?php
            }
        }
        // Insert Data
        $sql = "INSERT INTO users(user_firstname, user_lastname, user_username, user_email, user_password)
                VALUES ('$userfirstname', '$userlastname', '$userusername', '$useremail', '$userpassword')";
        $query = mysqli_query($conn, $sql);
        if($query){
            $query = mysqli_query($conn, "SELECT user_id FROM users WHERE user_email = '$useremail'");
            $row = mysqli_fetch_assoc($query);
            $_SESSION['user_id'] = $row['user_id'];
            header("location:home.php");
        }
    }
?>
