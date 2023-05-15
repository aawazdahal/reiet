<?php
    include "../utilities/_db.php";
    include "../utilities/_hash.php";

    $myJson = $_REQUEST['q'];
    $myData = json_decode($myJson);
    $username = $myData->username;
    $email = $myData->email;
    $password = $myData->password;

    $mysql = "SELECT * from users where username='$username'";
    $mysqlExe = mysqli_query($conn, $mysql);
    $result = mysqli_num_rows($mysqlExe);

    if ($result == 1) {
        echo 1;
    }
    else {
        $user_id = userIdHash();
        $set = "INSERT INTO users (username, email, password, user_id) VALUES ('$username','$email','$password', '$user_id')";
        $setlikerec = "ALTER TABLE `liked_posts` ADD `$username` VARCHAR(50) NULL;";
        mysqli_query($conn, $setlikerec);

        $setdislikerec = "ALTER TABLE `disliked_posts` ADD `$username` VARCHAR(50) NULL;";
        mysqli_query($conn, $setdislikerec);
        
        if (mysqli_query($conn, $set)) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['loggedIn'] = true;
            echo 2;
        }
        
    } 
?>