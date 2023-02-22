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
</head>

<body>
    <div class="global-navbar">
        <div>
            <a href="#" class="global-navbar-item">Home</a>
            <a href="#" class="global-navbar-item">User Content</a>
        </div>
        <div class=global-navbar-title>
            <label>Little Man Computer Decompiler</label>
        </div>
        <div id="global-navbar-account">
            <a href="#" class="global-navbar-item">Login</a>
            <a href="#" class="global-navbar-item">Register</a>
        </div>
    </div>

    <div id="test"></div>


    <div class="main-input-output">
        <!--contenteditable allows the user to edit the field-->
        <div class="main-input-output-box" contenteditable="true" id="input">
            <label>Input</label>
        </div>
        <div class="main-input-output-buttons">
            <a class="main-input-output-btn" onclick="decompile_assembly()">Decompile</a>

            <input id="upload-file" type="file" style="display:none;" />
            <a class="main-input-output-btn" onclick="upload_file()">Upload File</a>

            <a class="main-input-output-btn" href="">Upload Code to Server</a>
        </div>
        <div class="main-input-output-box" id="output">
            <label>Output</label>
        </div>

    </div>



    <script>
        // For testing purposes
        load_prefab("popup", "test", {
            "[[POPUP_TITLE]]": "Title",
            "[[POPUP_DESC]]": "Desc",
            "[[POPUP_CONTAINER]]": "Container"
        });
    </script>


</body>

</html>