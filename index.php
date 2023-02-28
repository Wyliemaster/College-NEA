<?php error_reporting(0); 

if ($_GET["ERROR"])
{
    echo "<script type='text/javascript'>alert('".$_GET["ERROR"]."');</script>";
}
?>

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
            <a href="./user_content/?filter=5" class="global-navbar-item">' . $name . '\'s Code</a>
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
            echo $_GET["default"] ? str_replace("\n", "<br>", $_GET["default"]) : "Input";
            ?>
        </div>
        <div class="main-input-output-buttons">
            <!--
                This button is responsible for decompiling the code
            -->
            <a class="main-input-output-btn" onclick="decompile_assembly()">Decompile</a>

            <!--
                This button is used to upload LMC Machine code and decompile it
            -->
            <input id="upload-file" type="file" style="display:none;" />
            <a class="main-input-output-btn" onclick="upload_file()">Upload File</a>

        <!-- if the user is logged in, show the upload code button-->
        <?php
        if ($_COOKIE["LOGIN"])
            echo '<a class="main-input-output-btn" onclick="upload_code()">Upload Code to Server</a>';
        ?>
        </div>
        <!--
            This is where the Pseudocode is displayed
        -->
        <div class="main-input-output-box" id="output">
            Output
        </div>
    </div>
    <script>load_main_page_prefabs()</script>
</body>
</html>