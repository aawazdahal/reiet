<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        header('location: ./check.php');
    }
?>

<?php
    $conn = mysqli_connect('localhost', 'root', '', 'users');

    $username = $_REQUEST["q"];

    $sql = "SELECT * from users where username = '$username'";

    $exe  = mysqli_query($conn, $sql);

    $status = mysqli_num_rows($exe);

    if ($status == 1) {
        echo 0;
    }
    else {
        echo 1;
    }
?>
