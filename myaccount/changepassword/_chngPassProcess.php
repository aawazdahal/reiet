<?php
    include "/xampp/htdocs/reliet/utilities/_db.php";

    $myJson = $_REQUEST['q']; // RETRIVE JSON DATA FROM JAVASCRIPT FILE

    $myData = json_decode($myJson); // CONVERTS JSON DATA INTO A PHP OBJECT

    $oldPass = $myData->oldPass;
    $newPass = $myData->newPass;
    $username = $myData->username;

    $mysql = "SELECT * from users where username = '$username'";

    $mySqlExe = mysqli_query($conn, $mysql);

    $result = mysqli_fetch_assoc($mySqlExe);

    $currentPass = $result['password'];

    if ($currentPass != $oldPass) {
        echo 1;
    }
    elseif ($oldPass == $newPass) {
        echo 2;
    }
    else {
        $mysql2 = "UPDATE users SET password='$newPass' WHERE username = '$username'";
        if (mysqli_query($conn, $mysql2)) {
            echo 3;
        }
    }

?>