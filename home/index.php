<?php
  include "../utilities/_db.php";             // SESSION FUNCTIONS AND INCLUDING FUNCTIONS 
  
  session_start();

  if ($_SESSION['loggedIn'] != True) {
    header("Location: ../index.php");
  }

  $username = $_SESSION['username'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RELIET</title>
    <link rel="shortcut icon" href="https://imgs.search.brave.com/-JgpzW-wYPgg_5qwmXTPRu5M0ftRossmu6LUgZlRwi4/rs:fit:800:800:1/g:ce/aHR0cDovL3d3dy5j/bGlwYXJ0YmVzdC5j/b20vY2xpcGFydHMv/ZWlNL2s5ci9laU1r/OXJheVQuanBn" type="image/x-webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
      #likeBtn {
        background: none;
      }

      #likeBtn:hover {
        background-color: green;
        color: white;
      }
      #dislikeBtn:hover {
        background-color: black;
        color: white;
      }
    </style>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">RELIET</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Sports</a></li>
            <li><a class="dropdown-item" href="#">Technologies</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <button class="btn btn-success" onclick="location.href='../myaccount'">My Account</button>
        </li>
        <form class="d-flex" role="search">
        <input onkeyup="userSearch()" class="form-control mx-5" style="width: 300px" type="search" placeholder="Search users" aria-label="Search">
      </form>
      </ul>
      <li class="nav-item">
          <button class="btn btn-primary" onclick="location.href='../utilities/_logout.php'">Log Out</button>
      </li>
    </div>
  </div>
</nav>
<div class="container mx-2" style="flex-direction: row">
  <h1>Latest Posts</h1>
  
  <?php 
    // HOME FEEDS DISPLAY SECTION STARTS HERE
    $sql2 = "SELECT * from posts ORDER by sn DESC";   // DISPLAYING POSTS PROCESS
    $result2 = mysqli_query($conn, $sql2);

    $post_ids = array();

    $likeStat = array();    // ARRAY TO CHECK IF THE POST IS LIKED OR DISLIKED BY THE USER
    $disLikeStat = array();

    $i = 0;

    while ($row2 = mysqli_fetch_assoc($result2)) {   // LOOPING THE PROCESS THROUGH EACH POST
      $desc = $row2['posts'];
      $display_date = $row2['display_date']; 
      $likeCount = $row2['like_count'];

      $post_id = $row2['post_id'];
      $post_ids[$i] = $post_id;

      $likechk = "SELECT * from liked_posts where `$username` = '$post_id'";
      mysqli_query($conn, $likechk);
      $likeNum = mysqli_num_rows(mysqli_query($conn, $likechk));

      if ($likeNum == 1) {
        $likeStat[$i] = true;
        $dislikeStat[$i] = false;
      }

      $disLikechk = "SELECT * from disliked_posts where `$username` = '$post_id'";
      mysqli_query($conn, $disLikechk);
      $disLikeNum = mysqli_num_rows(mysqli_query($conn, $disLikechk));

      if ($disLikeNum == 1) {
        $disLikeStat[$i] = true;
        $likeStat[$i] = false;
      }


      $i = $i + 1;
      $dislikeCount = $row2['dislike_count']; // DATA SYNTHESIS OF EACH USER AND POST
      $user = $row2['username'];
      $verChk = "SELECT * from users where username = '$user'";
      $verChkConfirm = mysqli_query($conn, $verChk);
      $verChkUser = mysqli_fetch_assoc($verChkConfirm);
      $verBool = $verChkUser['verification'];
      if ($verBool == 1){
        $vBadge = '<img style="width: 18px"src="https://miro.medium.com/max/800/1*fFUnF8o4URvCowXSacCgGA.jpeg">';
      }
      else{
        $vBadge = '';
      }
     
      echo '<div class="card">

              <div  class="card-header" style="display: flex">
                <img style="width: 3.5%; margin-right: 0.5%" src="https://imgs.search.brave.com/LZWMwMYighRobOnIxKjwvfkpEhzakLjzUY4-2MccZM4/rs:fit:860:880:1/g:ce/aHR0cHM6Ly93d3cu/a2luZHBuZy5jb20v/cGljYy9tLzI0LTI0/ODcyOV9zdG9ja3Zh/ZGVyLXByZWRpY3Rl/ZC1hZGlnLXVzZXIt/cHJvZmlsZS1pbWFn/ZS1wbmctdHJhbnNw/YXJlbnQucG5n" alt="">
                <p>'.$user.'  '.$vBadge.'</p>
                <p style="margin-left: 82%;">' .$display_date.'</p>
              </div>

              <div class="card-body">
                <h5 style="font-size: 90%"class="card-title">' .$desc.    '</h5>
              </div>

              <div class="card-header" style="display: flex">
                <button style="display: flex;"  id="likeBtn" class="likeBtn btn btn-outline-primary">Like <span style="margin-left: 2px" class="likeCount">'.$likeCount.'</span> </button>
                <button style="margin-left: 3px" id="dislikeBtn" class="dislikeBtn btn btn-outline-primary">Dislike <span style="margin-left: 2px" class="dislikeCount">'.$dislikeCount.'</span></button>
              </div>
              
            </div>
            <br>';
    }

  ?>
<div>
  <button  type="button" style=" position: fixed; right: 45px; bottom: 58px;"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Create a post</button>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create a post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- POSTING FORM STARTS HERE -->        
          <div class="mb-3">
            <label for="message-text" class="col-form-label"><?php echo '@'.$username ?> </label>
            <textarea id="postArea" class="form-control" name="status" placeholder="Type something....." id="message-text"></textarea>
          </div>
          <button id="postButton" class="btn btn-primary">Post</button>  
        <!-- POSTING FORM ENDS HERE -->
      </div>
  </div>
</div>   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>

<script>
  document.getElementById('postButton').disabled = true;

  document.getElementById('postArea').onkeyup = press;

  document.getElementById('postButton').onclick = postFunction;

  

  function press() {
    var value = document.getElementById('postArea').value;
    
    if (value == "") {
      document.getElementById('postButton').disabled = true;
    }
    else {
      document.getElementById('postButton').disabled = false;
    }
  }

  function postFunction() {
    var text = document.getElementById('postArea').value;
    if (text == "") {
      ;
    }
    else {
      document.getElementById('postButton').disabled = true;
      const request = new XMLHttpRequest();
      request.onload = function() {
        location.reload();
      }
      request.open('POST', '_postProcess.php?q=' + text);
      request.send();
    }
  }

  const likeBtns = document.getElementsByClassName('likeBtn');
  const dislikeBtns = document.getElementsByClassName('dislikeBtn');
  const likeCounts = document.getElementsByClassName('likeCount');
  const dislikeCounts = document.getElementsByClassName('dislikeCount');


  var liked = [];
  var disliked = [];

  let likeStat = <?= json_encode($likeStat) ?>;
  let disLikeStat = <?= json_encode($disLikeStat) ?>;

  for (let i = 0; i < likeBtns.length; i++) {
    liked[i] = false;
    disliked[i] = false;

    if (likeStat[i] == true) {
        likeBtns[i].style.backgroundColor = "green";
        likeBtns[i].style.color = "white";

        liked[i] = true;
        disliked[i] = false;

        dislikeBtns[i].style.background = "none";
        dislikeBtns[i].style.color = "blue";  
    }

    if (disLikeStat[i] == true) {
        dislikeBtns[i].style.backgroundColor = "black";
        dislikeBtns[i].style.color = "white"; 

        disliked[i] = true;
        liked[i] = false;
        
        likeBtns[i].style.background = "none";
        likeBtns[i].style.color = "blue";

    }
    
    likeBtns[i].addEventListener('click', function() {
      if (liked[i] == false) {
        likeBtns[i].style.backgroundColor = "green";
        likeBtns[i].style.color = "white";

        likeCounts[i].textContent = parseInt(likeCounts[i].textContent) + 1;

        likeCounts[i].textContent =  likeCounts[i].textContent;
        
        if (disliked[i] == true) {
          dislikeCounts[i].textContent = parseInt(dislikeCounts[i].textContent) - 1;

          dislikeCounts[i].textContent =  dislikeCounts[i].textContent;

        }
        
       
        dislikeBtns[i].style.background = "none";
        dislikeBtns[i].style.color = "blue";      
      
        liked[i] = true; 
        disliked[i] = false;
      }
      else if (liked[i] == true) {
        likeBtns[i].style.background = "none";
        likeBtns[i].style.color = "blue";

        
        likeCounts[i].textContent = parseInt(likeCounts[i].textContent) - 1;

        likeCounts[i].textContent =  likeCounts[i].textContent;

      

        liked[i] = false;
      }

      let likeReq = new XMLHttpRequest();

      let postids = <?= json_encode($post_ids) ?>;

      var reqData = {
        reactVal: "like",
        post_id:  postids[i]
      }

      let reqDataJSON = JSON.stringify(reqData);

      likeReq.onload = function() {
        ;
      }

      likeReq.open('POST', '_reactProcess.php?q=' + reqDataJSON);

      likeReq.send();

    })







  dislikeBtns[i].addEventListener('click', function() {

    if (disliked[i] == true) {
      dislikeBtns[i].style.background = "none";
      dislikeBtns[i].style.color = "blue";

      dislikeCounts[i].textContent = parseInt(dislikeCounts[i].textContent) - 1;

      dislikeCounts[i].textContent =  dislikeCounts[i].textContent;

      disliked[i] = false;
    }
    else if (disliked[i] == false) {
      dislikeBtns[i].style.backgroundColor = "black";
      dislikeBtns[i].style.color = "white";

      likeBtns[i].style.background = "none";
      likeBtns[i].style.color = "blue"

      if (liked[i] == true) {
        likeCounts[i].textContent = parseInt(likeCounts[i].textContent) - 1;

        likeCounts[i].textContent =  likeCounts[i].textContent;

      }

      dislikeCounts[i].textContent = parseInt(dislikeCounts[i].textContent) + 1;

      dislikeCounts[i].textContent =  dislikeCounts[i].textContent;

      disliked[i] = true;
      liked[i] = false;
    }

    let disLikeReq = new XMLHttpRequest();

    let postids = <?= json_encode($post_ids) ?>;

    var reqData = {
      reactVal: "dislike",
      post_id:  postids[i]
    }

    let reqDataJSON = JSON.stringify(reqData);

    disLikeReq.onload = function() {
      ;
    }

    disLikeReq.open('POST', '_reactProcess.php?q=' + reqDataJSON);

    disLikeReq.send();
    
  });

  }


</script>