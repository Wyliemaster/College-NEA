<?php error_reporting(0); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="frontend/css/main.css">
    <link rel="stylesheet" href="frontend/css/home.css">
     <script src="./frontend/scripts/main.js"></script>
</head>
<body>
    <div class="global-navbar">
        <div>
            <a href="#" class="global-navbar-item">Home</a>
            <a href="#" class="global-navbar-item">User Content</a>
        </div>
        <div id="global-navbar-account">
            <a href="#" class="global-navbar-item">Login</a>
            <a href="#" class="global-navbar-item">Register</a>
        </div>
    </div>

    <div class="main-input-output">
        <div class="main-input-output-box" contenteditable="true" id="input"> <!--contenteditable allows the user to edit the field-->

        </div>
        <div class="main-input-output-buttons">
            <a class="main-input-output-btn" onclick="decompile_assembly()">Decompile</a>
            <a class="main-input-output-btn" href="">Upload File</a>
            <a class="main-input-output-btn" href="">Upload Code to Server</a>
        </div>
        <div class="main-input-output-box" id="output">
        </div>

    </div>
</body>
</html>