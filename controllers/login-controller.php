<?php

session_start();

// include("./DB/connection.php");
$dbConnection = mysqli_connect('localhost', 'root', '', 'MalcolmDB');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];
    $getQuery = "SELECT * FROM users WHERE userEmail='$username' AND userPassword='$password'";
    $result = mysqli_query($dbConnection,$getQuery);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_row($result);
        $_SESSION['isLogin'] = true;
        $_SESSION['userName'] = $username;
        $_SESSION['userId'] = $row[0];

        $queLogin="UPDATE users SET userIslogin = true,lastLogin = now() WHERE id = $row[0]";
        if (mysqli_query($dbConnection, $queLogin)) {
            header("Location:../enquiries_manage.php");
        } else {
            echo mysqli_error($dbConnection);
            header("Location:../login.php?error=Login failed!! please try again.");
        }
    } else {
        header("Location:../login.php?error=User not found!! please enter valid username and password.");
    }
} else {
    header("Location:../login.php?error=Invalid data!! please enter valid details.");
}
