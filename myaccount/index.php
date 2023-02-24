<?php
  include "../utilities/_db.php";
  
  session_start();
  if ($_SESSION['loggedIn'] != True) {
    header("Location: ../home");
  }

  $username = $_SESSION['id'];
  $sql = "SELECT * from users where username = '$username'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result); // FETCH DATAS FROM THE WHOLE ROW 
  $_SESSION['email'] = $row['email'];
  $_SESSION['verification'] = $row['verification'];
  if ($_SESSION['verification'] == 1) {
    $verDisplay = True;
    $vBadge = '<img style="width: 18px"src="https://miro.medium.com/max/800/1*fFUnF8o4URvCowXSacCgGA.jpeg">';
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RELIET</title>
    <link rel="shortcut icon" href="https://imgs.search.brave.com/-JgpzW-wYPgg_5qwmXTPRu5M0ftRossmu6LUgZlRwi4/rs:fit:800:800:1/g:ce/aHR0cDovL3d3dy5j/bGlwYXJ0YmVzdC5j/b20vY2xpcGFydHMv/ZWlNL2s5ci9laU1r/OXJheVQuanBn" type="image/x-webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body>

  <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../home">RELIET</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>

        <button class="btn btn-primary" onclick="location.href='../utilities/logout.php'">Log Out</button>
      </ul>
    </div>
  </div>
  </nav>

<div id="alertBox" style="display: none" class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong id="alertText"></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="container mx-2">
  <h1 class="" style="text-align: left;">My Account</h1>
  
  <div>
    <img style="width: 10%" src="https://imgs.search.brave.com/LZWMwMYighRobOnIxKjwvfkpEhzakLjzUY4-2MccZM4/rs:fit:860:880:1/g:ce/aHR0cHM6Ly93d3cu/a2luZHBuZy5jb20v/cGljYy9tLzI0LTI0/ODcyOV9zdG9ja3Zh/ZGVyLXByZWRpY3Rl/ZC1hZGlnLXVzZXIt/cHJvZmlsZS1pbWFn/ZS1wbmctdHJhbnNw/YXJlbnQucG5n" alt="">
    <p> USERNAME:  <?php echo $_SESSION['id'].'    '; if ($verDisplay == True) {echo '<img style="width: 18px"src="https://miro.medium.com/max/800/1*fFUnF8o4URvCowXSacCgGA.jpeg">';} ?> </p>
    <p> EMAIL:  <?php echo $_SESSION['email'];  ?> </p>
  </div>

  <div class=" container ac-settings">
    <a style="text-decoration: none" href="./changepassword">Change password</a><br>
    <button onclick="verRequest()" style="border-radius: 10px">Request Verification</button>
  </div>

  <div>
    <br>
    <h2 style="font-size: 28px">Posts</h2>

    <?php 
      $sql2 = "SELECT * from posts where username = '$username' ORDER by sn DESC";
      $result2 = mysqli_query($conn, $sql2);
      $num = mysqli_num_rows($result2);
      
      if ($num == 0) {
        echo '<div class="card text-center">
                <div class="card-header">
                  No posts
                </div>
              </div>';
      }
      else {
        while($row2 = mysqli_fetch_assoc($result2)) {
          $desc = $row2['posts'];
          $display_date = $row2['display_date'];
          if ($verDisplay == True) {
            $vBadge = '<img style="width: 18px"src="https://miro.medium.com/max/800/1*fFUnF8o4URvCowXSacCgGA.jpeg">';
          }
          echo '<div class="card">
                  <div  class="card-header" style="display: flex">
                    <img style="width: 3.5%; margin-right: 0.5%" src="https://imgs.search.brave.com/LZWMwMYighRobOnIxKjwvfkpEhzakLjzUY4-2MccZM4/rs:fit:860:880:1/g:ce/aHR0cHM6Ly93d3cu/a2luZHBuZy5jb20v/cGljYy9tLzI0LTI0/ODcyOV9zdG9ja3Zh/ZGVyLXByZWRpY3Rl/ZC1hZGlnLXVzZXIt/cHJvZmlsZS1pbWFn/ZS1wbmctdHJhbnNw/YXJlbnQucG5n" alt="">
                    <p>'.$username.'  '.$vBadge.'</p>
                    <p style="margin-left: 82%;">' .$display_date.'</p>
                  </div>
                  <div class="card-body">
                    <h5 style="font-size: 90%"class="card-title">' .$desc.    '</h5>
                  </div>
                </div><br>';
        }
      }
    ?>    
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>