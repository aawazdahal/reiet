<?php
  include "/xampp/htdocs/reliet/utilities/_db.php";

  session_start();
  if ($_SESSION['loggedIn'] != True) {
    header("Location: ../home");
  }
  $username = $_SESSION['id'];
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
      <a class="navbar-brand" href="#">RELIET</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <button class="btn btn-primary" onclick="location.href='logout.php'">Log Out</button>
      </ul>
    </div>
  </div>
  </nav>

<div style="display: none" id="alertBox" class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong id="alertText"></strong>
</div>

<div class="container mx-2">
  <h1 class="" style="text-align: left;">Change password</h1>
  <br>  
    <input id="oPass" type="password" placeholder="Old password" required name="old-pass"><br><br>
    <input id="nPass" type="password" placeholder="New password" required name="new-pass"><br><br>
    <button id="chngPassButton" class="btn btn-primary">Change password</button>
</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>


<script>
  document.getElementById('chngPassButton').addEventListener("click", process);
  
  function clearErrors() {
    document.getElementById('alertText').textContent = "";
    document.getElementById('alertBox').style.display = "none";
  }

  function process() {
    var oldPass = document.getElementById('oPass').value;
    var newPass = document.getElementById('nPass').value;

    var username = '<?= $username ?> ' ;

    clearErrors();

    var alertBox = document.getElementById('alertBox');
    var alertText = document.getElementById('alertText');

    if (oldPass == "") {
      alertText.textContent = "Old Password can't be empty";
      alertBox.style.display = "block";
    }
    else if (newPass == ""){
      alertText.textContent = "New Password can't be empty";
      alertBox.style.display = "block";
    }
    else {
      const request = new XMLHttpRequest();

      var myData = {
        oldPass: oldPass,
        newPass: newPass,
        username: username
      }

      var myJson = JSON.stringify(myData);
      
      request.open('GET', '_chngPassProcess.php?q=' + myJson);

      request.onload = function() {
        if (this.responseText == 1) {
          alertText.textContent = "Please enter your old password correctly";
          alertBox.style.display = "block";
        }
        else if (this.responseText == 2) {
          alertText.textContent = "Old password can't be the new password";
          alertBox.style.display = "block";
        }
        else {
          alertText.textContent = "Password changed successfuly";
          alertBox.style.display = "block";
        }
      }

      request.send();
    }
  }
</script>