<?php
    if ($_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'])) {
        header('location: ./index.php');
    }
?>

<?php
     function userIdHash() {     
        $conn = mysqli_connect('localhost', 'root', '', 'users');
        $user_hash = bin2hex(random_bytes(4));
        $sql = "SELECT * from users where user_id='$user_hash'";
        $result = mysqli_num_rows(mysqli_query($conn, $sql));
        if ($result == 1) {
            userIdHash();
        }
        else {
            $user_id = $user_hash;
            return $user_id;
        }  
    }
    
    function postIdHash() {
        $conn = mysqli_connect('localhost', 'root', '', 'users');
        $post_hash = bin2hex(random_bytes(8));
        $sql = "SELECT * from posts where post_id='$post_hash'";
        $result = mysqli_num_rows(mysqli_query($conn, $sql));
        if ($result == 1) {
            postIdHash();
        }
        else {
            $post_id = $post_hash;
            return $post_id;
        } 
    }

?>