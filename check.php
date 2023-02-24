<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Username Check</title>
</head>
<body>
    <div>
        <input style="padding-left:4px; height:20px; border: solid black 1px; border-radius:8px" id="username" type="text" style="padding-left: 4px" placeholder="Username">
        <button style="height: 20px; border: solid black 1px; border-radius: 8px" id="btn" onclick="process()">Check Status</button>
        <br><br>
        <span style="font-family: Cascadia Code;" id="para"></span>
    </div>
</body>
</html>

<script>
    function process() {
        var username = document.getElementById('username').value;

        if (username == "" || username.length < 3) {
            document.getElementById('para').style.color = "orange";
            document.getElementById('para').textContent = "Please enter a username";
        }
        else{
            const request = new XMLHttpRequest();

            request.open('GET', 'req.php?q=' + username);

            request.onload = function() {
                if (this.responseText == 1) {
                    document.getElementById('para').style.color = "green";
                    document.getElementById('para').textContent = "Username is available";
                }
                else{
                    document.getElementById('para').style.color = "red";
                    document.getElementById('para').textContent = "Username is already taken";
                }
                
            }

            request.send();
        }
    }
</script>