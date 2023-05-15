<?php

session_start();
    
$myData = $_REQUEST['q'];

$myDataq = json_decode($myData);

$username = $myDataq->username;
$password = $myDataq->password;

$conn = mysqli_connect('localhost', 'root', '', 'users');

$mysql= "SELECT * from users where username='$username' AND password='$password'";

$exe = mysqli_query($conn, $mysql);

$result = mysqli_num_rows($exe);

if ($result == 1) {
    $_SESSION['loggedIn'] = true;
    $_SESSION['username'] = $username;
    echo 1;
}
else {
    echo 0;
}  

?>