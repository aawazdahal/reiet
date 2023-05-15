<?php
  if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header('location: ./index.php');
  }
?>

<?php
  include "../utilities/_db.php";
  include "../utilities/_hash.php";
  include "index.php";
  
  $text = strval($_REQUEST["q"]);
  
  // POSTING SECTION CODE STARTS HERE
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datestamp = date("jS M Y");
    $post_id = postIdHash();
    $sql = "INSERT INTO posts (username, posts, display_date, post_id) VALUES ('$username', '$text', '$datestamp', '$post_id')";
    if (mysqli_query($conn, $sql)) {
      ;
    }
  }
?>
