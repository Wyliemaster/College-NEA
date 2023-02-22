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
    <script src="./frontend/scripts/prefab.js"></script>
    <script src="./frontend/scripts/helpers.js"></script>


</head>

<body>
    <div class="global-navbar">
        <div>
            <a href="./" class="global-navbar-item">Home</a>
            <a href="./user_content/" class="global-navbar-item">User Content</a>
        </div>
        <div class=global-navbar-title>
            <label>Little Man Computer Decompiler</label>
        </div>

        <?php

        if (!isset($_COOKIE["LOGIN"]) && !isset($_COOKIE["NAME"])) {
            echo '<div id="global-navbar-account">
                <a onclick="show_login_popup()" class="global-navbar-item">Login</a>
                <a onclick="show_register_popup();" class="global-navbar-item">Register</a>
            </div>';
        } else {
            $name = $_COOKIE["NAME"] != "" ? $_COOKIE["NAME"] : "[[NAME]]";
            echo '<div id="global-navbar-account">
            <a href="./user_content/?myCode='.$_COOKIE["LOGIN"].'" class="global-navbar-item">' . $name . '\'s Code</a>
            <a onclick="logout()" class="global-navbar-item">Logout</a>
        </div>';
        }

        ?>

    </div>

    <div id="Prefabs"></div>


    <div class="main-input-output">
        <!--contenteditable allows the user to edit the field-->
        <div class="main-input-output-box" contenteditable="true" id="input">
            <?php
                echo $_GET["default"] ? $_GET["default"] : "Input";
            ?>
        </div>
        <div class="main-input-output-buttons">
            <a class="main-input-output-btn" onclick="decompile_assembly()">Decompile</a>

            <input id="upload-file" type="file" style="display:none;" />
            <a class="main-input-output-btn" onclick="upload_file()">Upload File</a>

            <a class="main-input-output-btn" href="">Upload Code to Server</a>
        </div>
        <div class="main-input-output-box" id="output">
            Output
        </div>

    </div>

    <script>
        load_main_page_prefabs()
    </script>

</body>

</html>