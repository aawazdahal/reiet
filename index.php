<?php
  session_start();
  if ($_SESSION['loggedIn'] == True) {
    header("Location: ./home");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      *{
        margin: 0;
        padding: 0;
}

.container{
    background-color: whitesmoke;
    width: 100%;
    height: 661px;
    display: flex;
}

.desc-div{
    width: 50%;   
}

.form-div{
    width: 50%; 
}

.desc-place{  
    width: 100%;
    margin-top: 220px;
}

.desc-place-inside{ 
    width: 70%;
    margin-left: auto;
    margin-right: 0;
}

.desc-place-title{
    font-size: 50px;
    text-align: left;
}
.desc-place-para{
    font-size: 25px;
    text-align: left;
}

.form-place{
    width: 100%;   
    height: 360px;
    margin-top: 135px;
}

.form-place-inside{
    height: 90%;
    background-color: white;
    border-radius: 5px;
    width: 350px;
    box-shadow: 12px;
    margin-right: auto;
    margin-left: 100px;
}

form{
    display: flex;
    flex-direction: column;
}

input{
    width: 85%;
    height: 40px;
    border: solid rgb(179, 176, 176) 1px;
    border-radius: 5px;
    margin-left: 5%;
    margin-right: 5%;
    padding-left: 12px;
    font-size: 18px;
}

.logInBtn{
    width: 80%;
    height: 40px;
    border: none;
    border-radius: 5px;
    margin-left: 10%;
    margin-right: 10%;
    background-color: rgb(190, 69, 238);
    font-size: 20px;
    font-weight: 600;
    color: white;
}

.logInBtn:disabled {
    background-color: rgb(212, 145, 241);
    cursor: auto;
}

button:hover{
    cursor: pointer;
}

p {
    font-family: Verdana;
}
h1 {
    color: rgb(172, 44, 172);
}

.signUpBtn {
    width: 47%;
    height: 35px;
    border: none;
    border-radius: 5px;
    margin-left: 25%;
    margin-right: 10%;
    background-color: cornflowerblue;
    font-size: 13px;
    font-weight: 600;
    color: white;
}

.userError {
    display: none;
}
.passError {
    display: none;
    color: red;
    margin-left: 6%;
    margin-top: 1%;
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
}

@media screen and (max-width: 950px) {
    .container {
        flex-direction: column;
    }
    
    p{
        display: none;
    }
    .desc-place{
        margin-top: 12px;
    }
    .form-place{
       margin-top: 12px;
    }
    .desc-div{
        width: 100%;
    }
    .desc-place-inside {
        margin-left: auto;
        margin-right: auto;
    }
    .desc-place-title {
        text-align: center;
    }
    .form-div{
        width: 100%;
    }
    .form-place-inside {
        margin-left: auto;
        margin-right: auto;
    }
}
    </style>
    <title>Reliet - Log in or sign up</title>
</head>
<body>
    <div class="container">
        <div class="desc-div">
            <div class="desc-place">
                <div class="desc-place-inside">
                    <h1 class="desc-place-title">reliet</h1>
                    <p class="desc-place-para">Share your ideas, interests & opinions with people around your network</p>
                </div>
            </div>
        </div>
        <div class="form-div">
            <div class="form-place">
                <div class="form-place-inside">
                    <form method="POST">
                        <br><br>
                        <input type="text, email" name="username" id="username" placeholder="Username">
                        <span class="userError"></span>
                        <br>
                        <input type="password" name="pass" id="pass" placeholder="Password">
                        <span class="passError" id="passError">Invalid Credentials</span>
                        <br>
                        <button class="logInBtn" id="logInBtn">Log in</button>
                    </form>
                    <br>
                    <button onclick="location.href='./signup'" class="signUpBtn">Create a new account</button>                  
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    
document.getElementById('logInBtn').disabled = true;


document.getElementById('username').onkeyup = fillCheck;
document.getElementById('pass').onkeyup = fillCheck;

function fillCheck() {
    user = document.getElementById('username').value;
    pass = document.getElementById('pass').value;
    
    if (user.length < 3 || pass.length < 4) {
        document.getElementById("logInBtn").disabled = true;
    }
    else {
        document.getElementById("logInBtn").disabled = false;

    }
}

document.getElementById('logInBtn').onclick = logInProcess;

document.getElementById('username').addEventListener('click', function() {
    document.getElementById('username').style.borderColor= 'rgb(179, 176, 176)';
})

document.getElementById('pass').addEventListener('click', function() {
    document.getElementById('pass').style.borderColor= 'rgb(179, 176, 176)';
})



function logInProcess() {
    document.getElementById("logInBtn").disabled = true;

    myData = {
      username: user,
      password: pass
    }
    
    myJson= JSON.stringify(myData);
    
    const request = new XMLHttpRequest();

    request.onload = function(){
        if (this.responseText == 1) {
            location.href= './home';
        }
        else {
            document.getElementById('passError').style.display = 'block';
            document.getElementById('username').style.borderColor= 'orange';
            document.getElementById('pass').style.borderColor= 'orange';
            document.getElementById("logInBtn").disabled = false;
        } 
    }
    
    request.open('GET', '_logInProcess.php?q=' + myJson, true);

    request.send();
}

</script>