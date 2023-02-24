<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header('location: ./index.php');
}
?>

<?php
include "../utilities/_db.php";

include "index.php";

$text = $_REQUEST["q"];

// POSTING SECTION CODE STARTS HERE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $datestamp = date("jS M Y");
  $sql = "INSERT INTO posts (username, posts, display_date) VALUES ('$username', '$text', '$datestamp')";
  if (mysqli_query($conn, $sql)) {
    ;
  }
}
?>