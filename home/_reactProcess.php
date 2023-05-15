<?php
    include "../utilities/_db.php";

    session_start();
    $username = $_SESSION['username'];

    $data = $_REQUEST['q']; 
    $rawData = json_decode($data);
    $reactVal = $rawData->reactVal;
    $post_id = $rawData->post_id;

   // DATA ISNT DELIVEED SECOND CLICK

    if ($reactVal == "like") {
        
        $check = "SELECT * from liked_posts where `$username` = '$post_id'"; //CHECKS IF THE USER HAS ALREADY LIKED THE POST
        mysqli_query($conn, $check);
        $checkNum = mysqli_num_rows(mysqli_query($conn, $check));  

        if ($checkNum > 0) { 
                // UNLIKLING PROCESS
            $mysql1 = "SELECT * from posts where post_id = '$post_id'";
            mysqli_query($conn, $mysql1);
            $row = mysqli_fetch_assoc(mysqli_query($conn, $mysql1));

            $currentLikeCount = $row['like_count'];
            $newLikeCount = $currentLikeCount - 1;

            $mysql2 = "UPDATE posts SET like_count='$newLikeCount' WHERE post_id = '$post_id'";
            mysqli_query($conn, $mysql2);

            $mysql3 = "DELETE FROM liked_posts WHERE `$username` = '$post_id'";
            mysqli_query($conn, $mysql3);
        }
        else {  // PROCESS IF USER HAS NOT LIKED THE POST
            $mysql1 = "SELECT * from posts where post_id = '$post_id'";
            mysqli_query($conn, $mysql1);
            
            $row = mysqli_fetch_assoc(mysqli_query($conn, $mysql1));
            $currentLikeCount = $row['like_count'];
            $newLikeCount = $currentLikeCount + 1;

            $mysql2 = "UPDATE posts SET like_count='$newLikeCount' WHERE post_id = '$post_id'";
            mysqli_query($conn, $mysql2);

            $mysql3 = "INSERT INTO liked_posts (`$username`) VALUES ('$post_id')";
            mysqli_query($conn, $mysql3);

            $dislikecheck = "SELECT * from disliked_posts where `$username` = '$post_id'"; 
            mysqli_query($conn, $dislikecheck);
            $dislikecheckNum = mysqli_num_rows(mysqli_query($conn, $dislikecheck)); 
            if ($dislikecheckNum == 1) {
                $mysql1 = "SELECT * from posts where post_id = '$post_id'";

                $row = mysqli_fetch_assoc(mysqli_query($conn, $mysql1));

                $currentdisLikeCount = $row['dislike_count'];
                $newdisLikeCount = $currentdisLikeCount - 1;

                $mysql2 = "UPDATE posts SET dislike_count='$newdisLikeCount' WHERE post_id = '$post_id'";
                mysqli_query($conn, $mysql2);

                $mysql3 = "DELETE FROM disliked_posts WHERE `$username` = '$post_id'";
                mysqli_query($conn, $mysql3);
                }
        }        
    
    }


    else if ($reactVal == "dislike") {
        $check = "SELECT * from disliked_posts where $username = '$post_id'"; 
        mysqli_query($conn, $check);
        $checkNum = mysqli_num_rows(mysqli_query($conn, $check));  

        if ($checkNum == 1) {
            $mysql1 = "SELECT * from posts where post_id = '$post_id'";

            $row = mysqli_fetch_assoc(mysqli_query($conn, $mysql1));

            $currentdisLikeCount = $row['dislike_count'];
            $newdisLikeCount = $currentdisLikeCount - 1;

            $mysql2 = "UPDATE posts SET dislike_count='$newdisLikeCount' WHERE post_id = '$post_id'";
            mysqli_query($conn, $mysql2);

            $mysql3 = "DELETE FROM disliked_posts WHERE `$username` = '$post_id'";
            mysqli_query($conn, $mysql3);
        }
        else {
            $mysql1 = "SELECT * from posts where post_id = '$post_id'";

            $row = mysqli_fetch_assoc(mysqli_query($conn, $mysql1));
            $currentdisLikeCount = $row['dislike_count'];

            $newdisLikeCount = $currentdisLikeCount + 1;

            $mysql2 = "UPDATE posts SET dislike_count='$newdisLikeCount' WHERE post_id = '$post_id'";
            mysqli_query($conn, $mysql2);

            $mysql3 = "INSERT INTO disliked_posts (`$username`) VALUES ('$post_id')";
            mysqli_query($conn, $mysql3);

            $likecheck = "SELECT * from liked_posts where `$username` = '$post_id'"; 
            mysqli_query($conn, $likecheck);
            $likecheckNum = mysqli_num_rows(mysqli_query($conn, $likecheck)); 
            if ($likecheckNum == 1) {
                $mysql1 = "SELECT * from posts where post_id = '$post_id'";

                $row = mysqli_fetch_assoc(mysqli_query($conn, $mysql1));

                $currentLikeCount = $row['like_count'];
                $newLikeCount = $currentLikeCount - 1;

                $mysql2 = "UPDATE posts SET like_count='$newLikeCount' WHERE post_id = '$post_id'";
                mysqli_query($conn, $mysql2);

                $mysql3 = "DELETE FROM liked_posts WHERE `$username` = '$post_id'";
                mysqli_query($conn, $mysql3);
                }
        }
    }
?>