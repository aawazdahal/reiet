<?php
    session_start();

    if ($_SESSION['loggedIn'] == True) {
        header("Location: ../home");
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
            height: 400px;
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

        .signUpBtn{
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

        .signUpBtn:disabled {
            background-color: rgb(212, 145, 241);
            cursor: auto;
        }

        button:hover{
            cursor: pointer;
        }

        p {
            font-family: Verdana;
        }
        h2 {
            color: rgb(172, 44, 172);
            font-size: 10px;
        }

        .userError {
            display: none;
            color: red;
            margin-left: 6%;
            margin-top: 1%;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }
        #passError {
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
    <title>Sign up to reliet</title>
</head>
<body>
    <div class="container">
        <div class="desc-div">
            <div class="desc-place">
                <div class="desc-place-inside">
                    <h2 class="desc-place-title">Create a new account</h2>
                    <p class="desc-place-para">Sign up on Reliet & start sharing your ideas</p>
                </div>
            </div>
        </div>
        <div class="form-div">
            <div class="form-place">
                <div class="form-place-inside">
                    
                        <br><br>
                        <input type="text, email" name="username" id="username" placeholder="Username">
                        <span class="userError" id="userError">Username is already taken</span>
                        <br><br>
                        <input type="text, email"  name="email" id="email" required placeholder="Email address">
                        <br>
                        <br>
                        <input type="password" name="pass" id="pass" placeholder="Password">
                        <br><br>
                        <input type="password" name="rPass" id="rPass" placeholder="Confirm Password">
                        <span id="passError">Recheck the password</span>
                        <br><br>
                        <button class="signUpBtn" id="signUpBtn">Sign Up</button>
                                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
document.getElementById('signUpBtn').onclick = signUpProcess;

document.getElementById('pass').addEventListener('click', function() {
    document.getElementById('pass').style.borderColor = "rgb(179, 176, 176)";
}) 

document.getElementById('rPass').addEventListener('click', function() {
    document.getElementById('rPass').style.borderColor = "rgb(179, 176, 176)";
}) 

function signUpProcess() {
    var user = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var pass = document.getElementById('pass').value;
    var rPass = document.getElementById('rPass').value;

    if (user = "" || pass=="" || rPass=="" || email=="") {
        document.getElementById('passError').textContent = "There's a problem creating an account"
        document.getElementById('passError').style.display = "block";
    }
    else if (user.length < 3) {
        console.log(user);
        document.getElementById('userError').textContent = "Username should be at least 3 characters long";
        document.getElementById('userError').style.display = "block";
    }
    else if (pass != rPass) {
        document.getElementById('passError').textContent = "Please re-confirm the password";
        document.getElementById('passError').style.display = "block";
        document.getElementById('pass').style.borderColor = "orange";
        document.getElementById('rPass').style.borderColor = "orange";
    }
    else {     
        var user = document.getElementById('username').value;
        
        var myData = {
            username: user,
            email: email,
            password: pass
        }

        var myJson = JSON.stringify(myData);

        const req = new XMLHttpRequest();

        req.onload = function(){
               if (this.responseText == 1) {
                document.getElementById('userError').textContent = "Username is unavailable";
                document.getElementById('userError').style.display = "block";
               }
               else if (this.responseText == 2) {
                location.href='../home';
               } 
        }
    
        req.open('GET', '_signUpProcess.php?q=' + myJson, true);

        req.send();
    
    }
}
</script>
