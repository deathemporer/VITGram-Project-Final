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
<head>
<title>Login</title>
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
    h1, h2 {
        text-align: center;
    }
    .myForm {
        display: grid;
        grid-template-columns: [labels] auto [controls] 1fr;
        grid-auto-flow: row;
        grid-gap: .8em;
        border-radius: 10px 10px 10px 10px;
        background: #eee;
        padding: 1.2em;
        width: 50%;
        justify-content: center;
        align-content: center;
        align-items: center;
        margin: 0 auto;
    }
    .myForm>input,
    .myForm>button {
        grid-column: controls;
        grid-row: auto;
        border: none;
        padding: 1em;
    }
    p{
        text-align: center;
    }
    input{
        border-radius: 10px 10px 10px 10px;
    }

    #submit{
        background-color: green;
        color: white;
    }
</style>
</head>
<body>
<h1>Welcome Back
<h2>Login</h2>

<form class="myForm" method=post>
    <input type="text" name="useremail" id="useremail" placeholder="Enter your E-mail" value="<?php if(isset($_COOKIE["useremail"])){ echo $_COOKIE["useremail"];} ?>" required>
    <input type="password" name="userpass" id="userpass" placeholder="Enter your Password" value="<?php if(isset($_COOKIE["userpass"])){ echo $_COOKIE["userpass"];} ?>" required>
    <input type="submit" id="submit" value="Login">
</form>
<p>New User? <a href="register.php"> Register</a>
<p class="required" style="margin: auto;"></p><br>
</p>
</body>
</html>

<?php
$conn = connect();
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A form is posted
     // Login process
        $useremail = $_POST['useremail'];
        $userpass = $_POST['userpass'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE user_email = '$useremail' AND user_password = '$userpass'");
        if($query){
            if(mysqli_num_rows($query) == 1) {
                $row = mysqli_fetch_assoc($query);
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row['user_firstname'] . " " . $row['user_lastname'];
                setcookie("useremail", $useremail, time()+3600);
                setcookie("userpass", $userpass, time()+3600);
                header("location:home.php");
            }
            else {
                ?> <script>
                    document.getElementsByClassName("required")[0].innerHTML = "Invalid Login Credentials.";
                    document.getElementsByClassName("required")[0].innerHTML = "Invalid Login Credentials.";
                </script> <?php
            }
        } else{
            echo mysqli_error($conn);
        }
}
?>
