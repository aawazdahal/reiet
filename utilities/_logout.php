<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        header('location: ./index.php');
    }
?>

<?php
    session_start();
    session_destroy();
    header("location: ../index.php");
    exit;
?>